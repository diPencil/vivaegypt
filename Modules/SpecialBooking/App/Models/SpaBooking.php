<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SpecialBooking\Database\factories\SpaBookingFactory;

use App\Models\User;

class SpaBooking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'booking_reference',
        'spa_service_id',
        'user_id',
        'full_name',
        'email',
        'phone',
        'whatsapp',
        'preferred_date',
        'preferred_time',
        'guests_count',
        'gender_type',
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
        'preferred_date' => 'date',
        'guests_count' => 'integer',
        'quoted_price' => 'decimal:2',
    ];

    /**
     * Get the service that owns the booking.
     */
    public function spaService()
    {
        return $this->belongsTo(SpaService::class, 'spa_service_id');
    }

    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
