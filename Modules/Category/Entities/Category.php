<?php

namespace Modules\Category\Entities;

use Modules\Listing\Entities\Listing;

use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\CategoryTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Ecommerce\Entities\Product;

class Category extends Model
{
    use HasFactory;


    protected $appends = ['name', 'total_services'];

    protected $hidden = ['front_translate'];

    public function translate(){
        return $this->belongsTo(CategoryTranslation::class, 'id', 'category_id')->where('lang_code', admin_lang());
    }

    public function front_translate(){
        return $this->belongsTo(CategoryTranslation::class, 'id', 'category_id')->where('lang_code', front_lang());
    }

    public function getNameAttribute()
    {
        return $this->front_translate->name;
    }

    public function getTotalServicesAttribute(): int
    {
        return 0;
    }

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }

}
