<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NileCruiseCabinTranslation extends Model
{
    protected $table = 'special_booking_nile_cabin_translations';

    protected $fillable = [
        'nile_cabin_id',
        'lang_code',
        'title',
        'short_description',
    ];

    public function nileCruiseCabin(): BelongsTo
    {
        return $this->belongsTo(NileCruiseCabin::class, 'nile_cabin_id');
    }
}
