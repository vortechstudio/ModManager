<?php

namespace App\Services;

class Translator
{
    protected string $url = 'https://lingva.ml/api/v1';


    public function translate(string $text, string $sourceLang = 'fr', string $targetLang = 'en'): array|string
    {
        $response = \Http::withoutVerifying()
            ->get("{$this->url}/{$sourceLang}/{$targetLang}/".urlencode($text));

        if ($response->successful()) {
            $translatedText = $response->json()['translation'];
            $translatedText = str_replace("\n", "\\n", urldecode($translatedText));
            return $translatedText;
        }

        throw new \Exception("Translatation error: {$response->body()}");
    }

    public function testApi(): bool
    {
        $response = \Http::withoutVerifying()
            ->get("{$this->url}/fr/en/test+description");

        if ($response->serverError()) {
            return false;
        } else {
            return true;
        }
    }
}
