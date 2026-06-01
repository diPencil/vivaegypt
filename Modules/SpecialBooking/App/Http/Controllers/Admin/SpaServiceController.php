<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Helpers\FileUploadHelper;
use Modules\SpecialBooking\App\Models\SpaService;

class SpaServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $services = SpaService::orderBy('sort_order', 'asc')->get();
        return view('specialbooking::admin.spa_services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('specialbooking::admin.spa_services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:spa_services,slug',
            'duration_minutes' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'max_guests_per_slot' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'status' => 'boolean',
            'sort_order' => 'nullable|integer',
            'available_days' => 'nullable|array',
            'description' => 'required|string',
            'gender_type' => 'required|in:both,male,female',
        ];

        $request->validate($rules);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
            // Ensure uniqueness
            $count = SpaService::where('slug', 'like', $data['slug'] . '%')->count();
            if ($count > 0) {
                $data['slug'] .= '-' . ($count + 1);
            }
        }

        if ($request->hasFile('image')) {
            $data['image'] = FileUploadHelper::uploadImage($request->file('image'), 'spa');
        }

        SpaService::create($data);

        $notification = ['message' => trans('translate.Created successfully'), 'alert-type' => 'success'];
        return redirect(dashboard_route('admin.special-booking.spa-services.index'))->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SpaService $spa_service): View
    {
        $lang_code = $request->get('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');

        $translation = \Modules\SpecialBooking\App\Models\SpaServiceTranslation::firstOrNew([
            'spa_service_id' => $spa_service->id,
            'lang_code'      => $lang_code,
        ]);

        if (!$translation->exists) {
            $translation->title            = $spa_service->title;
            $translation->description      = $spa_service->description;
            $translation->short_description = $spa_service->short_description;
            $translation->price_note       = $spa_service->price_note;
            $translation->location         = $spa_service->location;
            $translation->meta_title       = $spa_service->meta_title;
            $translation->meta_description = $spa_service->meta_description;
        }

        $spa_service->setRelation('translation', $translation);

        return view('specialbooking::admin.spa_services.edit', compact('spa_service', 'lang_code'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpaService $spa_service): RedirectResponse
    {
        $lang_code = $request->input('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');
        $isDefault = ($lang_code === (function_exists('admin_lang') ? admin_lang() : 'en'));

        if ($isDefault) {
            $rules = [
                'title'              => 'required|string|max:255',
                'slug'               => 'nullable|string|max:255|unique:spa_services,slug,' . $spa_service->id,
                'duration_minutes'   => 'required|integer|min:1',
                'price'              => 'nullable|numeric|min:0',
                'max_guests_per_slot'=> 'required|integer|min:1',
                'image'              => 'nullable|image|max:2048',
                'status'             => 'boolean',
                'sort_order'         => 'nullable|integer',
                'available_days'     => 'nullable|array',
                'description'        => 'required|string',
                'gender_type'        => 'required|in:both,male,female',
            ];

            $request->validate($rules);

            $data = $request->except(['lang_code', '_token', '_method']);
            $data['status'] = $request->has('status') ? 1 : 0;

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            if ($request->hasFile('image')) {
                if ($spa_service->image) {
                    FileUploadHelper::deleteImage($spa_service->image);
                }
                $data['image'] = FileUploadHelper::uploadImage($request->file('image'), 'spa');
            }

            $spa_service->update($data);
        } else {
            $request->validate([
                'title'            => 'required|string|max:255',
                'description'      => 'nullable|string',
                'short_description'=> 'nullable|string',
                'price_note'       => 'nullable|string|max:255',
                'location'         => 'nullable|string|max:255',
                'meta_title'       => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
            ]);
        }

        \Modules\SpecialBooking\App\Models\SpaServiceTranslation::updateOrCreate(
            [
                'spa_service_id' => $spa_service->id,
                'lang_code'      => $lang_code,
            ],
            [
                'title'            => $request->input('title'),
                'description'      => $request->input('description'),
                'short_description'=> $request->input('short_description'),
                'price_note'       => $request->input('price_note'),
                'location'         => $request->input('location'),
                'meta_title'       => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
            ]
        );

        $notification = ['message' => trans('translate.Updated successfully'), 'alert-type' => 'success'];
        return redirect(dashboard_route('admin.special-booking.spa-services.edit', ['spa_service' => $spa_service->id, 'lang_code' => $lang_code]))
            ->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpaService $spa_service): RedirectResponse
    {
        if ($spa_service->bookings()->count() > 0) {
            $notification = ['message' => trans('translate.Service has bookings. Cannot delete'), 'alert-type' => 'error'];
            return back()->with($notification);
        }

        if ($spa_service->image) {
            FileUploadHelper::deleteImage($spa_service->image);
        }

        $spa_service->delete();

        $notification = ['message' => trans('translate.Deleted successfully'), 'alert-type' => 'success'];
        return redirect(dashboard_route('admin.special-booking.spa-services.index'))->with($notification);
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(SpaService $spa_service): RedirectResponse
    {
        $spa_service->status = $spa_service->status == 1 ? 0 : 1;
        $spa_service->save();

        $notification = ['message' => trans('translate.Updated successfully'), 'alert-type' => 'success'];
        return back()->with($notification);
    }
}
