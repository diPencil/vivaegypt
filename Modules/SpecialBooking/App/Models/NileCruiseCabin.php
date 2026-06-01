<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SpecialBooking\Database\factories\NileCruiseCabinFactory;
use Modules\SpecialBooking\App\Traits\HasTranslations;

class NileCruiseCabin extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $table = 'special_booking_nile_cabins';

    protected $fillable = [
        'title',
        'short_description',
        'image',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function translation($langCode = null)
    {
        return $this->hasOne(NileCruiseCabinTranslation::class, 'nile_cabin_id')
            ->where('lang_code', $langCode ?? app()->getLocale());
    }

    public function translations()
    {
        return $this->hasMany(NileCruiseCabinTranslation::class, 'nile_cabin_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }
}