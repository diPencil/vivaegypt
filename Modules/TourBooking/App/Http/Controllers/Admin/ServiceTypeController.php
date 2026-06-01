<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Http\Controllers\Admin;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Language\App\Models\Language;
use Modules\TourBooking\App\Models\Service;
use Modules\TourBooking\App\Models\ServiceType;
use Modules\TourBooking\App\Models\ServiceTypeTranslation;
use Illuminate\Support\Facades\Validator;

final class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $serviceTypes = ServiceType::with('translation')
            ->latest()
            ->paginate(15);

        return view('tourbooking::admin.service_types.index', compact('serviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tourbooking::admin.service_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();

        $data['status'] = $request->has('status') ? true : false;
        $data['is_featured'] = $request->has('is_featured') ? true : false;
        $data['show_on_homepage'] = $request->has('show_on_homepage') ? true : false;

        $validated = Validator::make($data, [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:service_types,slug|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'status' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ])->validate();

        if ($request->hasFile('image')) {
            $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'destination');
        }

        $serviceType = ServiceType::create($validated);

        foreach (Language::where('status', 1)->get() as $language) {
            ServiceTypeTranslation::create([
                'service_type_id' => $serviceType->id,
                'lang_code' => $language->lang_code,
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);
        }

        return redirect(dashboard_route('admin.tourbooking.service-types.index'))
            ->with('success', 'Service type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ServiceType $serviceType): View
    {
        $statusFilter = $request->query('status', 'manageable');
        $servicesQuery = $serviceType->services()
            ->with(['translation', 'serviceType', 'thumbnail'])
            ->withCount('bookings')
            ->orderBy('id', 'desc');

        if ($statusFilter === 'active') {
            $servicesQuery->where('status', true);
        } elseif ($statusFilter === 'inactive_drafts') {
            $servicesQuery->where('status', false)
                ->whereDoesntHave('bookings');
        } elseif ($statusFilter === 'archived') {
            $servicesQuery->where('status', false)
                ->whereHas('bookings');
        } else {
            $statusFilter = 'manageable';
            $servicesQuery->where(function ($query) {
                $query->where('status', true)
                    ->orWhere(function ($query) {
                        $query->where('status', false)
                            ->whereDoesntHave('bookings');
                    });
            });
        }

        $services = $servicesQuery->get();

        return view('tourbooking::admin.service_types.show', compact('serviceType', 'services', 'statusFilter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ServiceType $serviceType): View
    {
        $lang_code = $request->get('lang_code', admin_lang());

        $translation = ServiceTypeTranslation::firstOrNew(
            [
                'service_type_id' => $serviceType->id,
                'lang_code' => $lang_code,
            ]
        );

        if (!$translation->exists) {
            $translation->name = $serviceType->name;
            $translation->description = $serviceType->description;
        }

        $serviceType->setRelation('translation', $translation);

        return view('tourbooking::admin.service_types.edit', compact('serviceType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceType $serviceType): RedirectResponse
    {
        $lang_code = $request->input('lang_code', admin_lang());

        if ($lang_code === admin_lang()) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:service_types,slug,' . $serviceType->id,
                'description' => 'nullable|string',
                'icon' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                if ($serviceType->image) {
                    FileUploadHelper::deleteImage($serviceType->image);
                }
                $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'destination');
            }

            $validated['status'] = $request->has('status') ? true : false;
            $validated['is_featured'] = $request->has('is_featured') ? true : false;
            $validated['show_on_homepage'] = $request->has('show_on_homepage') ? true : false;

            $serviceType->update($validated);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'lang_code' => 'required|string',
            ]);
        }

        ServiceTypeTranslation::updateOrCreate(
            [
                'service_type_id' => $serviceType->id,
                'lang_code' => $lang_code,
            ],
            [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]
        );

        $notify_message = trans('translate.Update Successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return back()->with($notify_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceType $serviceType): RedirectResponse
    {
        if (Service::where('service_type_id', $serviceType->id)->exists()) {
            return redirect(dashboard_route('admin.tourbooking.service-types.index'))
                ->with('error', 'Cannot delete service type because it is being used by one or more services.');
        }

        if ($serviceType->image) {
            FileUploadHelper::deleteImage($serviceType->image);
        }

        $serviceType->translations()->delete();
        $serviceType->delete();

        return redirect(dashboard_route('admin.tourbooking.service-types.index'))
            ->with('success', 'Service type deleted successfully.');
    }
}
