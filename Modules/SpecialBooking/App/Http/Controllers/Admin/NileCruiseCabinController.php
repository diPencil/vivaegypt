<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Admin;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\SpecialBooking\App\Models\NileCruiseCabin;

class NileCruiseCabinController extends Controller
{
    public function index(): View
    {
        $cabins = NileCruiseCabin::ordered()->get();
        return view('specialbooking::admin.nile_cruise_cabins.index', compact('cabins'));
    }

    public function create(): View
    {
        return view('specialbooking::admin.nile_cruise_cabins.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'special-booking/nile-cabins');
        }

        NileCruiseCabin::create($validated);

        return redirect(dashboard_route('admin.special-booking.nile-cruise-cabins.index'))->with(['message' => trans('translate.Created successfully'), 'alert-type' => 'success']);
    }

    public function edit(Request $request, NileCruiseCabin $nile_cruise_cabin): View
    {
        $lang_code = $request->get('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');

        $translation = \Modules\SpecialBooking\App\Models\NileCruiseCabinTranslation::firstOrNew([
            'nile_cabin_id' => $nile_cruise_cabin->id,
            'lang_code' => $lang_code,
        ]);

        if (!$translation->exists) {
            $translation->title = $nile_cruise_cabin->title;
            $translation->short_description = $nile_cruise_cabin->short_description;
        }

        $nile_cruise_cabin->setRelation('translation', $translation);

        return view('specialbooking::admin.nile_cruise_cabins.edit', compact('nile_cruise_cabin', 'lang_code'));
    }

    public function update(Request $request, NileCruiseCabin $nile_cruise_cabin): RedirectResponse
    {
        $lang_code = $request->input('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');
        $isDefault = ($lang_code === (function_exists('admin_lang') ? admin_lang() : 'en'));

        if ($isDefault) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'short_description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'sort_order' => 'nullable|integer|min:0',
                'status' => 'nullable|boolean',
            ]);

            $validated['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                if ($nile_cruise_cabin->image) {
                    FileUploadHelper::deleteImage($nile_cruise_cabin->image);
                }
                $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'special-booking/nile-cabins');
            }

            $nile_cruise_cabin->update($validated);
        } else {
            $request->validate([
                'title' => 'required|string|max:255',
                'short_description' => 'nullable|string',
            ]);
        }

        \Modules\SpecialBooking\App\Models\NileCruiseCabinTranslation::updateOrCreate(
            [
                'nile_cabin_id' => $nile_cruise_cabin->id,
                'lang_code' => $lang_code,
            ],
            [
                'title' => $request->input('title'),
                'short_description' => $request->input('short_description'),
            ]
        );

        return redirect(dashboard_route('admin.special-booking.nile-cruise-cabins.edit', ['nile_cruise_cabin' => $nile_cruise_cabin->id, 'lang_code' => $lang_code]))->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }

    public function destroy(NileCruiseCabin $nile_cruise_cabin): RedirectResponse
    {
        if ($nile_cruise_cabin->image) {
            FileUploadHelper::deleteImage($nile_cruise_cabin->image);
        }

        $nile_cruise_cabin->delete();

        return redirect(dashboard_route('admin.special-booking.nile-cruise-cabins.index'))->with(['message' => trans('translate.Deleted successfully'), 'alert-type' => 'success']);
    }

    public function updateStatus(NileCruiseCabin $nile_cruise_cabin): RedirectResponse
    {
        $nile_cruise_cabin->update(['status' => ! $nile_cruise_cabin->status]);

        return back()->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }
}