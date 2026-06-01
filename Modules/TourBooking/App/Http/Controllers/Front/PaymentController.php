<?php

namespace Modules\TourBooking\App\Http\Controllers\Front;

use Exception;
use Stripe\Charge;
use Stripe\Stripe;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Currency\App\Models\Currency;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Modules\PaymentGateway\App\Models\PaymentGateway;
use Modules\Coupon\App\Http\Controllers\CouponController;
use Modules\TourBooking\App\Models\Booking;
use Modules\TourBooking\App\Models\Service;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{


    public $payment_setting;

    public function __construct()
    {
        $payment_data = PaymentGateway::all();

        $this->payment_setting = array();

        foreach ($payment_data as $data_item) {
            $payment_setting[$data_item->key] = $data_item->value;
        }

        $this->payment_setting  = (object) $payment_setting;
    }


    public function stripe_payment(Request $request)
    {

        $auth_user = Auth::guard('web')->user();

        $calculate_price = $this->calculate_price();

        $stripe_currency = Currency::findOrFail($this->payment_setting->stripe_currency_id);

        $payable_amount = round($calculate_price['total_amount'] ?? 0 * $stripe_currency->currency_rate, 2);

        Stripe::setApiKey($this->payment_setting->stripe_secret);

        $customerInfo = $this->customerInfo($request);

        try {
            $result = Charge::create([
                "amount" => $payable_amount * 100,
                "currency" => $stripe_currency->currency_code ?? 'USD',
                "source" => $request->stripeToken,
                "description" => env('APP_NAME')
            ]);
        } catch (Exception $ex) {
            Log::info('Stripe payment : ' . $ex->getMessage());

            $notify_message = trans('translate.Something went wrong, please try again' . $ex->getMessage());
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }

        $this->create_order($auth_user, 'Stripe', 'success', $result->balance_transaction, $customerInfo);

        $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('user.bookings.index')->with($notify_message);
    }


    public function paypal_payment(Request $request)
    {

        $this->setCustomerInfoSession($request);

        $calculate_price = $this->calculate_price();

        $paypal_currency = Currency::findOrFail($this->payment_setting->paypal_currency_id);

        $payable_amount = round($calculate_price['total_amount'] ?? 0 * $paypal_currency->currency_rate, 2);

        config(['paypal.mode' => $this->payment_setting->paypal_account_mode]);

        if ($this->payment_setting->paypal_account_mode == 'sandbox') {
            config(['paypal.sandbox.client_id' => $this->payment_setting->paypal_client_id]);
            config(['paypal.sandbox.client_secret' => $this->payment_setting->paypal_secret_key]);
        } else {
            config(['paypal.live.client_id' => $this->payment_setting->paypal_client_id]);
            config(['paypal.live.client_secret' => $this->payment_setting->paypal_secret_key]);
            config(['paypal.live.app_id' => 'APP-80W284485P519543T']);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.paypal-success-payment'),
                "cancel_url" => route('payment.paypal-faild-payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $paypal_currency->currency_code,
                        "value" => $payable_amount
                    ]
                ]
            ]
        ]);


        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        } else {
            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }


    public function paypal_success_payment(Request $request)
    {

        $customerInfo = Session::get('customer_info');

        $paypal_currency = Currency::findOrFail($this->payment_setting->paypal_currency_id);

        config(['paypal.mode' => $this->payment_setting->paypal_account_mode]);

        if ($this->payment_setting->paypal_account_mode == 'sandbox') {
            config(['paypal.sandbox.client_id' => $this->payment_setting->paypal_client_id]);
            config(['paypal.sandbox.client_secret' => $this->payment_setting->paypal_secret_key]);
        } else {
            config(['paypal.live.client_id' => $this->payment_setting->paypal_client_id]);
            config(['paypal.live.client_secret' => $this->payment_setting->paypal_secret_key]);
            config(['paypal.live.app_id' => 'APP-80W284485P519543T']);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $auth_user = Auth::guard('web')->user();

            $this->create_order($auth_user, 'Paypal', 'success', $request->PayerID, $customerInfo);

            $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
            return redirect()->route('user.bookings.index')->with($notify_message);
        } else {


            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }

    public function paypal_faild_payment(Request $request)
    {
        $notify_message = trans('translate.Something went wrong, please try again');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
        return redirect()->back()->with($notify_message);
    }


    public function razorpay_payment(Request $request)
    {

        $input = $request->all();

        $customerInfo = $this->customerInfo($request);

        $api = new Api($this->payment_setting->razorpay_key, $this->payment_setting->razorpay_secret);

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $payId = $response->id;

                $auth_user = Auth::guard('web')->user();

                $order = $this->create_order($auth_user, 'Razorpay', 'success', $payId, $customerInfo);

                $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
                $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
                return redirect()->route('user.bookings.index')->with($notify_message);
            } catch (Exception $e) {
                Log::info('Razorpay payment : ' . $e->getMessage());
                $notify_message = trans('translate.Something went wrong, please try again');
                $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
                return redirect()->back()->with($notify_message);
            }
        } else {
            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }


    public function flutterwave_payment(Request $request)
    {

        $customerInfo = $this->customerInfo($request);

        $curl = curl_init();
        $tnx_id = $request->tnx_id;
        $url = "https://api.flutterwave.com/v3/transactions/$tnx_id/verify";
        $token = $this->payment_setting->flutterwave_secret_key;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer $token"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if ($response->status == 'success') {

            $auth_user = Auth::guard('web')->user();

            $order = $this->create_order($auth_user, 'Flutterwave', 'success', $tnx_id, $customerInfo);

            $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
            return response()->json(['status' => 'success', 'message' => $notify_message]);
        } else {
            $notify_message = trans('translate.Something went wrong, please try again');
            return response()->json(['status' => 'faild', 'message' => $notify_message]);
        }
    }


    public function paystack_payment(Request $request)
    {

        $customerInfo = $this->customerInfo($request);

        $reference = $request->reference;
        $transaction = $request->tnx_id;
        $secret_key = $this->payment_setting->paystack_secret_key;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secret_key",
                "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $final_data = json_decode($response);
        if ($final_data->status == true) {

            $auth_user = Auth::guard('web')->user();

            $order = $this->create_order($auth_user, 'Paystack', 'success', $transaction, $customerInfo);

            $notification = trans('translate.Your payment has been made successful. Thanks for your new purchase');
            return response()->json(['status' => 'success', 'message' => $notification]);
        } else {
            $notification = trans('translate.Something went wrong, please try again');
            return response()->json(['status' => 'faild', 'message' => $notification]);
        }
    }



    public function mollie_payment(Request $request)
    {

        if (env('APP_MODE') == 'DEMO') {
            $notify_message = trans('translate.This Is Demo Version. You Can Not Change Anything');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }

        $this->customerInfo($request);
        $this->setCustomerInfoSession($request);

        $auth_user = Auth::guard('web')->user();

        try {

            $calculate_price = $this->calculate_price();

            $mollie_currency = Currency::findOrFail($this->payment_setting->mollie_currency_id);

            $price = $calculate_price['total_amount'] ?? 0 * $mollie_currency->currency_rate;
            $price = sprintf('%0.2f', $price);

            $mollie_api_key = $this->payment_setting->mollie_key;

            $currency = strtoupper($mollie_currency->currency_code);

            Mollie::api()->setApiKey($mollie_api_key);

            $payment = Mollie::api()->payments()->create([
                'amount' => [
                    'currency' => $currency,
                    'value' => '' . $price . '',
                ],
                'description' => env('APP_NAME'),
                'redirectUrl' => route('payment.mollie-callback'),
            ]);

            $payment = Mollie::api()->payments()->get($payment->id);

            Session::put('payment_id', $payment->id);

            return redirect($payment->getCheckoutUrl(), 303);
        } catch (Exception $e) {
            Log::info('Mollie payment : ' . $e->getMessage());
            $notify_message = trans('translate.Please provide valid mollie api key');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }


    public function mollie_callback(Request $request)
    {

        $customerInfo = Session::get('customer_info');

        $mollie_api_key = $this->payment_setting->mollie_key;
        Mollie::api()->setApiKey($mollie_api_key);
        $payment = Mollie::api()->payments->get(session()->get('payment_id'));
        if ($payment->isPaid()) {

            $auth_user = Auth::guard('web')->user();

            $order = $this->create_order($auth_user, 'Mollie', 'success', session()->get('payment_id'), $customerInfo);

            $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
            return redirect()->route('user.dashboard')->with($notify_message);
        } else {

            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }


    public function instamojo_payment(Request $request)
    {
        if (env('APP_MODE') == 'DEMO') {
            $notify_message = trans('translate.This Is Demo Version. You Can Not Change Anything');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }

        $this->customerInfo($request);
        $this->setCustomerInfoSession($request);

        $auth_user = Auth::guard('web')->user();

        $calculate_price = $this->calculate_price();

        $instamojo_currency = Currency::findOrFail($this->payment_setting->instamojo_currency_id);

        $price = $calculate_price['total_amount'] ?? 0 * $instamojo_currency->currency_rate;
        $price = round($price, 2);

        try {
            $environment = $this->payment_setting->instamojo_account_mode;
            $api_key = $this->payment_setting->instamojo_api_key;
            $auth_token = $this->payment_setting->instamojo_auth_token;

            if ($environment == 'Sandbox') {
                $url = 'https://test.instamojo.com/api/1.1/';
            } else {
                $url = 'https://www.instamojo.com/api/1.1/';
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url . 'payment-requests/');
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    "X-Api-Key:$api_key",
                    "X-Auth-Token:$auth_token"
                )
            );
            $payload = array(
                'purpose' => env("APP_NAME"),
                'amount' => $price,
                'phone' => '918160651749',
                'buyer_name' => Auth::user()->name,
                'redirect_url' => route('payment.instamojo-callback'),
                'send_email' => true,
                'webhook' => 'http://www.example.com/webhook/',
                'send_sms' => true,
                'email' => Auth::user()->email,
                'allow_repeated_payments' => false
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);
            return redirect($response->payment_request->longurl);
        } catch (Exception $e) {
            Log::info('Instamojo payment : ' . $e->getMessage());
            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }

    public function instamojo_callback(Request $request)
    {

        $input = $request->all();

        $customerInfo = Session::get('customer_info');

        $environment = $this->payment_setting->instamojo_account_mode;
        $api_key = $this->payment_setting->instamojo_api_key;
        $auth_token = $this->payment_setting->instamojo_auth_token;

        if ($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"
            )
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {

            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        } else {
            $data = json_decode($response);
        }

        if ($data->success == true) {
            if ($data->payment->status == 'Credit') {

                $auth_user = Auth::guard('web')->user();

                $order = $this->create_order($auth_user, 'Instamojo', 'success', $request->get('payment_id'), $customerInfo);

                $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
                $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
                return redirect()->route('user.bookings.index')->with($notify_message);
            }
        } else {

            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }


    public function paymob_payment(Request $request)
    {
        $this->customerInfo($request);
        $this->setCustomerInfoSession($request);

        $calculate_price = $this->calculate_price();
        $payable_amount = round($calculate_price['total_amount'] ?? 0, 2);

        try {
            // Step 1: Authentication
            $auth_response = Http::post('https://accept.paymob.com/api/auth/tokens', [
                'api_key' => $this->payment_setting->paymob_api_key,
            ]);

            $token = $auth_response->json()['token'];

            // Step 2: Order Registration
            $order_response = Http::post('https://accept.paymob.com/api/ecommerce/orders', [
                'auth_token' => $token,
                'delivery_needed' => 'false',
                'amount_cents' => $payable_amount * 100,
                'currency' => 'EGP',
                'items' => [],
            ]);

            $order_id = $order_response->json()['id'];

            // Step 3: Payment Key Generation
            $auth_user = Auth::guard('web')->user();
            $billing_data = [
                "apartment" => "NA",
                "email" => $auth_user->email,
                "floor" => "NA",
                "first_name" => $auth_user->name,
                "street" => "NA",
                "building" => "NA",
                "phone_number" => $auth_user->phone ?? '01000000000',
                "shipping_method" => "NA",
                "postal_code" => "NA",
                "city" => "Cairo",
                "country" => "Egypt",
                "last_name" => $auth_user->name,
                "state" => "NA"
            ];

            $payment_key_response = Http::post('https://accept.paymob.com/api/accept/payment_keys', [
                'auth_token' => $token,
                'amount_cents' => $payable_amount * 100,
                'expiration' => 3600,
                'order_id' => $order_id,
                'billing_data' => $billing_data,
                'currency' => 'EGP',
                'integration_id' => $this->payment_setting->paymob_integration_id,
            ]);

            $payment_token = $payment_key_response->json()['token'];
            $iframe_id = $this->payment_setting->paymob_iframe_id;

            return redirect("https://accept.paymob.com/api/accept/cards/iframe/{$iframe_id}?payment_token={$payment_token}");

        } catch (Exception $e) {
            Log::info('Paymob payment : ' . $e->getMessage());
            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }

    public function paymob_callback(Request $request)
    {
        $hmac_config = $this->payment_setting->paymob_hmac;
        $data = $request->all();

        // Sort keys alphabetically
        ksort($data);

        $hmac_concatenation = '';
        $expected_keys = [
            'amount_cents', 'created_at', 'currency', 'error_occured', 'has_parent_transaction',
            'id', 'integration_id', 'is_3d_secure', 'is_auth', 'is_capture', 'is_refunded',
            'is_standalone_payment', 'is_voided', 'order', 'owner', 'pending', 'source_data_pan',
            'source_data_sub_type', 'source_data_type', 'success'
        ];

        // Paymob HMAC calculation is specific to certain keys in a specific order if not using the whole object.
        // Usually it's: amount_cents, created_at, currency, error_occured, has_parent_transaction, id, integration_id, is_3d_secure, is_auth, is_capture, is_refunded, is_standalone_payment, is_voided, order, owner, pending, source_data_pan, source_data_sub_type, source_data_type, success
        
        foreach ($expected_keys as $key) {
            if (isset($data[$key])) {
                $value = $data[$key];
                if ($value === true) $value = "true";
                if ($value === false) $value = "false";
                $hmac_concatenation .= $value;
            }
        }

        $calculated_hmac = hash_hmac('sha512', $hmac_concatenation, $hmac_config);

        if ($calculated_hmac == $request->hmac) {
            if ($request->success == "true") {
                $auth_user = Auth::guard('web')->user();
                $customerInfo = Session::get('customer_info');
                
                $this->create_order($auth_user, 'Paymob', 'success', $request->id, $customerInfo);

                $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
                $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
                return redirect()->route('user.bookings.index')->with($notify_message);
            } else {
                $notify_message = trans('translate.Payment failed, please try again');
                $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
                return redirect()->route('tour-booking.book.checkout.view')->with($notify_message);
            }
        } else {
            $notify_message = trans('translate.HMAC verification failed');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->route('tour-booking.book.checkout.view')->with($notify_message);
        }
    }


    public function bank_payment(Request $request)
    {

        $request->validate([
            'tnx_info' => 'required|max:255'
        ], [
            'tnx_info.required' => trans('translate.Transaction field is required')
        ]);

        $customerInfo = $this->customerInfo($request);

        $auth_user = Auth::guard('web')->user();

        $order = $this->create_order($auth_user, 'Bank Payment', 'pending', $request->tnx_info, $customerInfo);

        $notify_message = trans('translate.Your payment has been made. please wait for admin payment approval');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('user.bookings.index')->with($notify_message);
    }

    public function cash_payment(Request $request)
    {

        $customerInfo = $this->customerInfo($request);

        $auth_user = Auth::guard('web')->user();

        $order = $this->create_order($auth_user, 'Cash Payment', 'pending', 'cash', $customerInfo);

        $notify_message = trans('translate.Your payment has been made. please wait for admin payment approval');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('user.bookings.index')->with($notify_message);
    }

    public function create_order($user, $payment_method, $payment_status, $transaction_id, $customerInfo = [])
    {

        $calculate_price = $this->calculate_price();

        $payment_cart = session()->get('payment_cart');

        $service = Service::findOrFail($payment_cart['service_id']);

        $order = new Booking();
        $order->is_per_person = $service->is_per_person ?? 0;
        $order->booking_code = uniqid();
        $order->service_id = $service->id;
        $order->user_id  = $user->id;
        $order->check_in_date  = $payment_cart['check_in_date'];
        $order->check_out_date  = $payment_cart['check_out_date'];
        $order->check_in_time  = $payment_cart['check_in_time'];
        $order->check_out_time  = $payment_cart['check_out_time'];
        $order->adults  = $payment_cart['person_count'] ?? 0;
        $order->children  = $payment_cart['child_count'] ?? 0;
        $order->service_price  = $service?->discount_price ?? $service?->full_price ?? 0;
        $order->adult_price  = $service->price_per_person ?? 0;
        $order->child_price  = $service->child_price ?? 0;
        $order->extra_charges  = $payment_cart['extra_charges'] ?? 0;
        $order->extra_services = $payment_cart['extra_services'] ?? [];
        $order->discount_amount  = $service->discount_price ?? 0;
        $order->subtotal  = $calculate_price['sub_total_amount'] ?? 0;
        $order->total  = $calculate_price['total_amount'] ?? 0;
        $order->paid_amount  = $calculate_price['total_amount'] ?? 0;
        $order->payment_method = $payment_method;
        $order->booking_status = $payment_status == 'success' ? 'success' : 'pending';
        $order->payment_status = $payment_status;
        $order->customer_name = $customerInfo['customer_name'] ?? '';
        $order->customer_email = $customerInfo['customer_email'] ?? '';
        $order->customer_phone = $customerInfo['customer_phone'] ?? '';
        $order->customer_address = $customerInfo['customer_address'] ?? '';

        $order->save();

        if (Session::get('coupon_code') && Session::get('offer_percentage')) {
            $coupon_history = new CouponController();
            $coupon_history->store_coupon_history($user->id, $calculate_price['coupon_amount'] ?? 0, Session::get('coupon_code'));
        }

        session()->forget('payment_cart');
        session()->forget('customer_info');

        return $order;
    }


    public function calculate_price()
    {

        $payment_cart = session()->get('payment_cart', []);

        $sub_total_amount = $payment_cart['total'] ?? 0;
        $coupon_amount = 0;

        if (Session::get('coupon_code') && Session::get('offer_percentage')) {
            $offer_percentage = Session::get('offer_percentage');
            $coupon_amount = ($offer_percentage / 100) * $sub_total_amount;
        }

        $total_amount = $sub_total_amount - $coupon_amount;

        return [
            'sub_total_amount' => $sub_total_amount,
            'coupon_amount' => $coupon_amount,
            'total_amount' => $total_amount,
        ];
    }

    public function customerInfo($request)
    {
        $auth_user = Auth::guard('web')->user();

        return [
            'customer_name' => $request->customer_name ?? $auth_user->name,
            'customer_email' => $request->customer_email ?? $auth_user->email,
            'customer_phone' => $request->customer_phone ?? $auth_user->phone,
            'customer_address' => $request->customer_address ?? $auth_user->address
        ];
    }

    public function setCustomerInfoSession($request)
    {
        session()->forget('customer_info');

        $auth_user = Auth::guard('web')->user();

        session()->put('customer_info', [
            'customer_name' => $request->customer_name ?? $auth_user->name,
            'customer_email' => $request->customer_email ?? $auth_user->email,
            'customer_phone' => $request->customer_phone ?? $auth_user->phone,
            'customer_address' => $request->customer_address ?? $auth_user->address
        ]);
    }
}
