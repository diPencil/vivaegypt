<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NileCruiseRouteTranslation extends Model
{
    protected $table = 'special_booking_nile_route_translations';

    protected $fillable = [
        'nile_route_id',
        'lang_code',
        'title',
        'badge_text',
        'short_description',
    ];

    public function nileCruiseRoute(): BelongsTo
    {
        return $this->belongsTo(NileCruiseRoute::class, 'nile_route_id');
    }
}
