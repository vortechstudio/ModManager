<?php

namespace App\Livewire\Core;

use App\Services\ConfigManager;
use Livewire\Attributes\On;
use Livewire\Component;
use Native\Laravel\Facades\Window;

class Start extends Component
{
    public array $config = [];
    public string $message = '';

    public function mount()
    {
        $configManager = new ConfigManager();
        $this->config = $configManager->getConfig();

        // Message initial
        $this->message = 'Initialisation de la configuration';

        // Démarrer la vérification des dépendances après le montage
        $this->dispatch('check-dependencies');
    }

    #[On('check-dependencies')]
    public function checkDependencies()
    {
        $configManager = new ConfigManager();


        // Vérification des dépendances
        if($configManager->checkDependencies()) {
            $this->dispatch('create-folder');
        } else {
            flash()->addError("Erreur lors de la mise à jours...");
        }

        // Fermer la fenêtre actuelle et ouvrir la principale

    }

    #[On('create-folder')]
    public function createFolder()
    {
        if(!\File::exists(storage_path("/app/public/temp_modding"))) {
            \File::makeDirectory(storage_path("/app/public/temp_modding"), 0777, true);
        }
        $this->dispatch('starting-main');
    }

    #[On('starting-main')]
    public function startingMain()
    {
        Window::open('main')
            ->width(1280)
            ->height(720)
            ->route('home')
            ->hideMenu();
        Window::close('starting');
    }

    public function render()
    {
        return view('livewire.core.start');
    }
}
