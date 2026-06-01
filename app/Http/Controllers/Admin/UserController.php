<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Helper\EmailHelper;

use Illuminate\Http\Request;
use App\Mail\InstructorApproval;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Modules\Coupon\App\Models\Coupon;
use Modules\Wishlist\App\Models\Wishlist;
use Modules\Coupon\App\Models\CouponHistory;
use Modules\EmailSetting\App\Models\EmailTemplate;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\SupportTicket\App\Models\SupportTicket;
use Modules\SupportTicket\App\Models\MessageDocument;
use Modules\PaymentWithdraw\App\Models\SellerWithdraw;
use Modules\SupportTicket\App\Models\SupportTicketMessage;
use Modules\TourBooking\App\Models\Booking;
use Modules\TourBooking\App\Models\Service;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function user_list(){

        $users = User::where('status', 'enable')->latest()->get();

        $title = trans('translate.User List');

        return view('admin.user.user_list', ['users' => $users, 'title' => $title]);
    }

    public function user_create()
    {
        $title = trans('translate.Create User');
        return view('admin.user.create', compact('title'));
    }

    public function user_store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:4',
            'phone' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'email.unique' => trans('translate.Email already exist'),
            'username.required' => trans('translate.Username is required'),
            'username.unique' => trans('translate.Username already exist'),
            'password.required' => trans('translate.Password is required'),
            'phone.required' => trans('translate.Phone is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->country = $request->country;
        $user->address = $request->address;
        $user->status = 'enable';
        
        // Generate unique 7-digit UserID
        $user_id_number = mt_rand(1000000, 9999999);
        while (User::where('user_id_number', $user_id_number)->exists()) {
            $user_id_number = mt_rand(1000000, 9999999);
        }
        $user->user_id_number = $user_id_number;
        
        $user->save();

        $notify_message = trans('translate.User created successful');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('admin.user-list')->with($notify_message);
    }

    public function pending_user(){

        $users = User::where('status', 'disable')->latest()->get();

        $title = trans('translate.Pending User');

        return view('admin.user.user_list', ['users' => $users, 'title' => $title]);
    }

    public function user_show($username){

        $user = User::where('username', $username)->firstOrFail();

        $wallet_balance = 0.0;

        $totalConfirmedBookingCount = Booking::where('user_id', $user->id)->where('booking_status', 'confirmed')->count();
        $confirmAmount = Booking::where('user_id', $user->id)->where('payment_status', 'success')->sum('total');

        $user_bookings = Booking::with(['service:id,title,location'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('admin.user.user_show', [
            'user' => $user,
            'total_confirmed_booking' => $totalConfirmedBookingCount,
            'confirm_amount' => $confirmAmount,
            'wallet_balance' => $wallet_balance,
            'user_bookings' => $user_bookings
        ]);

    }

    public function login_as_user($id)
    {
        $user = User::findOrFail($id);

        if ($user->status !== 'enable') {
            $notify_message = trans('translate.User is not active');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');

            return redirect()->back()->with($notify_message);
        }

        Auth::guard('web')->login($user);
        request()->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    public function update(Request $request ,$id){

        $user = User::findOrFail($id);

        $rules = [
            'name'=>'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone'=>'nullable',
            'address'=>'nullable|max:220',
        ];
        $customMessages = [
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'email.unique' => trans('translate.Email already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->country = $request->country;
        $user->status = $request->status ? 'enable' : 'disable';
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->file('image')) {
            $old_image = $user->image;
            $user_image = $request->image;
            $extention = $user_image->getClientOriginalExtension();
            $filename = Str::slug($user->name) . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $user_image->move(public_path('uploads/custom-images'), $filename);
            $user->image = 'uploads/custom-images/' . $filename;
            $user->save();

            if ($old_image) {
                if (File::exists(public_path() . '/' . $old_image)) unlink(public_path() . '/' . $old_image);
            }
        }

        $user->save();

        $notify_message= trans('translate.User updated successful');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->back()->with($notify_message);

    }

    public function user_destroy($id){

        $user = User::findOrFail($id);
        $user_id = $user->id;


        $user_image = $user->image;

        if($user_image){
            if(File::exists(public_path().'/'.$user_image))unlink(public_path().'/'.$user_image);
        }

        Coupon::where('seller_id', $user_id)->delete();
        CouponHistory::where('seller_id', $user_id)->delete();
        CouponHistory::where('buyer_id', $user_id)->delete();

        SellerWithdraw::where('seller_id', $user_id)->delete();
        Wishlist::where('user_id', $user_id)->delete();

        $support_tickets = SupportTicket::where('author_id', $user->id)->latest()->get();

        foreach($support_tickets as $support_ticket){
            $ticket_messages = SupportTicketMessage::with('documents')->where('support_ticket_id', $support_ticket->id)->get();

            foreach($ticket_messages as $ticket_message){

                $documents = MessageDocument::where('message_id', $ticket_message->id)->where('model_name', 'SupportTicketMessage')->get();
                foreach($documents as $document){
                    $exist_file_name = $document->file_name;
                    if($exist_file_name){
                        if(File::exists(public_path('uploads/custom-images').'/'.$exist_file_name))unlink(public_path('uploads/custom-images').'/'.$exist_file_name);
                    }

                    $document->delete();
                }

                $ticket_message->delete();
            }

            $support_ticket->delete();
        }

        $user->delete();

        $notify_message = trans('translate.Delete Successfully');
        $notify_message = array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->route('admin.user-list')->with($notify_message);

    }

    public function user_status($id){
        $user = User::findOrFail($id);
        if($user->status == 'enable'){
            $user->status = 'disable';
            $user->save();
            $message = trans('translate.Status Changed Successfully');
        }else{
            $user->status = 'enable';
            $user->save();
            $message = trans('translate.Status Changed Successfully');
        }
        return response()->json($message);
    }


    public function agent_create(){
        $title = trans('translate.Create New Agent');
        return view('admin.user.agent_create', ['title' => $title]);
    }

    public function agent_store(Request $request){
        $rules = [
            'name'=>'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone'=>'required',
            'agent_name' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'email.unique' => trans('translate.Email already exist'),
            'password.required' => trans('translate.Password is required'),
            'phone.required' => trans('translate.Phone is required'),
            'agent_name.required' => trans('translate.Agent Name is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->status = 'enable';
        $user->is_seller = 1;
        $user->tour_guide_joining_request = 'approved';
        $user->agent_name = $request->agent_name;
        $user->agent_slug = \Illuminate\Support\Str::slug($request->username);
        $user->about_me = $request->about_me;
        $user->address = $request->address;
        
        if ($request->hasFile('agent_logo')) {
            $file = $request->file('agent_logo');
            $logo_name = Str::slug($user->agent_name) . '-' . date('YmdHis') . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/custom-images'), $logo_name);
            $user->agent_logo = 'uploads/custom-images/' . $logo_name;
        }

        $user->save();

        $notify_message = trans('translate.Agent created successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('admin.seller-list')->with($notify_message);
    }

    public function seller_list(){


        $users = User::where('status', 'enable')->where('is_seller', 1)->latest()->get();

        $title = trans('translate.Agent List');

        return view('admin.seller.seller_list', ['users' => $users, 'title' => $title]);
    }

    public function pending_seller(){

        $users = User::where('status', 'disable')->where('is_seller', 1)->latest()->get();

        $title = trans('translate.Pending Seller');

        return view('admin.seller.seller_list', ['users' => $users, 'title' => $title]);
    }


    public function seller_joining_request(){

        $users = User::where('tour_guide_joining_request', 'pending')->latest()->get();

    $title = trans('translate.Agent Joining Request');

        return view('admin.seller.seller_joining_request', ['users' => $users, 'title' => $title]);
    }

    public function seller_joining_detail($user_id){

        $user = User::findOrFail($user_id);

        $skills_expertises = json_decode($user->skills_expertise);


        return view('admin.seller.seller_joining_detail', ['user' => $user, 'skills_expertises' => $skills_expertises]);
    }


    public function seller_joining_approval($user_id){

        $user = User::findOrFail($user_id);
        $user->tour_guide_joining_request = 'approved';
        $user->is_seller = 1;
        $user->save();

        EmailHelper::mail_setup();

        try{
            $template = EmailTemplate::find(5);
            $message = $template->description;
            $subject = $template->subject;
            $message = str_replace('{{user_name}}',$user->name,$message);

            Mail::to($user->email)->send(new InstructorApproval($message,$subject));

        }catch(Exception $ex){
            Log::info($ex->getMessage());
        }



        $notify_message = trans('translate.Instructor application approval successful');
        $notify_message = array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->back()->with($notify_message);

    }

    public function seller_joining_reject(Request $request, $user_id){

        $user = User::findOrFail($user_id);
        $user->tour_guide_joining_request = 'rejected';
        $user->save();

        EmailHelper::mail_setup();

        try{
            $template = EmailTemplate::find(6);
            $message = $template->description;
            $subject = $template->subject;
            $message = str_replace('{{user_name}}',$user->name,$message);
            $message = str_replace('{{reason}}',$request->reason,$message);

            Mail::to($user->email)->send(new InstructorApproval($message,$subject));

        }catch(Exception $ex){
            Log::info($ex->getMessage());
        }

        $notify_message = trans('translate.A rejection reason send to instructor mail');
        $notify_message = array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->back()->with($notify_message);

    }

    public function seller_show($username){

        $user = User::where('username', $username)->firstOrFail();

        $myServicesIds = Service::where('user_id', $user->id)->pluck('id')->toArray();

        $total_income = Booking::whereIn('service_id', $myServicesIds)
            ->where('payment_status', 'success')
            ->sum('total');

        $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
        $commission_per_sale = GlobalSetting::where('key', 'commission_per_sale')->value('value');

        $total_commission = 0.00;
        $net_income = $total_income;
        if($commission_type == 'commission'){
            $total_commission = ($commission_per_sale / 100) * $total_income;
            $net_income = $total_income - $total_commission;
        }

        $pending_success_list = SellerWithdraw::where('seller_id', $user->id)->where('status', '!=', 'rejected')->sum('total_amount');

        $total_withdraw_amount = $pending_success_list;

        $current_balance = $net_income - $total_withdraw_amount;

        $pending_withdraw = SellerWithdraw::where('seller_id', $user->id)->where('status', 'pending')->sum('total_amount');

        $agent_bookings = Booking::with(['service', 'user'])
            ->whereIn('service_id', $myServicesIds)
            ->latest()
            ->get();

        return view('admin.seller.seller_show', [
            'user' => $user,
            'total_income' => $total_income,
            'total_commission' => $total_commission,
            'net_income' => $net_income,
            'current_balance' => $current_balance,
            'total_withdraw_amount' => $total_withdraw_amount,
            'pending_withdraw' => $pending_withdraw,
            'agent_bookings' => $agent_bookings
        ]);

    }
}
