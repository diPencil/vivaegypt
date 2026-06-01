<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Admin;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\SpecialBooking\App\Models\TransferVehicle;

class TransferVehicleController extends Controller
{
    public function index(): View
    {
        $vehicles = TransferVehicle::ordered()->get();
        return view('specialbooking::admin.transfer_vehicles.index', compact('vehicles'));
    }

    public function create(): View
    {
        return view('specialbooking::admin.transfer_vehicles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:special_booking_transfer_vehicles,slug',
            'image' => 'nullable|image|max:2048',
            'icon_class' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'capacity_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = TransferVehicle::where('slug', 'like', $validated['slug'] . '%')->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        if ($request->hasFile('image')) {
            $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'special-booking/transfer-vehicles');
        }

        TransferVehicle::create($validated);

        return redirect(dashboard_route('admin.special-booking.transfer-vehicles.index'))->with(['message' => trans('translate.Created successfully'), 'alert-type' => 'success']);
    }

    public function edit(Request $request, TransferVehicle $transfer_vehicle): View
    {
        $lang_code = $request->get('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');

        $translation = \Modules\SpecialBooking\App\Models\TransferVehicleTranslation::firstOrNew([
            'transfer_vehicle_id' => $transfer_vehicle->id,
            'lang_code' => $lang_code,
        ]);

        if (!$translation->exists) {
            $translation->title = $transfer_vehicle->title;
            $translation->short_description = $transfer_vehicle->short_description;
            $translation->capacity_text = $transfer_vehicle->capacity_text;
        }

        $transfer_vehicle->setRelation('translation', $translation);

        return view('specialbooking::admin.transfer_vehicles.edit', compact('transfer_vehicle', 'lang_code'));
    }

    public function update(Request $request, TransferVehicle $transfer_vehicle): RedirectResponse
    {
        $lang_code = $request->input('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');
        $isDefault = ($lang_code === (function_exists('admin_lang') ? admin_lang() : 'en'));

        if ($isDefault) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:special_booking_transfer_vehicles,slug,' . $transfer_vehicle->id,
                'image' => 'nullable|image|max:2048',
                'icon_class' => 'nullable|string|max:255',
                'short_description' => 'nullable|string',
                'capacity_text' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'status' => 'nullable|boolean',
            ]);

            $validated['status'] = $request->has('status') ? 1 : 0;

            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            if ($request->hasFile('image')) {
                if ($transfer_vehicle->image) {
                    FileUploadHelper::deleteImage($transfer_vehicle->image);
                }
                $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'special-booking/transfer-vehicles');
            }

            $transfer_vehicle->update($validated);
        } else {
            $request->validate([
                'title' => 'required|string|max:255',
                'short_description' => 'nullable|string',
                'capacity_text' => 'nullable|string|max:255',
            ]);
        }

        \Modules\SpecialBooking\App\Models\TransferVehicleTranslation::updateOrCreate(
            [
                'transfer_vehicle_id' => $transfer_vehicle->id,
                'lang_code' => $lang_code,
            ],
            [
                'title' => $request->input('title'),
                'short_description' => $request->input('short_description'),
                'capacity_text' => $request->input('capacity_text'),
            ]
        );

        return redirect(dashboard_route('admin.special-booking.transfer-vehicles.edit', ['transfer_vehicle' => $transfer_vehicle->id, 'lang_code' => $lang_code]))->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }

    public function destroy(TransferVehicle $transfer_vehicle): RedirectResponse
    {
        if ($transfer_vehicle->image) {
            FileUploadHelper::deleteImage($transfer_vehicle->image);
        }

        $transfer_vehicle->delete();

        return redirect(dashboard_route('admin.special-booking.transfer-vehicles.index'))->with(['message' => trans('translate.Deleted successfully'), 'alert-type' => 'success']);
    }

    public function updateStatus(TransferVehicle $transfer_vehicle): RedirectResponse
    {
        $transfer_vehicle->update(['status' => ! $transfer_vehicle->status]);

        return back()->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }
}