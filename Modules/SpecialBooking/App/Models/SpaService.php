<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SpecialBooking\Database\factories\SpaServiceFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SpecialBooking\App\Traits\HasTranslations;

class SpaService extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'image',
        'duration_minutes',
        'price',
        'price_note',
        'location',
        'gender_type',
        'available_days',
        'available_time_from',
        'available_time_to',
        'max_guests_per_slot',
        'sort_order',
        'status',
        'meta_title',
        'meta_description',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'available_days' => 'array',
        'price' => 'decimal:2',
        'status' => 'boolean',
        'duration_minutes' => 'integer',
        'max_guests_per_slot' => 'integer',
        'sort_order' => 'integer',
    ];

    public function translation($langCode = null)
    {
        return $this->hasOne(SpaServiceTranslation::class, 'spa_service_id')
            ->where('lang_code', $langCode ?? app()->getLocale());
    }

    public function translations()
    {
        return $this->hasMany(SpaServiceTranslation::class, 'spa_service_id');
    }

    /**
     * Get the bookings for the SPA service.
     */
    public function bookings()
    {
        return $this->hasMany(SpaBooking::class);
    }
}
