<?php

namespace Modules\SpecialBooking\App\Traits;

trait HasTranslations
{
    /**
     * Retrieve the translated value of a field with proper fallbacks.
     * Fallback order:
     * 1. Current locale translation (e.g. 'ar')
     * 2. Default/admin locale translation (e.g. 'en')
     * 3. Base model property
     */
    public function getTranslatedValue(string $field, ?string $langCode = null, ?string $fallbackLang = null)
    {
        $currentLang = $langCode ?? app()->getLocale();
        $defaultLang = $fallbackLang ?? (function_exists('admin_lang') ? admin_lang() : 'en');

        // 1. Try from loaded 'translations' relation in memory (preferred to avoid N+1)
        if ($this->relationLoaded('translations')) {
            $curr = $this->translations->firstWhere('lang_code', $currentLang);
            if ($curr && !empty($curr->$field)) {
                return $curr->$field;
            }
            $defaultVal = $this->translations->firstWhere('lang_code', $defaultLang);
            if ($defaultVal && !empty($defaultVal->$field)) {
                return $defaultVal->$field;
            }
        }

        // 2. Try from loaded single 'translation' relation in memory
        if ($this->relationLoaded('translation')) {
            $trans = $this->translation;
            if ($trans && $trans->lang_code === $currentLang && !empty($trans->$field)) {
                return $trans->$field;
            }
        }

        // 3. Fallback: Query translation database if not loaded
        if ($this->translations()->exists()) {
            $curr = $this->translations()->where('lang_code', $currentLang)->first();
            if ($curr && !empty($curr->$field)) {
                return $curr->$field;
            }
            $defaultVal = $this->translations()->where('lang_code', $defaultLang)->first();
            if ($defaultVal && !empty($defaultVal->$field)) {
                return $defaultVal->$field;
            }
        }

        // 4. Default: Base model field
        return $this->$field;
    }
}
