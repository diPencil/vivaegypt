<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferVehicleTranslation extends Model
{
    protected $table = 'special_booking_transfer_vehicle_translations';

    protected $fillable = [
        'transfer_vehicle_id',
        'lang_code',
        'title',
        'short_description',
        'capacity_text',
    ];

    public function transferVehicle(): BelongsTo
    {
        return $this->belongsTo(TransferVehicle::class);
    }
}
