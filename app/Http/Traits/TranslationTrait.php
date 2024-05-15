<?php

namespace App\Http\Traits;

trait TranslationTrait
{

    public function getTranslatableRequest($translatable, $request, array $langs)
    {
        $input = [];
        foreach ($request as $key => $value) {

            if (in_array($key, $translatable)) {
                foreach ($langs as $lang) {
                    $input[$key][$lang] = $value;
                }
            } else {
                $input[$key] = $value;
            }
        }
        return $input;
    }
}
