<div class="app-navbar-item ms-1 ms-lg-5">
    @if($allValidate)
    <a href="" class="btn btn-icon btn-custom btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="tooltip-inverse" data-bs-title="Configuration OK">
        <i class="ki-outline ki-verify text-success fs-1"></i>
    </a>
    @else
        <a href="#configError" id="btnShowConfigError" class="btn btn-icon btn-custom btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-bs-toggle="modal" title="Erreur de Configuration">
            <i class="ki-outline ki-cross-circle text-danger fs-1"></i>
        </a>
    @endif
        <div class="modal fade" tabindex="-1" id="configError">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Etat du programme</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                <span>Configuration initialisées</span>
                                @if($configInit)
                                    <i class="fa-solid fa-check text-success fs-1"></i>
                                @else
                                    <i class="fa-solid fa-times text-danger fs-1"></i>
                                @endif
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                <span>Dossier Staging Area</span>
                                @if($staging)
                                    <i class="fa-solid fa-check text-success fs-1"></i>
                                @else
                                    <i class="fa-solid fa-times text-danger fs-1"></i>
                                @endif
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                <span>Image Magick Installée</span>
                                @if($imageMagick)
                                    <i class="fa-solid fa-check text-success fs-1"></i>
                                @else
                                    <i class="fa-solid fa-times text-danger fs-1"></i>
                                @endif
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                <span>Blender Installée</span>
                                @if($blender)
                                    <i class="fa-solid fa-check text-success fs-1"></i>
                                @else
                                    <i class="fa-solid fa-times text-danger fs-1"></i>
                                @endif
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                <span>Mod Validator</span>
                                @if($modValidator)
                                    <i class="fa-solid fa-check text-success fs-1"></i>
                                @else
                                    <i class="fa-solid fa-times text-danger fs-1"></i>
                                @endif
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                <span>Vérificateur LUA</span>
                                @if($lua)
                                    <i class="fa-solid fa-check text-success fs-1"></i>
                                @else
                                    <i class="fa-solid fa-times text-danger fs-1"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>

