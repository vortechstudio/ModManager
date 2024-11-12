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
        $this->createModLuaFile($name_mod);
        $this->createStringLuaFile($name_mod, $mod_title);
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

    public function createModLuaFile(string $name_mod)
    {
        // Transformation des auteurs en format Lua avec `name` et `role`
        $authorsArray = array_map('trim', explode(',', $this->authors));
        $authorsLua = implode(",\n                ", array_map(function($author) {
            list($name, $role) = array_map('trim', explode(':', $author));
            return "{
                    name = \"$name\",
                    role = \"$role\"
                }";
        }, $authorsArray));

        // Transformation des tags en tableau Lua
        $tagsArray = array_map('trim', explode(',', $this->tags));
        $tagsLua = "tags = { \"" . implode('", "', $tagsArray) . "\" },";

        // Génération du contenu de `mod.lua`
        $content = <<<LUA
function data()
return {
        info = {
            minorVersion = 0,
            severityAdd = 'NONE',
            severityRemove = 'NONE',
            name = _("NAME_MOD"),
            description = _("DESC_MOD"),
            authors = {
                $authorsLua
            },
            $tagsLua
            visible = true,
        }
    }
end
LUA;

        $filePath = storage_path('/app/public/temp_modding') . '/' . $name_mod . '/mod.lua';
        File::put($filePath, $content);
    }

    public function createStringLuaFile(string $name_mod, string $mod_title)
    {
        $translator = new Translator();
        if ($translator->testApi()) {
            $titleEN = $translator->translate($mod_title, 'fr', 'en');
            $titleDE = $translator->translate($mod_title, 'fr', 'de');
            $descriptionEN = $translator->translate($this->description, 'fr', 'en');
            $descriptionDE = $translator->translate($this->description, 'fr', 'de');
        } else {
            $titleEN = $titleDE = $mod_title;
            $descriptionEN = $descriptionDE = $this->description;
        }

        $content = <<<LUA
function data()
    return {
        fr = {
            ["NAME_MOD"] = "$mod_title",
            ["DESC_MOD"] = "{$this->description}",
        },
        en = {
            ["NAME_MOD"] = "$titleEN",
            ["DESC_MOD"] = "$descriptionEN",
        },
        de = {
            ["NAME_MOD"] = "$titleDE",
            ["DESC_MOD"] = "$descriptionDE",
        },
    }
end
LUA;

        $filePath = storage_path('/app/public/temp_modding') . '/' . $name_mod . '/strings.lua';
        File::put($filePath, $content);
    }

    public function createImageTgaFile(string $name_mod)
    {
        $outputPath = storage_path('/app/public/temp_modding') . '/' . $name_mod . '/image_00.tga';
        $command = "\"{$this->magicCmd}\" -size 512x512 xc:white \"{$outputPath}\"";
        exec($command);
    }
}
