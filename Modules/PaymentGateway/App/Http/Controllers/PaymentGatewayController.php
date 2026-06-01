<?php

namespace Modules\PaymentGateway\App\Http\Controllers;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\Facades\Image;
use Modules\PaymentGateway\App\Http\Requests\BankRequest;
use Modules\PaymentGateway\App\Http\Requests\FlutterwaveRequest;
use Modules\PaymentGateway\App\Http\Requests\InstamojoRequest;
use Modules\PaymentGateway\App\Http\Requests\MollieRequest;
use Modules\PaymentGateway\App\Http\Requests\PaypalRequest;
use Modules\PaymentGateway\App\Http\Requests\PaystackRequest;
use Modules\PaymentGateway\App\Http\Requests\RazorpayRequest;
use Modules\PaymentGateway\App\Http\Requests\StripeRequest;
use Modules\PaymentGateway\App\Http\Requests\PaymobRequest;
use Modules\PaymentGateway\App\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_data = PaymentGateway::all();

        $payment_setting = [];

        foreach ($payment_data as $data_item) {
            $payment_setting[$data_item->key] = $data_item->value;
        }

        $payment_setting = (object) $payment_setting;

        return view('paymentgateway::index', ['payment_setting' => $payment_setting]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update_stripe(StripeRequest $request)
    {
        PaymentGateway::where('key', 'stripe_currency_id')->update(['value' => $request->currency_id]);
        PaymentGateway::where('key', 'stripe_key')->update(['value' => $request->stripe_key]);
        PaymentGateway::where('key', 'stripe_secret')->update(['value' => $request->stripe_secret]);
        PaymentGateway::where('key', 'stripe_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'stripe_image')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'stripe-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            Image::make($new_image)
                ->save(public_path().'/'.$image_name);
            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    public function update_paypal(PaypalRequest $request)
    {
        PaymentGateway::where('key', 'paypal_account_mode')->update(['value' => $request->account_mode]);
        PaymentGateway::where('key', 'paypal_currency_id')->update(['value' => $request->currency_id]);
        PaymentGateway::where('key', 'paypal_client_id')->update(['value' => $request->paypal_client_id]);
        PaymentGateway::where('key', 'paypal_secret_key')->update(['value' => $request->paypal_secret_key]);
        PaymentGateway::where('key', 'paypal_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'paypal_image')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'paypal-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            Image::make($new_image)
                ->save(public_path().'/'.$image_name);
            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    public function update_razorpay(RazorpayRequest $request)
    {
        PaymentGateway::where('key', 'razorpay_currency_id')->update(['value' => $request->currency_id]);
        PaymentGateway::where('key', 'razorpay_key')->update(['value' => $request->razorpay_key]);
        PaymentGateway::where('key', 'razorpay_secret')->update(['value' => $request->razorpay_secret]);
        PaymentGateway::where('key', 'razorpay_name')->update(['value' => $request->name]);
        PaymentGateway::where('key', 'razorpay_description')->update(['value' => $request->description]);
        PaymentGateway::where('key', 'razorpay_theme_color')->update(['value' => $request->theme_color]);

        PaymentGateway::where('key', 'razorpay_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'razorpay_image')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'paypal-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            Image::make($new_image)
                ->save(public_path().'/'.$image_name);
            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    public function update_flutterwave(FlutterwaveRequest $request)
    {
        PaymentGateway::where('key', 'flutterwave_currency_id')->update(['value' => $request->currency_id]);
        PaymentGateway::where('key', 'flutterwave_public_key')->update(['value' => $request->public_key]);
        PaymentGateway::where('key', 'flutterwave_secret_key')->update(['value' => $request->secret_key]);
        PaymentGateway::where('key', 'flutterwave_title')->update(['value' => $request->title]);

        PaymentGateway::where('key', 'flutterwave_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'flutterwave_logo')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'paypal-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            Image::make($new_image)
                ->save(public_path().'/'.$image_name);
            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    public function update_mollie(MollieRequest $request)
    {
        PaymentGateway::where('key', 'mollie_currency_id')->update(['value' => $request->mollie_currency_id]);
        PaymentGateway::where('key', 'mollie_key')->update(['value' => $request->mollie_key]);
        PaymentGateway::where('key', 'mollie_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'mollie_image')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'paypal-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            Image::make($new_image)
                ->save(public_path().'/'.$image_name);
            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    public function update_paystack(PaystackRequest $request)
    {
        PaymentGateway::where('key', 'paystack_currency_id')->update(['value' => $request->paystack_currency_id]);
        PaymentGateway::where('key', 'paystack_public_key')->update(['value' => $request->paystack_public_key]);
        PaymentGateway::where('key', 'paystack_secret_key')->update(['value' => $request->paystack_secret_key]);
        PaymentGateway::where('key', 'paystack_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'paystack_image')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'paypal-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            Image::make($new_image)
                ->save(public_path().'/'.$image_name);
            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    public function update_instamojo(InstamojoRequest $request)
    {
        PaymentGateway::where('key', 'instamojo_account_mode')->update(['value' => $request->account_mode]);
        PaymentGateway::where('key', 'instamojo_currency_id')->update(['value' => $request->currency_id]);
        PaymentGateway::where('key', 'instamojo_api_key')->update(['value' => $request->api_key]);
        PaymentGateway::where('key', 'instamojo_auth_token')->update(['value' => $request->auth_token]);

        PaymentGateway::where('key', 'instamojo_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'instamojo_image')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'paypal-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            Image::make($new_image)
                ->save(public_path().'/'.$image_name);
            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    public function update_bank(BankRequest $request)
    {
        PaymentGateway::where('key', 'bank_account_info')->update(['value' => $request->account_info]);
        PaymentGateway::where('key', 'bank_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'bank_image')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'paypal-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            Image::make($new_image)
                ->save(public_path().'/'.$image_name);
            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    public function update_cash_payment(Request $request)
    {
        updateEnv([
            'CASH_PAYMENT_BUTTON_TEXT' => $request?->cash_payment_button_text ?? 'Cash Payment',
            'CASH_PAYMENT_STATUS' => $request->has('cash_payment_status') ? 1 : 0
        ]);

        Artisan::call('cache:clear');

        return redirect()->back()->with([
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function update_paymob(PaymobRequest $request)
    {
        PaymentGateway::where('key', 'paymob_currency_id')->update(['value' => $request->currency_id]);
        PaymentGateway::where('key', 'paymob_api_key')->update(['value' => $request->api_key]);
        PaymentGateway::where('key', 'paymob_iframe_id')->update(['value' => $request->iframe_id]);
        PaymentGateway::where('key', 'paymob_integration_id')->update(['value' => $request->integration_id]);
        PaymentGateway::where('key', 'paymob_hmac')->update(['value' => $request->hmac]);
        PaymentGateway::where('key', 'paymob_status')->update(['value' => $request->status ? 1 : 0]);

        $exist_image = PaymentGateway::where('key', 'paymob_image')->first();

        if ($request->image) {
            $old_image = $exist_image->value;
            $new_image = $request->image;
            $ext = $new_image->getClientOriginalExtension();
            $image_name = 'paymob-'.date('Y-m-d-h-i-s-').rand(999, 9999).'.'.$ext;
            $image_name = 'uploads/website-images/'.$image_name;
            
            $new_image->move(public_path('uploads/website-images/'), $image_name);

            $exist_image->value = $image_name;
            $exist_image->save();
            if ($old_image) {
                if (File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }
}
