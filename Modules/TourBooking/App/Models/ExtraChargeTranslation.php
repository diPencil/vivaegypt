<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ExtraChargeTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'extra_charge_id',
        'locale',
        'name',
        'description',
    ];

    public function extraCharge(): BelongsTo
    {
        return $this->belongsTo(ExtraCharge::class);
    }
}
