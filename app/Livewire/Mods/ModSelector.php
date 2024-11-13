<?php

namespace App\Livewire\Mods;

use App\Services\ConfigManager;
use File;
use Livewire\Component;

class ModSelector extends Component
{
    public array $stagingMods = [];
    public array $tempMods = [];
    public array $config = [];
    public string $magicCmd;

    public function mount()
    {
        $manager = new ConfigManager();
        $this->config = $manager->getConfig();

        $this->magicCmd = exec('magick --version') === false
            ? $this->config['image_magick_path']
            : 'magick';

        $this->loadMods();
    }

    public function render()
    {
        return view('livewire.mods.mod-selector');
    }

    private function loadMods()
    {
        $this->stagingMods = array_map('basename', \File::directories($this->config['staging_path']));
        $this->tempMods = array_map('basename', \File::directories(storage_path('/app/public/temp_modding')));
    }

    public function selectedMod($modName, $fromTempModder = false)
    {
        if ($fromTempModder) {
            $this->redirectRoute('edit-mod', ['modDirectory' => $modName]);
        } else {
            $this->copyModToTempModder($modName);
            $this->redirectRoute('edit-mod', ['modDirectory' => $modName]);
        }
    }

    public function createJsonFile($modPath)
    {
        $modData = collect();

        if(\File::exists($modPath.'/mod.lua')) {
            $modLuaContent = \File::get($modPath.'/mod.lua');

            $modData->push([
                'info' => [
                    'minorVersion' => $this->parseLua($modLuaContent, 'minorVersion'),
                    'severityAdd' => $this->parseLua($modLuaContent, 'severityAdd'),
                    'severityRemove' => $this->parseLua($modLuaContent, 'severityRemove'),
                    'authors' => $this->parseAuthors($modLuaContent),
                    'tags' => $this->parseTags($modLuaContent),
                    'visible' => true,
                ]
            ]);
        } else {
            flash()->addError("Le fichier mod.lua n'existe pas");
        }

        if (File::exists($modPath . '/strings.lua')) {
            $stringsContent = File::get($modPath . '/strings.lua');
            $modData->push(['translations' => $this->parseTranslations($stringsContent)]);
        }

        $filePath = $modPath . '/mod_data.json';
        File::put($filePath, json_encode($modData->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function parseLua($content, $key)
    {
        preg_match('/' . $key . '\s*=\s*["\']([^"\']+)["\']/', $content, $matches);
        return $matches[1] ?? '';
    }

    private function parseAuthors($content)
    {
        preg_match_all('/\{\s*name\s*=\s*"([^"]+)",\s*role\s*=\s*"([^"]+)"\s*\}/', $content, $matches, PREG_SET_ORDER);
        $authors = [];
        foreach ($matches as $match) {
            $authors[] = [
                'name' => $match[1],
                'role' => $match[2]
            ];
        }
        return $authors;
    }

    private function parseTags($content)
    {
        preg_match('/tags\s*=\s*\{([^\}]+)\}/', $content, $matches);
        if (!isset($matches[1])) return [];
        $tags = array_map('trim', explode(',', $matches[1]));
        return array_map(function($tag) {
            return trim($tag, '" ');
        }, $tags);
    }

    private function parseTranslations($content)
    {
        preg_match_all('/(\w+)\s*=\s*\{[^}]*"NAME_MOD"\s*=\s*"([^"]+)",\s*"DESC_MOD"\s*=\s*"([^"]+)"[^}]*\}/', $content, $matches, PREG_SET_ORDER);
        $translations = [];
        foreach ($matches as $match) {
            $translations[$match[1]] = [
                'NAME_MOD' => $match[2],
                'DESC_MOD' => $match[3],
            ];
        }
        return $translations;
    }

    private function copyModToTempModder($modName)
    {
        $sourcePath = $this->config['staging_path'] . '/' . $modName;
        $targetPath = storage_path('/app/public/temp_modding/' . $modName);

        \File::copyDirectory($sourcePath, $targetPath);

        $inputPath = $targetPath . '/image_00.tga';
        $outputPath = $targetPath . '/image_00.png';
        $command = "\"{$this->magicCmd}\" \"{$inputPath}\" \"{$outputPath}\"";
        exec($command);

        $this->createJsonFile($targetPath);
    }
}
