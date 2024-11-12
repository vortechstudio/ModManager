<?php

namespace App\Services;

use File;
use Illuminate\Support\Facades\Http;
use ZipArchive;

class ConfigManager
{
    protected string $configPath;
    public function __construct()
    {
        $this->configPath = storage_path('app/public/config.json');
        $this->initializeConfig();
    }

    private function initializeConfig()
    {
        if(!\File::exists($this->configPath)) {
            $defaultConfig = [
                'staging_path' => '',
                'blender_path' => '',
                'lua_path' => '',
                'mod_validator_path' => '',
                'image_magick_path' => '',
            ];
            \File::put($this->configPath, json_encode($defaultConfig, JSON_PRETTY_PRINT));
        }
    }

    public function getConfig()
    {
        return json_decode(\File::get($this->configPath), true);
    }

    public function updateConfig(array $config)
    {
        \File::put($this->configPath, json_encode($config, JSON_PRETTY_PRINT));
    }

    public function checkDependencies()
    {
        $config = $this->getConfig();

        $tempDir = storage_path('app/public/temp');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true); // true pour créer les sous-dossiers manquants
        }

        if(empty($config['blender_path']) || !File::exists($config['blender_path'])) {
            $config['blender_path'] = $this->installBlender();
        }

        if(empty($config['lua_path']) || !File::exists($config['lua_path'])) {
            $config['lua_path'] = $this->installLua();
        }

        if(empty($config['mod_validator_path']) || !File::exists($config['mod_validator_path'])) {
            $config['mod_validator_path'] = $this->installModValidator();
        }
        if(empty($config['image_magick_path']) || !File::exists($config['image_magick_path'])) {
            $config['image_magick_path'] = $this->installImageMagick();
        }

        $this->updateConfig($config);
        return true;
    }

    private function installBlender()
    {
        $url = 'https://download.blender.org/release/Blender4.2/blender-4.2.3-windows-x64.zip';
        $zipPath = storage_path('app/public/temp/blender.zip');
        $installPath = storage_path('app/public/bin/blender');

        $this->downloadAndExtract($url, $zipPath, $installPath);
        File::put($installPath.'/version', "4.2.3");

        // Retourne le chemin vers l'exécutable de Blender
        return $installPath . '/blender.exe';
    }

    private function installLua()
    {
        $url = 'https://downloads.sourceforge.net/project/luabinaries/5.4.2/Tools%20Executables/lua-5.4.2_Win64_bin.zip?ts=gAAAAABnMooQHqTA__20HI3eFd1YEbY0-pWssmN22b6WMH6okz-vfKDrm3AnMnvqb2BV0CBa6YOcmDbBkhH4FsdhYqQ44L-ssw%3D%3D&r=https%3A%2F%2Fsourceforge.net%2Fprojects%2Fluabinaries%2Ffiles%2F5.4.2%2FTools%2520Executables%2Flua-5.4.2_Win64_bin.zip%2Fdownload';
        $zipPath = storage_path('app/public/temp/lua.zip');
        $installPath = storage_path('app/public/bin/lua');

        $this->downloadAndExtract($url, $zipPath, $installPath);
        File::put($installPath.'/version', "5.4.2");

        // Retourne le chemin vers l'exécutable de Lua
        return $installPath . '/lua.exe';
    }

    private function installModValidator()
    {
        $url = 'https://www.transportfever2.com/wiki/lib/exe/fetch.php?media=modding:tools:tf2_modvalidator_public_v0.10.0.zip';
        $zipPath = storage_path('app/public/temp/mod_validator.zip');
        $installPath = storage_path('app/public/bin/mod_validator');
        $named = 'TF2_ModValidator_Public.exe';

        $this->downloadAndExtract($url, $zipPath, $installPath);
        File::move($installPath.'/'.$named, $installPath.'/mod_validator.exe');
        File::put($installPath.'/version', "0.10.0");

        // Retourne le chemin vers l'exécutable du Mod Validator
        return $installPath . '/mod_validator.exe';
    }

    private function installImageMagick()
    {
        $url = 'https://imagemagick.org/archive/binaries/ImageMagick-7.1.1-40-portable-Q16-x64.zip';
        $zipPath = storage_path('app/public/temp/imagemagick.zip');
        $installPath = storage_path('app/public/bin/imagemagick');

        $this->downloadAndExtract($url, $zipPath, $installPath);
        File::put($installPath.'/version', "7.1.1-40");

        // Retourne le chemin vers l'exécutable de ImageMagick
        return $installPath . '/magick.exe';
    }

    private function downloadAndExtract(string $url, string $zipPath, string $extractPath): void
    {
        set_time_limit(120);
        ini_set('memory_limit', '2048M');

        // Téléchargement du fichier
        $response = Http::withoutVerifying()->timeout(300)->get($url);
        if ($response->successful()) {
            File::put($zipPath, $response->body());
        } else {
            throw new \Exception("Erreur lors du téléchargement de l'archive depuis $url");
        }

        // Création d'un dossier temporaire pour l'extraction
        $extractTempPath = storage_path('app/public/temp/extracted');
        if (!File::exists($extractTempPath)) {
            File::makeDirectory($extractTempPath, 0755, true);
        }

        // Initialiser ZipArchive
        $zip = new ZipArchive;

        // Vérifier si le fichier ZIP s'ouvre correctement
        if ($zip->open($zipPath) === TRUE) {
            // Extraction du fichier ZIP dans le dossier temporaire
            $zip->extractTo($extractTempPath);

            // Obtenir le nom du premier élément extrait
            $firstIndexName = $zip->getNameIndex(0);
            $zip->close();

            // Suppression de l'archive ZIP pour économiser de l'espace
            File::delete($zipPath);

            // Vérifier si le premier élément est un sous-dossier ou des fichiers à la racine
            $extractedSubfolder = $extractTempPath . '/' . trim($firstIndexName, '/');
            if (File::isDirectory($extractedSubfolder)) {
                // Cas où il y a un sous-dossier : déplacer le contenu du sous-dossier vers le dossier final
                if (!File::exists($extractPath)) {
                    File::makeDirectory($extractPath, 0755, true);
                }
                File::copyDirectory($extractedSubfolder, $extractPath);
            } else {
                // Cas où les fichiers sont à la racine : déplacer tous les fichiers du dossier temporaire vers le dossier final
                if (!File::exists($extractPath)) {
                    File::makeDirectory($extractPath, 0755, true);
                }
                File::copyDirectory($extractTempPath, $extractPath);
            }

            // Suppression du dossier temporaire
            File::deleteDirectory($extractTempPath);
        } else {
            throw new \Exception("Erreur lors de l'ouverture du fichier ZIP. Fichier corrompu ou non accessible.");
        }
    }



}
