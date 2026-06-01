<?php

namespace Modules\SpecialBooking\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpaServiceTranslation extends Model
{
    protected $table = 'spa_service_translations';

    protected $fillable = [
        'spa_service_id',
        'lang_code',
        'title',
        'description',
        'short_description',
        'price_note',
        'location',
        'meta_title',
        'meta_description',
    ];

    public function spaService(): BelongsTo
    {
        return $this->belongsTo(SpaService::class);
    }
}
