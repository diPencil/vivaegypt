<?php

namespace Modules\Language\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Language\Database\factories\LanguageFactory;

class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function getLangNameAttribute($value): string
    {
        $nativeNames = [
            'en' => 'English',
            'ar' => 'العربية',
            'de' => 'Deutsch',
            'fr' => 'Français',
            'ru' => 'Русский',
            'tr' => 'Türkçe',
            'hi' => 'हिन्दी',
            'es' => 'Español',
            'it' => 'Italiano',
            'zh' => '中文',
            'ja' => '日本語',
        ];

        $languageCode = strtolower((string) ($this->attributes['lang_code'] ?? ''));

        return $nativeNames[$languageCode] ?? $value;
    }
}
