<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SpecialBooking\Database\factories\TransferVehicleFactory;
use Modules\SpecialBooking\App\Traits\HasTranslations;

class TransferVehicle extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $table = 'special_booking_transfer_vehicles';

    protected $fillable = [
        'title',
        'slug',
        'image',
        'icon_class',
        'short_description',
        'capacity_text',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function translation($langCode = null)
    {
        return $this->hasOne(TransferVehicleTranslation::class, 'transfer_vehicle_id')
            ->where('lang_code', $langCode ?? app()->getLocale());
    }

    public function translations()
    {
        return $this->hasMany(TransferVehicleTranslation::class, 'transfer_vehicle_id');
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