<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SpecialBooking\Database\factories\TransferRequestFactory;

use App\Models\User;

class TransferRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'request_reference',
        'user_id',
        'full_name',
        'email',
        'phone',
        'whatsapp',
        'vehicle_type',
        'pickup_location',
        'dropoff_location',
        'pickup_date',
        'pickup_time',
        'passengers_count',
        'luggage_count',
        'transfer_type',
        'is_airport_transfer',
        'flight_number',
        'notes',
        'status',
        'admin_notes',
        'quoted_price',
        'payment_status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'pickup_date' => 'date',
        'passengers_count' => 'integer',
        'luggage_count' => 'integer',
        'is_airport_transfer' => 'boolean',
        'quoted_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
