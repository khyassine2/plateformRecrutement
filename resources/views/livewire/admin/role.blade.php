    <div class="dashboard-content-container" data-simplebar>
        <div class="dashboard-content-inner" >
            <!-- Dashboard Headline -->
            <div class="dashboard-headline">
                <h3>Manage role</h3>
            </div>
            @if(session('opR')=='all' || session('opR')=='')
                <a wire:click='change("ajoute")' class="button ripple-effect button-sliding-icon" align='right'>Ajouter role<i class="icon-material-outline-settings"></i></a>
                <div class="row">
                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">

                            <!-- Headline -->
                            <div class="headline d-flex justify-content-between col-12">
                                <h3><i class="icon-material-outline-settings"></i> Role</h3>
                            </div>

                            <div class="content">
                                <ul class="dashboard-box-list">
                                @forelse ($role as $item)
                                <li>
                                    <!-- Job Listing -->
                                    <div class="job-listing">

                                        <!-- Job Listing Details -->
                                        <div class="job-listing-details">



                                            <!-- Details -->
                                            <div class="job-listing-description">
                                                <h3 class="job-listing-title"><a href="#">{{ $item->nomRole }}</a></h3>


                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="buttons-to-right always-visible">
                                        <a wire:click="editRole({{ $item->idRole }})" class="button gray ripple-effect ico" title="modifier role" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                        <a wire:click="change('delete',{{ $item->idRole }})" class="button gray ripple-effect ico" title="Remove" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                    </div>
                                </li>
                                @empty
                                <h1 ><mark >no role</mark></h1>
                                @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            @elseif(session('opR')=='ajoute')
                <div wire:ignore.self class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <div class="headline d-flex justify-content-between">
                            <h3><i class="icon-material-outline-supervisor-account"></i> Ajouter  Role</h3>
                        </div>
                        <form wire:submit.prevent='ajouterRole' method="post" >
                            <div class="content">
                                <div class="col-xl-6 col-md-6">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5>Nom Role</h5>
                                    </div>
                                    <div class="input-with-icon-left no-border">
                                        <i class="icon-feather-settings"></i>
                                        <input type="text" class="input-text" placeholder="Entrez le nom de role"  wire:model='nomRole'>
                                        @error('nomRole')
                                        <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <center>
                                    <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4">
                                        <button wire:click='change("all")' type='button' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                        <button type="submit" class="button ripple-effect button-sliding-icon">ajouter<i class="icon-feather-check"></i></button>
                                    </div>
                                </center>

                                <div class="col-xl-6 col-md-6 mb-5"></div>
                                <div class="col-xl-6 col-md-6 mb-5"></div>


                            </div>

                        </form>
                            </div>

                        <div>

                        </div>
                </div>
            @elseif(session('opR')=='update')
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <div class="headline d-flex justify-content-between">
                            <h3><i class="icon-material-outline-supervisor-account"></i> modifier  Role</h3>
                        </div>
                        <form wire:submit.prevent='updateRole' method="post" >
                            <div class="content">
                                <div class="col-xl-6 col-md-6">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5>Nom Role</h5>
                                    </div>
                                    <div class="input-with-icon-left no-border">
                                        <i class="icon-feather-settings"></i>
                                        <input type="text" class="input-text" placeholder="entre le nom de role"  wire:model='nomRole'>
                                        @error('nomRole')
                                        <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <center>
                                    <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4">
                                        <button wire:click='change("all")' type='button' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                        <button type="submit" class="button ripple-effect button-sliding-icon">modifier<i class="icon-feather-check"></i></button>
                                    </div>
                                </center>

                                <div class="col-xl-6 col-md-6 mb-5"></div>
                                <div class="col-xl-6 col-md-6 mb-5"></div>


                            </div>

                        </form>
                            </div>

                        <div>

                        </div>
                </div>
            @elseif(session('opR')=='delete')
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <div class="headline d-flex justify-content-between">
                            <h3><i class="icon-material-outline-supervisor-account"></i> Ajouter  utilisateur</h3>
                        </div>
                        <center>
                            <div class="content">
                                Vous avez sur de supprimer le role <mark> {{ $nomRole }}</mark>  :
                                <br>
                                    <button wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon margin-top-20 margin-bottom-20"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                    <button wire:click='deleteRole' class="button  ripple-effect button-sliding-icon margin-top-20 margin-bottom-20">supprimer<i class="icon-feather-check"></i></button>

                                </div>
                        </center>
                    </div>
                </div>
            @endif
            <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
            <!-- Footer / End -->


        </div>
    </div>



