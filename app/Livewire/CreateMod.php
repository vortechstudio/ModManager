<?php

namespace App\Livewire;

use App\Services\ConfigManager;
use App\Services\Translator;
use File;
use Livewire\Component;

class CreateMod extends Component
{
    public array $config;
    public string $magicCmd;

    public string $nameMod = '';
    public string $authors = '';
    public string $tags = '';
    public string $severityAdd = '';
    public string $severityRemove = '';
    public string $description = '';

    public function mount()
    {
        $manager = new ConfigManager();
        $this->config = $manager->getConfig();

        $this->magicCmd = exec('magick --version') === false
            ? $this->config['image_magick_path']
            : 'magick';
    }

    public function createMod()
    {
        $mod_title = $this->nameMod;
        $name_mod = \Str::slug($mod_title.'_1', '_');

        if(\File::isDirectory($this->config['staging_path'].'/'.$name_mod) || \File::isDirectory(storage_path('/app/public/temp_modding/'.$name_mod))){
            flash()->addError('Le dossier du mod existe déjà', 'Erreur de création');
            return;
        }

        $this->createModDirectory($name_mod);
        $this->createModJsonFile($name_mod, $mod_title);
        $this->createImageTgaFile($name_mod);

        flash()->addSuccess("Mod Créer avec succès");
    }

    public function render()
    {
        return view('livewire.create-mod');
    }

    private function createModDirectory(string $name_mod)
    {
        $folders = [
            'res', 'res/audio/effects', 'res/config/multiple_unit', 'res/config/sound_set',
            'res/config/ui', 'res/construction', 'res/construction/asset', 'res/models/animations',
            'res/models/materials', 'res/models/mesh', 'res/models/model', 'res/scripts',
            'res/textures/models', 'res/textures/ui', 'res/textures/ui/construction/asset',
            'res/textures/ui/construction/categories'
        ];

        foreach ($folders as $folder) {
            File::makeDirectory(storage_path('/app/public/temp_modding') . '/' . $name_mod . '/' . $folder, 0777, true, true);
        }
    }

    public function createImageTgaFile(string $name_mod)
    {
        $outputPath = storage_path('/app/public/temp_modding') . '/' . $name_mod . '/image_00.tga';
        $command = "\"{$this->magicCmd}\" -size 512x512 xc:white \"{$outputPath}\"";
        exec($command);
    }

    private function createModJsonFile(string $name_mod, string $mod_title)
    {
        $translator = new Translator();
        $data = collect();

        $translation = collect()->push([
            'fr' => [
                'NAME_MOD' => $mod_title,
                'DESC_MOD' => $this->description,
            ],
            'en' => [
                'NAME_MOD' => $translator->translate($mod_title, 'fr', 'en'),
                'DESC_MOD' => $translator->translate($this->description, 'fr', 'en'),
            ],
            'de' => [
                'NAME_MOD' => $translator->translate($mod_title, 'fr', 'de'),
                'DESC_MOD' => $translator->translate($this->description, 'fr', 'de'),
            ]
        ]);

        $authorsArray = array_map(function($author) {
            list($name, $role) = array_map('trim', explode(':', $author));
            return ['name' => $name, 'role' => $role];
        }, array_map('trim', explode(',', $this->authors)));

        $tagsArray = array_map('trim', explode(',', $this->tags));

        $data->push([
            'info' => [
                'minorVersion' => 0,
                'severityAdd' => $this->severityAdd,
                'severityRemove' => $this->severityRemove,
                'name' => 'NAME_MOD',
                'description' => 'DESC_MOD',
                'authors' => $authorsArray,
                'tags' => $tagsArray,
                'visible' => true,
            ],
            'translations' => $translation,
        ]);

        $filePath = storage_path('/app/public/temp_modding') . '/' . $name_mod.'/mod_data.json';
        File::put($filePath, json_encode($data->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
