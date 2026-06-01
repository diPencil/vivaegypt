<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\SpecialBooking\App\Models\SpaBooking;

class SpaBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $bookings = SpaBooking::with(['user', 'spaService'])->orderBy('created_at', 'desc')->get();
        return view('specialbooking::admin.spa_bookings.index', compact('bookings'));
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
    public function show(SpaBooking $spa_booking): View
    {
        $spa_booking->load(['user', 'spaService']);
        return view('specialbooking::admin.spa_bookings.show', compact('spa_booking'));
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
    public function update(Request $request, SpaBooking $spa_booking): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,confirmed,cancelled,completed',
            'quoted_price' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string',
        ]);

        $spa_booking->update($request->all());

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
