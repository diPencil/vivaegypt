<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SpecialBooking\Database\factories\FlightRequestFactory;

use App\Models\User;

class FlightRequest extends Model
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
        'trip_type',
        'from_city',
        'to_city',
        'departure_date',
        'return_date',
        'adults',
        'children',
        'infants',
        'travel_class',
        'preferred_airline',
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
        'departure_date' => 'date',
        'return_date' => 'date',
        'adults' => 'integer',
        'children' => 'integer',
        'infants' => 'integer',
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
