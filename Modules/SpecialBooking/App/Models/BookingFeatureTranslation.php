<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingFeatureTranslation extends Model
{
    protected $table = 'special_booking_feature_translations';

    protected $fillable = [
        'booking_feature_id',
        'lang_code',
        'title',
        'short_description',
    ];

    public function bookingFeature(): BelongsTo
    {
        return $this->belongsTo(BookingFeature::class, 'booking_feature_id');
    }
}
