<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Admin;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\SpecialBooking\App\Models\Airline;

class AirlineController extends Controller
{
    public function index(): View
    {
        $airlines = Airline::ordered()->get();
        return view('specialbooking::admin.airlines.index', compact('airlines'));
    }

    public function create(): View
    {
        return view('specialbooking::admin.airlines.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'short_description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('logo')) {
            $validated['logo'] = FileUploadHelper::uploadImage($request->file('logo'), 'special-booking/airlines');
        }

        Airline::create($validated);

        return redirect(dashboard_route('admin.special-booking.airlines.index'))->with(['message' => trans('translate.Created successfully'), 'alert-type' => 'success']);
    }

    public function edit(Request $request, Airline $airline): View
    {
        $lang_code = $request->get('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');

        $translation = \Modules\SpecialBooking\App\Models\AirlineTranslation::firstOrNew([
            'airline_id' => $airline->id,
            'lang_code' => $lang_code,
        ]);

        if (!$translation->exists) {
            $translation->name = $airline->name;
            $translation->short_description = $airline->short_description;
        }

        $airline->setRelation('translation', $translation);

        return view('specialbooking::admin.airlines.edit', compact('airline', 'lang_code'));
    }

    public function update(Request $request, Airline $airline): RedirectResponse
    {
        $lang_code = $request->input('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');
        $isDefault = ($lang_code === (function_exists('admin_lang') ? admin_lang() : 'en'));

        if ($isDefault) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'logo' => 'nullable|image|max:2048',
                'short_description' => 'nullable|string',
                'sort_order' => 'nullable|integer|min:0',
                'status' => 'nullable|boolean',
            ]);

            $validated['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('logo')) {
                if ($airline->logo) {
                    FileUploadHelper::deleteImage($airline->logo);
                }
                $validated['logo'] = FileUploadHelper::uploadImage($request->file('logo'), 'special-booking/airlines');
            }

            $airline->update($validated);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'short_description' => 'nullable|string',
            ]);
        }

        \Modules\SpecialBooking\App\Models\AirlineTranslation::updateOrCreate(
            [
                'airline_id' => $airline->id,
                'lang_code' => $lang_code,
            ],
            [
                'name' => $request->input('name'),
                'short_description' => $request->input('short_description'),
            ]
        );

        return redirect(dashboard_route('admin.special-booking.airlines.edit', ['airline' => $airline->id, 'lang_code' => $lang_code]))->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }

    public function destroy(Airline $airline): RedirectResponse
    {
        if ($airline->logo) {
            FileUploadHelper::deleteImage($airline->logo);
        }

        $airline->delete();

        return redirect(dashboard_route('admin.special-booking.airlines.index'))->with(['message' => trans('translate.Deleted successfully'), 'alert-type' => 'success']);
    }

    public function updateStatus(Airline $airline): RedirectResponse
    {
        $airline->update(['status' => ! $airline->status]);

        return back()->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }
}