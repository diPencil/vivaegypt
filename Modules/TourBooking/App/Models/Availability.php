<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Availability extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'date',
        'start_time',
        'end_time',
        'is_available',
        'available_spots',
        'special_price',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_available' => 'boolean',
        'available_spots' => 'integer',
        'special_price' => 'decimal:2',
    ];

    /**
     * Get the service that this availability belongs to.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Available dates scope.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Unavailable dates scope.
     */
    public function scopeUnavailable($query)
    {
        return $query->where('is_available', false);
    }

    /**
     * Dates in range scope.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Future dates scope.
     */
    public function scopeFuture($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    /**
     * Has special price scope.
     */
    public function scopeHasSpecialPrice($query)
    {
        return $query->whereNotNull('special_price');
    }
} 