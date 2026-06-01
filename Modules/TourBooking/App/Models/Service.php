<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Wishlist\App\Models\Wishlist;

final class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'slug',
        'location',
        'latitude',
        'longitude',
        'service_type_id',
        'destination_id',
        'price_per_person',
        'full_price',
        'discount_price',
        'child_price',
        'infant_price',
        'security_deposit',
        'deposit_required',
        'deposit_percentage',
        'included',
        'excluded',
        'duration',
        'group_size',
        'languages',
        'check_in_time',
        'check_out_time',
        'ticket',
        'amenities',
        'facilities',
        'rules',
        'safety',
        'cancellation_policy',
        'meta',
        'is_featured',
        'is_popular',
        'show_on_homepage',
        'status',
        'video_url',
        'address',
        'email',
        'phone',
        'website',
        'social_links',
        'user_id',
        'is_new',
        'room_count',
        'adult_count',
        'children_count',
        'tour_plan_sub_title',
        'google_map_sub_title',
        'google_map_url',
        'is_per_person'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'included' => 'json',
        'excluded' => 'json',
        'languages' => 'array',
        'amenities' => 'array',
        'facilities' => 'json',
        'rules' => 'json',
        'safety' => 'json',
        'cancellation_policy' => 'json',
        'meta' => 'json',
        'social_links' => 'json',
        'price_per_person' => 'decimal:2',
        'full_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'infant_price' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'deposit_required' => 'boolean',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'show_on_homepage' => 'boolean',
        'status' => 'boolean',
        'is_new' => 'boolean',
        'is_per_person' => 'boolean'
    ];

    /**
     * Get the service type of this service.
     */
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }

    /**
     * Get the destination of this service.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get the user (owner) of this service.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the media items for this service.
     */
    public function media(): HasMany
    {
        return $this->hasMany(ServiceMedia::class);
    }

    /**
     * Get the featured image for this service.
     */
    public function thumbnail(): HasOne
    {
        return $this->hasOne(ServiceMedia::class)
            ->where('is_thumbnail', true)
            ->withDefault();
    }

    /**
     * Get the reviews for this service.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function activeReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 1);
    }

    /**
     * Get the extra charges for this service.
     */
    public function extraCharges(): HasMany
    {
        return $this->hasMany(ExtraCharge::class);
    }

    /**
     * Get the availabilities for this service.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Get the bookings for this service.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the itineraries for this service (if it's a tour).
     */
    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class)->orderBy('day_number');
    }

    /**
     * Get the translation for current locale.
     */
    public function translation(): HasOne
    {
        return $this->hasOne(ServiceTranslation::class)
            ->where('locale', app()->getLocale())
            ->withDefault();
    }

    /**
     * Get all translations for this service.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ServiceTranslation::class);
    }

    /**
     * Get the computed discounted price attribute.
     */
    protected function discountedPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!empty($this->discount_price)) {
                    return $this->discount_price;
                }

                if (!empty($this->full_price)) {
                    return $this->full_price;
                }

                return $this->price_per_person;
            }
        );
    }

    /**
     * Get the computed discount percentage attribute.
     */
    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->full_price) || empty($this->discount_price)) {
                    return 0;
                }

                return round((($this->full_price - $this->discount_price) / $this->full_price) * 100);
            }
        );
    }

    /**
     * Get the computed average rating attribute.
     */
    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->reviews()->where('status', true)->avg('rating') ?? 0;
            }
        );
    }

    /**
     * Get the computed review count attribute.
     */
    protected function reviewCount(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->reviews()->where('status', true)->count();
            }
        );
    }

    /**
     * Featured services scope.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Popular services scope.
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Homepage services scope.
     */
    public function scopeShowOnHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    /**
     * Active services scope.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Service type scope.
     */
    public function scopeOfType($query, $typeId)
    {
        return $query->where('service_type_id', $typeId);
    }

    /**
     * By price range scope.
     */
    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('discounted_price', [$min, $max]);
    }

    /**
     * Search by location scope.
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function getPriceDisplayAttribute()
    {
        if ($this->is_per_person) {
            return currency($this->price_per_person);
        }

        return $this->discount_price
            ? '<del>' . currency($this->full_price) . '</del> ' . currency($this->discount_price)
            : currency($this->full_price);
    }

    public function wishlists()
    {
        return $this->morphMany(Wishlist::class, 'wishable');
    }

    public function myWishlist()
    {
        return $this->hasOne(Wishlist::class, 'wishable_id', 'id')->where('user_id', auth()->id());
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'name', 'email', 'image', 'username');
    }
}
