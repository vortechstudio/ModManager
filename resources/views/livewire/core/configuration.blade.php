<div class="row">
    <div class="col-sm-12 col-lg-9">
        <form wire:submit="save" class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Configuration</h3>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-sm btn-success">
                        Valider
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-5">
                    <label for="" class="form-label">Chemin du Staging Area</label>
                    <input type="text" wire:model.live.debounce.500ms="staging_path" class="form-control">
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-12 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                        <span>Fichier de configuration</span>
                        <span>
                            @if(!$config_path)
                                <i class="ki-duotone ki-cross text-danger fs-1"></i>
                            @else
                                <i class="ki-duotone ki-check text-success fs-1"></i>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                        <span>Staging area</span>
                        <span>
                            @if($staging)
                                <i class="fa-solid fa-times text-danger fs-1"></i>
                            @else
                                <i class="ki-duotone ki-check text-success fs-1"></i>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                        <span>Blender CLI</span>
                        <span>
                            @if(!$blender)
                                <i class="fa-solid fa-times text-danger fs-1"></i>
                            @else
                                <i class="ki-duotone ki-check text-success fs-1"></i>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                        <span>Mod Validator</span>
                        <span>
                            @if(!$modValidator)
                                <i class="fa-solid fa-times text-danger fs-1"></i>
                            @else
                                <i class="ki-duotone ki-check text-success fs-1"></i>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                        <span>Image Magick</span>
                        <span>
                            @if(!$imageMagick)
                                <i class="fa-solid fa-times text-danger fs-1"></i>
                            @else
                                <i class="ki-duotone ki-check text-success fs-1"></i>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                        <span>LUA System</span>
                        <span>
                            @if(!$lua)
                                <i class="fa-solid fa-times text-danger fs-1"></i>
                            @else
                                <i class="ki-duotone ki-check text-success fs-1"></i>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
