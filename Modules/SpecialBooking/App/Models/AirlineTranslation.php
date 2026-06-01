<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirlineTranslation extends Model
{
    protected $table = 'special_booking_airline_translations';

    protected $fillable = [
        'airline_id',
        'lang_code',
        'name',
        'short_description',
    ];

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }
}
