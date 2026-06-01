<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Auth, File, Image, Str, Hash;
use App\Http\Controllers\Controller;
use Modules\Coupon\App\Models\Coupon;
use Modules\Wishlist\App\Models\Wishlist;
use App\Http\Requests\PasswordChangeRequest;
use Modules\Coupon\App\Models\CouponHistory;
use App\Http\Requests\BecomeAgentRequest;
use App\Http\Requests\EditStudentProfileRequest;
use Modules\SupportTicket\App\Models\SupportTicket;
use Modules\SupportTicket\App\Models\MessageDocument;
use Modules\PaymentWithdraw\App\Models\SellerWithdraw;
use Modules\SupportTicket\App\Models\SupportTicketMessage;
use Modules\TourBooking\App\Models\Booking;

class ProfileController extends Controller
{
    public function dashboard()
    {

        $user = Auth::guard('web')->user();

        if ($user?->isStaff()) {
            return redirect()->route('staff.dashboard');
        }

        $wishlists = Wishlist::where('user_id', $user->id)->count();

        $support_tickets = SupportTicket::where('author_id', $user->id)->where('admin_type', 'admin')->latest()->count();

        $bookings = Booking::with(['service:id,title,location'])
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->take(15)
            ->get();

        $booking =  Booking::where('user_id', auth()->user()->id)
            ->where('booking_status', 'confirmed');

        $total_booking = $booking->count();
        $total_transaction = Booking::where('user_id', auth()->user()->id)
            ->where('payment_status', 'success')
            ->sum('total');


        return view('user.dashboard', [
            'wishlists' => $wishlists,
            'support_tickets' => $support_tickets,
            'bookings' => $bookings,
            'total_booking' => $total_booking,
            'total_transaction' => $total_transaction
        ]);
    }

    public function edit_profile()
    {
        $user = Auth::guard('web')->user();

        return view('user.edit_profile', ['user' => $user]);
    }

    public function update_profile(EditStudentProfileRequest $request)
    {

        $user = Auth::guard('web')->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->country = $request->country;
        $user->save();

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

        $notify_message = trans('translate.Updated successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);
    }

    public function change_password()
    {
        return view('user.change_password');
    }

    public function update_password(PasswordChangeRequest $request)
    {

        $user = Auth::guard('web')->user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            $notify_message = trans('translate.Password changed successfully');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
            return redirect()->back()->with($notify_message);
        } else {
            $notify_message = trans('translate.Current password does not match');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }
    }


    public function create_agent(Request $request)
    {

        $user = Auth::guard('web')->user();

        return view('user.create_agent', [
            'user' => $user
        ]);
    }

    public function agent_application(BecomeAgentRequest $request)
    {
        $user = Auth::guard('web')->user();

        $user->agent_name = $request->agent_name;
        $user->agent_slug = $request->agent_slug;
        $user->about_me = $request->about_me;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;
        $user->twitter = $request->twitter;
        $user->instagram = $request->instagram;
        $user->website = $request->website;
        $user->location_map = $request->location_map;
        $user->tour_guide_joining_request = 'pending';
        $user->save();

        if ($request->hasFile('agent_logo')) {
            $file = $request->file('agent_logo');
            $logo_name = Str::slug($user->agent_name) . '-' . date('YmdHis') . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/custom-images'), $logo_name);

            $user->agent_logo = 'uploads/custom-images/' . $logo_name;
            $user->save();
        }

        $notify_message = trans('translate.Agent joining request sent to admin. Please await approval.');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);
    }

    public function agent_register(Request $request)
    {
        return view('user.agent_register', [
            'breadcrumb_title' => trans('translate.Register as Agent')
        ]);
    }

    public function agent_register_submit(Request $request)
    {
        // Validation for new agent registration
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'agent_name' => 'required|string|max:255',
        ], [
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'email.unique' => trans('translate.Email already exist'),
            'password.required' => trans('translate.Password is required'),
            'agent_name.required' => trans('translate.Agent Name is required'),
        ]);

        $user = new \App\Models\User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        
        $user->agent_name = $request->agent_name;
        $user->agent_slug = Str::slug($request->username);
        $user->about_me = $request->about_me;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;
        $user->twitter = $request->twitter;
        $user->instagram = $request->instagram;
        $user->website = $request->website;
        $user->location_map = $request->location_map;
        $user->tour_guide_joining_request = 'pending';
        // status is initially active so they can login or wait for approval
        $user->status = 'enable';
        $user->save();

        if ($request->hasFile('agent_logo')) {
            $file = $request->file('agent_logo');
            $logo_name = Str::slug($user->agent_name) . '-' . date('YmdHis') . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/custom-images'), $logo_name);

            $user->agent_logo = 'uploads/custom-images/' . $logo_name;
            $user->save();
        }

        $notify_message = trans('translate.Agent joining request sent to admin. Please await approval.');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        
        return redirect()->route('login')->with($notify_message);
    }

    public function account_delete()
    {
        return view('user.account_delete');
    }

    public function confirm_account_delete(Request $request)
    {

        $user = Auth::guard('web')->user();

        $request->validate([
            'current_password' => 'required'
        ], [
            'current_password.required' => trans('translate.Current password is required')
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            $notify_message = trans('translate.Current password does not match');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }

        $user_image = $user->image;

        if ($user_image) {
            if (File::exists(public_path() . '/' . $user_image)) unlink(public_path() . '/' . $user_image);
        }

        $user_id = $user->id;
        Coupon::where('seller_id', $user_id)->delete();
        CouponHistory::where('seller_id', $user_id)->delete();
        CouponHistory::where('buyer_id', $user_id)->delete();

        SellerWithdraw::where('seller_id', $user_id)->delete();
        Wishlist::where('user_id', $user_id)->delete();

        $support_tickets = SupportTicket::where('author_id', $user->id)->latest()->get();

        foreach ($support_tickets as $support_ticket) {
            $ticket_messages = SupportTicketMessage::with('documents')->where('support_ticket_id', $support_ticket->id)->get();

            foreach ($ticket_messages as $ticket_message) {

                $documents = MessageDocument::where('message_id', $ticket_message->id)->where('model_name', 'SupportTicketMessage')->get();
                foreach ($documents as $document) {
                    $exist_file_name = $document->file_name;
                    if ($exist_file_name) {
                        if (File::exists(public_path('uploads/custom-images') . '/' . $exist_file_name)) unlink(public_path('uploads/custom-images') . '/' . $exist_file_name);
                    }

                    $document->delete();
                }

                $ticket_message->delete();
            }

            $support_ticket->delete();
        }



        $user->delete();

        Auth::guard('web')->logout();

        $notify_message = trans('translate.Your account deleted successful');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('user.login')->with($notify_message);
    }
}
