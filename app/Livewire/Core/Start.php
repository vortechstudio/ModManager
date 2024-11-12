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
            Window::open('main')
                ->route('home')
                ->width(1200)
                ->height(730)
                ->title(config('app.name'))
                ->hideMenu();
            Window::close('starting');
        } else {
            flash()->addError("Erreur lors de la mise à jours...");
        }

        // Fermer la fenêtre actuelle et ouvrir la principale

    }

    public function render()
    {
        return view('livewire.core.start');
    }
}
