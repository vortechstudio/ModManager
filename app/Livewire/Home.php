<?php

namespace App\Livewire;

use App\Services\ConfigManager;
use File;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Home extends Component
{
    public int $allMods = 0;
    public int $editMods = 0;
    public array $recentlyModifiedMods = [];

    public function mount()
    {
        $manager = new ConfigManager();
        $config = $manager->getConfig();

        $this->loadData($config);
    }

    public function loadData(array $config)
    {
        $this->allMods = count(\File::directories($config['staging_path']));
        $this->editMods = count(\File::directories(storage_path('/app/public/temp_modding')));
        $this->recentlyModifiedMods = $this->getRecentlyModifiedMods($config['staging_path']);
    }
    public function render()
    {
        return view('livewire.home');
    }

    private function getRecentlyModifiedMods(string $staging_path)
    {
        $mods = [];
        foreach (\File::directories($staging_path) as $directory) {

            $mods[] = [
                'name' => basename($directory),
                'updated_at' => Carbon::createFromTimestamp(\File::lastModified($directory)),
            ];
        }

        usort($mods, function ($a, $b) {
            return strtotime($b['updated_at']) - strtotime($a['updated_at']);
        });

        return array_slice($mods, 0, 5);
    }
}
