<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SpecialBooking\Database\factories\NileCruiseRequestFactory;

use App\Models\User;

class NileCruiseRequest extends Model
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
        'route',
        'checkin_date',
        'nights_count',
        'adults',
        'children',
        'cabins_count',
        'cabin_type',
        'budget_range',
        'need_airport_transfer',
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
        'checkin_date' => 'date',
        'nights_count' => 'integer',
        'adults' => 'integer',
        'children' => 'integer',
        'cabins_count' => 'integer',
        'need_airport_transfer' => 'boolean',
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
