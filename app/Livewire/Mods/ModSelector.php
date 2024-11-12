<?php

namespace App\Livewire\Mods;

use App\Services\ConfigManager;
use Livewire\Component;

class ModSelector extends Component
{
    public array $stagingMods = [];
    public array $tempMods = [];
    public array $config = [];

    public function mount()
    {
        $manager = new ConfigManager();
        $this->config = $manager->getConfig();

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

    private function copyModToTempModder($modName)
    {
        $sourcePath = $this->config['staging_path'] . '/' . $modName;
        $targetPath = storage_path('/app/public/temp_modding/' . $modName);

        \File::copyDirectory($sourcePath, $targetPath);
    }
}
