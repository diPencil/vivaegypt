<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TourItineraryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_itinerary_id',
        'locale',
        'title',
        'description',
        'location',
        'meal_included',
    ];

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(TourItinerary::class, 'tour_itinerary_id');
    }
}
