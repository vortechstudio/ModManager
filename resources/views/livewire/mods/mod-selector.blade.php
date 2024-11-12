<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">Mods Disponible (Staging Area)</h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column">
                    @foreach($stagingMods as $mod)
                        <div class="d-flex flex-row justify-content-between align-items-center mb-5">
                            <span>{{ $mod }}</span>
                            <button class="btn btn-sm btn-primary" wire:click="selectedMod('{{ $mod }}')">Editer</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">Mods en edition</h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column">
                    @foreach($tempMods as $mod)
                        <div class="d-flex flex-row justify-content-between align-items-center mb-5">
                            <span>{{ $mod }}</span>
                            <button class="btn btn-sm btn-primary" wire:click="selectedMod('{{ $mod }}', true)">Continuer l'édition</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
