<div>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-7">
                        <span class="fs-2 fw-bold">Nombre de mods total</span>
                        <span class="fw-bolder fs-1 text-success">{{ $allMods }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-7">
                        <span class="fs-2 fw-bold">Nombre de mods en edition</span>
                        <span class="fw-bolder fs-1 text-warning">{{ $editMods }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Derniers Mods Modifiés</h5>
                    <ul class="list-group">
                        @foreach($recentlyModifiedMods as $mod)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $mod['name'] }}
                                <span class="badge badge-primary badge-pill">{{ $mod['updated_at'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
