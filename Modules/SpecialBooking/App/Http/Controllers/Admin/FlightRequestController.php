<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\SpecialBooking\App\Models\FlightRequest;

class FlightRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $requests = FlightRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('specialbooking::admin.flight_requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('specialbooking::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FlightRequest $flight_request): View
    {
        $flight_request->load('user');
        return view('specialbooking::admin.flight_requests.show', compact('flight_request'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('specialbooking::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FlightRequest $flight_request): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,confirmed,cancelled,completed',
            'quoted_price' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string',
        ]);

        $flight_request->update($request->all());

        $notification = ['message' => trans('translate.Updated successfully'), 'alert-type' => 'success'];
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
