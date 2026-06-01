<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\SpecialBooking\App\Models\BookingFeature;

class BookingFeatureController extends Controller
{
    public function index(): View
    {
        $features = BookingFeature::ordered()->get();
        $contexts = [
            'flights_why_book' => __('translate.Flights Why Book'),
            'transfers_why_book' => __('translate.Transfers Why Book'),
            'nile_inclusions' => __('translate.Nile Inclusions'),
            'nile_why_book' => __('translate.Nile Why Book'),
        ];

        return view('specialbooking::admin.booking_features.index', compact('features', 'contexts'));
    }

    public function create(): View
    {
        $contexts = [
            'flights_why_book' => __('translate.Flights Why Book'),
            'transfers_why_book' => __('translate.Transfers Why Book'),
            'nile_inclusions' => __('translate.Nile Inclusions'),
            'nile_why_book' => __('translate.Nile Why Book'),
        ];

        return view('specialbooking::admin.booking_features.create', compact('contexts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'context' => 'required|in:flights_why_book,transfers_why_book,nile_inclusions,nile_why_book',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'icon_class' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        BookingFeature::create($validated);

        return redirect(dashboard_route('admin.special-booking.booking-features.index'))->with(['message' => trans('translate.Created successfully'), 'alert-type' => 'success']);
    }

    public function edit(Request $request, BookingFeature $booking_feature): View
    {
        $lang_code = $request->get('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');

        $translation = \Modules\SpecialBooking\App\Models\BookingFeatureTranslation::firstOrNew([
            'booking_feature_id' => $booking_feature->id,
            'lang_code' => $lang_code,
        ]);

        if (! $translation->exists) {
            $translation->title = $booking_feature->title;
            $translation->short_description = $booking_feature->short_description;
        }

        $booking_feature->setRelation('translation', $translation);

        $contexts = [
            'flights_why_book' => __('translate.Flights Why Book'),
            'transfers_why_book' => __('translate.Transfers Why Book'),
            'nile_inclusions' => __('translate.Nile Inclusions'),
            'nile_why_book' => __('translate.Nile Why Book'),
        ];

        return view('specialbooking::admin.booking_features.edit', compact('booking_feature', 'contexts', 'lang_code'));
    }

    public function update(Request $request, BookingFeature $booking_feature): RedirectResponse
    {
        $lang_code = $request->input('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');
        $isDefault = ($lang_code === (function_exists('admin_lang') ? admin_lang() : 'en'));

        if ($isDefault) {
            $validated = $request->validate([
                'context' => 'required|in:flights_why_book,transfers_why_book,nile_inclusions,nile_why_book',
                'title' => 'required|string|max:255',
                'short_description' => 'nullable|string',
                'icon_class' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'status' => 'nullable|boolean',
            ]);
            $validated['status'] = $request->has('status') ? 1 : 0;
            $booking_feature->update($validated);
        } else {
            $request->validate([
                'title' => 'required|string|max:255',
                'short_description' => 'nullable|string',
            ]);
        }

        \Modules\SpecialBooking\App\Models\BookingFeatureTranslation::updateOrCreate(
            [
                'booking_feature_id' => $booking_feature->id,
                'lang_code' => $lang_code,
            ],
            [
                'title' => $request->input('title'),
                'short_description' => $request->input('short_description'),
            ]
        );

        return redirect(dashboard_route('admin.special-booking.booking-features.edit', ['booking_feature' => $booking_feature->id, 'lang_code' => $lang_code]))->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }

    public function destroy(BookingFeature $booking_feature): RedirectResponse
    {
        $booking_feature->delete();

        return redirect(dashboard_route('admin.special-booking.booking-features.index'))->with(['message' => trans('translate.Deleted successfully'), 'alert-type' => 'success']);
    }

    public function updateStatus(BookingFeature $booking_feature): RedirectResponse
    {
        $booking_feature->update(['status' => ! $booking_feature->status]);

        return back()->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }
}