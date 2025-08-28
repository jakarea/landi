<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\Category;
// use App\Models\Product;

trait SlugTrait
{
    /**
     * Generate a unique slug for a category name.
     *
     * If the initial slug is not unique in the database, append a number until a unique slug is found.
     *
     * @param  string  $name           The category name for which to generate the slug.
     * @param  int     $originalSlug   (Optional) The original category's slug when updating, to avoid conflict with its own slug.
     * @param  int     $iteration      (Optional) The iteration number to append to the slug to ensure uniqueness.
     * @return string  The unique slug.
     */

    protected function makeUniqueSlug($name,$model, $originalSlug = null)
    {
        $modelClass = '\App\Models' . '\\' . $model;

        $iteration = 1;
        $existingItem = null;
        $toSlug = $name;

        while (true) {
            if ($existingItem) {
                $toSlug = $name . '-' . $iteration;
            }

            // Generate the initial slug
            $slug = Str::slug($toSlug);

            // Check if the slug is unique in the database
            $existingItem = $modelClass::where('slug', $slug)->first();

            // If the slug is unique, or it belongs to the original category being updated
            if (!$existingItem || ($originalSlug && $existingItem->slug == $originalSlug)) {
                return $slug;
            }

            $iteration++;
        }
    }
}
