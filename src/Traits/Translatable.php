<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Traits;

trait Translatable
{
    /**
     * Boot the translatable trait
     */
    public static function bootTranslatable()
    {
        static::saved(function ($model) {
            $model->saveTranslations();
        });
    }

    /**
     * Get all translations for this model
     */
    public function translations()
    {
        return $this->morphMany(
            \Sanwarul\Organogram\Models\Translation::class,
            'translatable',
            'table_name',
            'model_id'
        );
    }

    /**
     * Get translation for specific attribute and locale
     */
    public function translate(string $attribute, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $translation = $this->translations()
            ->where('locale', $locale)
            ->where('attribute', $attribute)
            ->first();
        return $translation ? $translation->value : $this->getOriginal($attribute);
    }

    /**
     * Set translation for specific attribute and locale
     */
    public function setTranslation(string $attribute, string $locale, string $value)
    {
        $translation = $this->translations()
            ->where('locale', $locale)
            ->where('attribute', $attribute)
            ->first();
            
        if ($translation) {
            $translation->value = $value;
            $translation->save();
        } else {
            $this->translations()->create([
                'locale' => $locale,
                'attribute' => $attribute,
                'value' => $value
            ]);
        }
    }

    /**
     * Save all translations from the translations property
     */
    public function saveTranslations()
    {
        if (!property_exists($this, 'translationsToSave')) {
            return;
        }
        
        foreach ($this->translationsToSave as $attribute => $values) {
            foreach ($values as $locale => $value) {
                $this->setTranslation($attribute, $locale, $value);
            }
        }
        
        $this->translationsToSave = [];
    }

    /**
     * Magic method to get translated attributes
     */
    public function __get($key)
    {
        if (in_array($key, $this->translatable ?? [])) {
            return $this->translate($key);
        }
        
        return parent::__get($key);
    }
}