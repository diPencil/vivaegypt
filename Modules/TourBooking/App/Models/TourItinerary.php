<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class TourItinerary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'title',
        'day_number',
        'description',
        'location',
        'duration',
        'meal_included',
        'image',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'day_number' => 'integer',
        'display_order' => 'integer',
    ];

    /**
     * Get the service (tour) that this itinerary belongs to.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get all translations for this itinerary.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(TourItineraryTranslation::class);
    }

    /**
     * Get the translation for current locale.
     */
    public function translation(): HasOne
    {
        return $this->hasOne(TourItineraryTranslation::class)
            ->where('locale', app()->getLocale())
            ->withDefault();
    }

    public function translationFor(string $locale): ?TourItineraryTranslation
    {
        if ($this->relationLoaded('translations')) {
            return $this->translations->firstWhere('locale', $locale);
        }

        return $this->translations()->where('locale', $locale)->first();
    }

    public function translated(string $field, ?string $locale = null): mixed
    {
        $currentLocale = $locale ?: app()->getLocale();
        $translation = $this->translationFor($currentLocale);

        if ($translation && filled($translation->{$field})) {
            return $translation->{$field};
        }

        if ($currentLocale !== 'en') {
            $englishTranslation = $this->translationFor('en');

            if ($englishTranslation && filled($englishTranslation->{$field})) {
                return $englishTranslation->{$field};
            }
        }

        return $this->{$field};
    }

    /**
     * Order by day number scope.
     */
    public function scopeOrderByDay($query)
    {
        return $query->orderBy('day_number');
    }

    /**
     * Order by display order scope.
     */
    public function scopeOrderByDisplay($query)
    {
        return $query->orderBy('display_order');
    }
} 
