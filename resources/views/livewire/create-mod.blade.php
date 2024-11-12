<form wire:submit="createMod">
    <div class="alert alert-dismissible bg-light-primary border border-primary  d-flex flex-column flex-sm-row w-100 p-5 mb-10">
        <!--begin::Icon-->
        <i class="ki-duotone ki-search-list fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                    <!--end::Icon-->

        <!--begin::Content-->
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <h5 class="mb-1">Information</h5>
            <span>La création de mod enregistrera le mod dans un dossier temporaire du programme, pour le transférer dans le staging area il faut entrée en mode édition.</span>
        </div>
        <!--end::Content-->

        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>                    </button>
        <!--end::Close-->
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-5">
                <label for="" class="form-label required">Nom du mod</label>
                <input type="text" wire:model="nameMod" class="form-control" required>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-5">
                        <label for="" class="form-label required">Auteurs du mod</label>
                        <input type="text" wire:model="authors" name="authors" class="form-control" required>
                        <p>Format: Name:role / si vous avez plusieurs auteurs, les séparés par une virgule</p>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-5">
                        <label for="" class="form-label required">Tags</label>
                        <input type="text" wire:model="tags" name="tags" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <label for="" class="form-label required">Description du mod</label>
                <textarea name="description" id="description" class="form-control" cols="30" rows="10" wire:model="description" required></textarea>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex flex-center">
                <button class="btn btn-primary w-100">Créer le mod</button>
            </div>
        </div>
    </div>
</form>
@section('scripts')

@endsection
