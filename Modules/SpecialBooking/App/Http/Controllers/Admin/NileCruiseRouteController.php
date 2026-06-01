<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Admin;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\SpecialBooking\App\Models\NileCruiseRoute;

class NileCruiseRouteController extends Controller
{
    public function index(): View
    {
        $routes = NileCruiseRoute::ordered()->get();
        return view('specialbooking::admin.nile_cruise_routes.index', compact('routes'));
    }

    public function create(): View
    {
        return view('specialbooking::admin.nile_cruise_routes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:special_booking_nile_routes,slug',
            'badge_text' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = NileCruiseRoute::where('slug', 'like', $validated['slug'] . '%')->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        if ($request->hasFile('image')) {
            $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'special-booking/nile-routes');
        }

        NileCruiseRoute::create($validated);

        return redirect(dashboard_route('admin.special-booking.nile-cruise-routes.index'))->with(['message' => trans('translate.Created successfully'), 'alert-type' => 'success']);
    }

    public function edit(Request $request, NileCruiseRoute $nile_cruise_route): View
    {
        $lang_code = $request->get('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');

        $translation = \Modules\SpecialBooking\App\Models\NileCruiseRouteTranslation::firstOrNew([
            'nile_route_id' => $nile_cruise_route->id,
            'lang_code' => $lang_code,
        ]);

        if (!$translation->exists) {
            $translation->title = $nile_cruise_route->title;
            $translation->short_description = $nile_cruise_route->short_description;
            $translation->badge_text = $nile_cruise_route->badge_text;
        }

        $nile_cruise_route->setRelation('translation', $translation);

        return view('specialbooking::admin.nile_cruise_routes.edit', compact('nile_cruise_route', 'lang_code'));
    }

    public function update(Request $request, NileCruiseRoute $nile_cruise_route): RedirectResponse
    {
        $lang_code = $request->input('lang_code', function_exists('admin_lang') ? admin_lang() : 'en');
        $isDefault = ($lang_code === (function_exists('admin_lang') ? admin_lang() : 'en'));

        if ($isDefault) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:special_booking_nile_routes,slug,' . $nile_cruise_route->id,
                'badge_text' => 'nullable|string|max:255',
                'image' => 'nullable|image|max:2048',
                'short_description' => 'nullable|string',
                'sort_order' => 'nullable|integer|min:0',
                'status' => 'nullable|boolean',
            ]);

            $validated['status'] = $request->has('status') ? 1 : 0;

            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            if ($request->hasFile('image')) {
                if ($nile_cruise_route->image) {
                    FileUploadHelper::deleteImage($nile_cruise_route->image);
                }
                $validated['image'] = FileUploadHelper::uploadImage($request->file('image'), 'special-booking/nile-routes');
            }

            $nile_cruise_route->update($validated);
        } else {
            $request->validate([
                'title' => 'required|string|max:255',
                'short_description' => 'nullable|string',
                'badge_text' => 'nullable|string|max:255',
            ]);
        }

        \Modules\SpecialBooking\App\Models\NileCruiseRouteTranslation::updateOrCreate(
            [
                'nile_route_id' => $nile_cruise_route->id,
                'lang_code' => $lang_code,
            ],
            [
                'title' => $request->input('title'),
                'short_description' => $request->input('short_description'),
                'badge_text' => $request->input('badge_text'),
            ]
        );

        return redirect(dashboard_route('admin.special-booking.nile-cruise-routes.edit', ['nile_cruise_route' => $nile_cruise_route->id, 'lang_code' => $lang_code]))->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }

    public function destroy(NileCruiseRoute $nile_cruise_route): RedirectResponse
    {
        if ($nile_cruise_route->image) {
            FileUploadHelper::deleteImage($nile_cruise_route->image);
        }

        $nile_cruise_route->delete();

        return redirect(dashboard_route('admin.special-booking.nile-cruise-routes.index'))->with(['message' => trans('translate.Deleted successfully'), 'alert-type' => 'success']);
    }

    public function updateStatus(NileCruiseRoute $nile_cruise_route): RedirectResponse
    {
        $nile_cruise_route->update(['status' => ! $nile_cruise_route->status]);

        return back()->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }
}