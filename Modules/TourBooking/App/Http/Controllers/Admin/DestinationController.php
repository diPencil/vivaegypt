<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Http\Controllers\Admin;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Modules\Language\App\Models\Language;
use Modules\TourBooking\App\Models\Destination;
use Modules\TourBooking\App\Models\DestinationTranslation;
use Modules\TourBooking\App\Models\Service;

final class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $destinations = Destination::with('translation')
            ->withCount('services')
            ->latest()
            ->paginate(15);

        return view('tourbooking::admin.destinations.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tourbooking::admin.destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:destinations,slug|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:100',
            'region' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'latitude' => 'nullable|string|max:30',
            'longitude' => 'nullable|string|max:30',
            'status' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'destination');
        }

        if ($request->hasFile('svg')) {
            $validated['svg_image'] = FileUploadHelper::uploadImage($request->file('svg'), 'destination');
        }

        $validated['status'] = $request->has('status');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['show_on_homepage'] = $request->has('show_on_homepage');
        $validated['user_id'] = auth()->user()->id;
        $validated['meta_title'] = $request->meta_title ?? null;
        $validated['meta_keywords'] = $request->meta_keywords ?? null;
        $validated['meta_description'] = $request->meta_description ?? null;
        $validated['tags'] = $request->tags ?? null;

        $destination = Destination::create($validated);

        foreach (Language::where('status', 1)->get() as $language) {
            DestinationTranslation::create([
                'destination_id' => $destination->id,
                'lang_code' => $language->lang_code,
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
                'meta_keywords' => $validated['meta_keywords'],
            ]);
        }

        return redirect(dashboard_route('admin.tourbooking.destinations.index'))
            ->with('success', 'Destination created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination): View
    {
        $destination->load(['services.serviceType']);

        return view('tourbooking::admin.destinations.show', compact('destination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Destination $destination): View
    {
        $lang_code = $request->get('lang_code', admin_lang());

        $translation = DestinationTranslation::firstOrNew(
            [
                'destination_id' => $destination->id,
                'lang_code' => $lang_code,
            ]
        );

        if (!$translation->exists) {
            $translation->name = $destination->name;
            $translation->description = $destination->description;
            $translation->meta_title = $destination->meta_title;
            $translation->meta_description = $destination->meta_description;
            $translation->meta_keywords = $destination->meta_keywords;
        }

        $destination->setRelation('translation', $translation);

        return view('tourbooking::admin.destinations.edit', compact('destination'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $lang_code = $request->input('lang_code', admin_lang());

        if ($lang_code === admin_lang()) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:destinations,slug,' . $destination->id,
                'description' => 'nullable|string',
                'country' => 'required|string|max:100',
                'region' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
                'latitude' => 'nullable|string|max:30',
                'longitude' => 'nullable|string|max:30',
                'status' => 'nullable|boolean',
                'is_featured' => 'nullable|boolean',
                'show_on_homepage' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tags' => 'nullable|string|max:255',
            ]);

            if ($request->hasFile('image')) {
                if ($destination->image !== null) {
                    FileUploadHelper::deleteImage($destination->image);
                }
                $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'destination');
            }

            if ($request->hasFile('svg')) {
                if ($destination->svg_image !== null) {
                    FileUploadHelper::deleteImage($destination->svg_image);
                }
                $validated['svg_image'] = FileUploadHelper::uploadImage($request->file('svg'), 'destination');
            }

            $validated['status'] = $request->has('status');
            $validated['is_featured'] = $request->has('is_featured');
            $validated['show_on_homepage'] = $request->has('show_on_homepage');
            $validated['meta_title'] = $request->meta_title ?? null;
            $validated['meta_keywords'] = $request->meta_keywords ?? null;
            $validated['meta_description'] = $request->meta_description ?? null;
            $validated['tags'] = $request->tags ?? null;

            $destination->update($validated);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'lang_code' => 'required|string',
            ]);
        }

        DestinationTranslation::updateOrCreate(
            [
                'destination_id' => $destination->id,
                'lang_code' => $lang_code,
            ],
            [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
            ]
        );

        $notify_message = trans('translate.Update Successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return back()->with($notify_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination): RedirectResponse
    {
        if (Service::where('destination_id', $destination->id)->exists()) {
            return redirect(dashboard_route('admin.tourbooking.destinations.index'))
                ->with('error', 'Cannot delete destination because it is being used by one or more services.');
        }

        if ($destination->image !== null) {
            FileUploadHelper::deleteImage($destination->image);
        }

        if ($destination->svg_image !== null) {
            FileUploadHelper::deleteImage($destination->svg_image);
        }

        $destination->translations()->delete();
        $destination->delete();

        return redirect(dashboard_route('admin.tourbooking.destinations.index'))
            ->with('success', 'Destination deleted successfully.');
    }

    public function updateStatus(Destination $destination): RedirectResponse|JsonResponse
    {
        $destination->update(['status' => !$destination->status]);

        $notify_message = trans('translate.Status updated');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return response()->json($notify_message);
    }

    public function updateFeatured(Destination $destination): RedirectResponse|JsonResponse
    {
        $destination->update(['is_featured' => !$destination->is_featured]);

        $notify_message = trans('translate.Featured updated');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return response()->json($notify_message);
    }
}
