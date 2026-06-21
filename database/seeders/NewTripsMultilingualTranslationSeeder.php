<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewTripsMultilingualTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = ['de', 'fr', 'ru', 'tr', 'hi'];
        $serviceIds = range(43, 62);
        
        // Load the translation maps from the database path
        $translations = [];
        foreach ($locales as $locale) {
            $path = database_path("seeders/data/new_trips_translations/translations_{$locale}.json");
            if (!file_exists($path)) {
                $this->command->error("Translation file not found: {$path}");
                continue;
            }
            $translations[$locale] = json_decode(file_get_contents($path), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->command->error("Failed to parse JSON for locale {$locale}: " . json_last_error_msg());
            }
        }
        
        // Helper to perform matching normalising whitespace and carriage returns
        $findTranslation = function ($map, $englishString) {
            if ($englishString === null) {
                return null;
            }
            $normalizedEng = str_replace("\r\n", "\n", trim($englishString));
            foreach ($map as $key => $val) {
                $normalizedKey = str_replace("\r\n", "\n", trim($key));
                if ($normalizedEng === $normalizedKey) {
                    return $val;
                }
            }
            return null;
        };
        
        // Update service_translations
        foreach ($serviceIds as $serviceId) {
            // Find English translation record to serve as the source
            $enTrans = DB::table('service_translations')
                ->where('service_id', $serviceId)
                ->where('locale', 'en')
                ->first();
                
            if (!$enTrans) {
                $this->command->warn("English service translation not found for service ID {$serviceId}");
                continue;
            }
            
            // Inclusions and Exclusions are stored as JSON arrays of strings
            $enIncluded = json_decode($enTrans->included, true) ?? [];
            $enExcluded = json_decode($enTrans->excluded, true) ?? [];
            
            foreach ($locales as $locale) {
                if (!isset($translations[$locale])) {
                    continue;
                }
                
                $map = $translations[$locale];
                
                // Translate basic text fields
                $title = $findTranslation($map['service_titles'], $enTrans->title);
                $shortDesc = $findTranslation($map['service_shorts'], $enTrans->short_description);
                $desc = $findTranslation($map['service_descs'], $enTrans->description);
                
                if ($title === null) {
                    $this->command->warn("Missing title translation for service ID {$serviceId} [{$locale}]");
                    $title = $enTrans->title;
                }
                if ($shortDesc === null) {
                    $this->command->warn("Missing short_description translation for service ID {$serviceId} [{$locale}]");
                    $shortDesc = $enTrans->short_description;
                }
                if ($desc === null) {
                    $this->command->warn("Missing description translation for service ID {$serviceId} [{$locale}]");
                    $desc = $enTrans->description;
                }
                
                // Translate included list items
                $translatedIncluded = [];
                foreach ($enIncluded as $item) {
                    $val = $findTranslation($map['service_list_items'], $item);
                    $translatedIncluded[] = ($val !== null) ? $val : $item;
                }
                
                // Translate excluded list items
                $translatedExcluded = [];
                foreach ($enExcluded as $item) {
                    $val = $findTranslation($map['service_list_items'], $item);
                    $translatedExcluded[] = ($val !== null) ? $val : $item;
                }
                
                $data = [
                    'title' => $title,
                    'short_description' => $shortDesc,
                    'description' => $desc,
                    'included' => json_encode($translatedIncluded, JSON_UNESCAPED_UNICODE),
                    'excluded' => json_encode($translatedExcluded, JSON_UNESCAPED_UNICODE),
                    'seo_title' => null,
                    'seo_description' => null,
                    'updated_at' => now(),
                ];
                
                // Check if target translation record already exists
                $existing = DB::table('service_translations')
                    ->where('service_id', $serviceId)
                    ->where('locale', $locale)
                    ->first();
                    
                if ($existing) {
                    DB::table('service_translations')
                        ->where('id', $existing->id)
                        ->update($data);
                } else {
                    $data['service_id'] = $serviceId;
                    $data['locale'] = $locale;
                    $data['created_at'] = now();
                    DB::table('service_translations')->insert($data);
                }
            }
        }
        
        // Update tour_itinerary_translations
        $itineraries = DB::table('tour_itineraries')
            ->whereIn('service_id', $serviceIds)
            ->get();
            
        foreach ($itineraries as $itinerary) {
            // Find English itinerary translation record as source
            $enItinTrans = DB::table('tour_itinerary_translations')
                ->where('tour_itinerary_id', $itinerary->id)
                ->where('locale', 'en')
                ->first();
                
            if (!$enItinTrans) {
                $this->command->warn("English itinerary translation not found for itinerary ID {$itinerary->id}");
                continue;
            }
            
            foreach ($locales as $locale) {
                if (!isset($translations[$locale])) {
                    continue;
                }
                
                $map = $translations[$locale];
                
                $title = null;
                if ($enItinTrans->title !== null) {
                    $title = $findTranslation($map['itinerary_titles'], $enItinTrans->title);
                    if ($title === null) {
                        $title = $enItinTrans->title;
                    }
                }
                
                $desc = null;
                if ($enItinTrans->description !== null) {
                    $desc = $findTranslation($map['itinerary_descs'], $enItinTrans->description);
                    if ($desc === null) {
                        $desc = $enItinTrans->description;
                    }
                }
                
                $location = null;
                if ($enItinTrans->location !== null) {
                    $location = $findTranslation($map['itinerary_locations'], $enItinTrans->location);
                    if ($location === null) {
                        $location = $enItinTrans->location;
                    }
                }
                
                $data = [
                    'title' => $title,
                    'description' => $desc,
                    'location' => $location,
                    'updated_at' => now(),
                ];
                
                $existing = DB::table('tour_itinerary_translations')
                    ->where('tour_itinerary_id', $itinerary->id)
                    ->where('locale', $locale)
                    ->first();
                    
                if ($existing) {
                    DB::table('tour_itinerary_translations')
                        ->where('id', $existing->id)
                        ->update($data);
                } else {
                    $data['tour_itinerary_id'] = $itinerary->id;
                    $data['locale'] = $locale;
                    $data['created_at'] = now();
                    DB::table('tour_itinerary_translations')->insert($data);
                }
            }
        }
        
        $this->command->info("Multilingual translations applied successfully for de, fr, ru, tr, hi!");
    }
}
