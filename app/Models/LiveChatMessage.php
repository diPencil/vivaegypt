<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveChatMessage extends Model
{
    protected $fillable = ['chat_id', 'sender_type', 'message'];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(LiveChat::class, 'chat_id');
    }
}
