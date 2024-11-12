<?php

namespace App\Livewire\Core;

use App\Services\ConfigManager;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use function PHPUnit\Framework\directoryExists;

class CheckConfigSystem extends Component
{
    public array $config = [];
    public bool $staging = false;
    public bool $blender = false;
    public bool $lua = false;
    public bool $modValidator = false;
    public bool $imageMagick = false;
    public bool $allValidate = false;
    public bool $configInit = false;

    public function mount()
    {
        $manager = new ConfigManager();
        $this->config = $manager->getConfig();
        $this->checkConfig();
    }

    public function checkConfig()
    {
        $this->configInit = Storage::exists('public/config.json');
        $this->staging = file_exists($this->config['staging_path']);
        $this->blender = file_exists($this->config['blender_path']);
        $this->lua = file_exists($this->config['lua_path']);
        $this->modValidator = file_exists($this->config['mod_validator_path']);
        $this->imageMagick = file_exists($this->config['image_magick_path']);

        if($this->staging && $this->blender && $this->lua && $this->modValidator && $this->imageMagick){
            $this->allValidate = true;
        }
    }

    public function render()
    {
        return view('livewire.core.check-config-system');
    }
}
