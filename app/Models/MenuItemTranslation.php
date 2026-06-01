<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{
    protected $fillable = ['menu_item_id', 'lang_code', 'title'];
}
