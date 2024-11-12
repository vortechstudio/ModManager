<?php

namespace App\Livewire\Core;

use App\Livewire\Forms\Core\ConfigurationForm;
use App\Services\ConfigManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Configuration extends Component
{
    public string $staging_path = '';
    public bool $config_path = false;
    public bool $staging = false;
    public bool $blender = false;
    public bool $modValidator = false;
    public bool $imageMagick = false;
    public bool $lua = false;
    public array $config;

    public function mount()
    {
        $configManager = new ConfigManager();
        $this->config = $configManager->getConfig();

        $this->staging_path = $this->config['staging_path'];
        $this->config_path = Storage::exists('public/config.json');
        $this->staging = empty($this->config['staging_path']);
        $this->blender = file_exists($this->config['blender_path']);
        $this->modValidator = file_exists($this->config['mod_validator_path']);
        $this->imageMagick = file_exists($this->config['image_magick_path']);
        $this->lua = file_exists($this->config['lua_path']);
    }

    public function save()
    {
        $configManager = new ConfigManager();
        $this->config['staging_path'] = $this->staging_path;
        $configManager->updateConfig($this->config);
    }

    public function render()
    {
        return view('livewire.core.configuration');
    }
}
