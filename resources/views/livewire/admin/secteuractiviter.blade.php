
<div class="dashboard-content-container" data-simplebar>
    <div class="dashboard-content-inner" >
        @if(session('status'))
    <div class="notification success closeable">
        <p>{{ session('status') }}</p>
        <a class="close" href="#"></a>
    </div>
    @endif
        <!-- Dashboard Headline -->
        <div class="dashboard-headline">
            <h3>Manage secteur</h3>
            <!-- Breadcrumbs -->
        </div>
        @if(session('opS')=='all' || session('opS')=='')
            <a wire:click='change("ajoute")' class="button ripple-effect button-sliding-icon" align='right'>Ajouter secteur <i class="icon-feather-activity"></i></a>
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="headline d-flex justify-content-between col-12">
                            <h3><i class="icon-feather-activity"></i> Secteur Activiter</h3>
                            <input type="text" class='col-6 form-control w-50' wire:model.debounce.100ms='search' placeholder="entrez le nom de secteur pour chercher">
                        </div>

                        <div class="content">
                            <ul class="dashboard-box-list">
                            @forelse ($secteurActiviter as $item)
                            <li>
                                <div class="job-listing">
                                    <div class="job-listing-details">

                                        <div class="freelancer-avatar ia">
                                            <a href="#"><img src={{asset('/storage/'.$item->photo) }} alt="eroure " height='76px' width='76px' style="border-radius: 50% !important"></a>
                                        </div>
                                        <div class="freelancer-avatar margin-right-30"></div>
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title"><i class="icon-feather-activity padding-right-30"></i><a>{{ $item->nomSecteurActiviter }}</a></h3>
                                        </div>  
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="buttons-to-right always-visible">

                                    <a wire:click="editSecteur({{ $item->idSecteurActiviter }})" class="button gray ripple-effect ico" title="modifier Secteur" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                    <a wire:click="change('delete',{{ $item->idSecteurActiviter }})" class="button gray ripple-effect ico" title="supprimer Secteur" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                </div>
                            </li>
                            @empty
                           <center class='d-flex justify-content-center col-12'>
                                <div class="freelancer">
                                        <mark class='color'>No Secteur</mark>
                                </div>
                            </center>
                            @endforelse
                            </ul>
                        </div>
                        {{ $secteurActiviter->links('livewire.layoutsLivewire.pagination') }}
                    </div>
                </div>

            </div>
        @elseif(session('opS')=='ajoute')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="headline d-flex justify-content-between">
                        <h3><i class="icon-material-outline-supervisor-account"></i> Ajouter  Secteur</h3>
                    </div>
                    <form wire:submit.prevent='ajouterSecteur' method="post" enctype="multipart/form-data" >
                        <div class="content">
                            <div class="col-xl-6 col-md-6">
                                <div class="section-headline margin-top-25 margin-bottom-12">
                                    <h5>Nom Secteur</h5>
                                </div>
                                <div class="input-with-icon-left no-border">
                                    <i class="icon-feather-activity"></i>
                                    <input type="text" class="input-text" placeholder="Entrez le nom de secteur"  wire:model='nomsecteur'>
                                    @error('nomsecteur')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5>Photo Secteur</h5>
                                    </div>
                                    <input class="padding-left-0"  type="file" placeholder="Placeholder" wire:model='photosecteur'>
                                    @error('photosecteur')
                                        <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <center>
                                <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4">
                                    <button wire:click='change("all")' type='button' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                    <button type="submit" class="button ripple-effect button-sliding-icon">Ajouter<i class="icon-feather-check"></i></button>
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
        @elseif(session('opS')=='update')
            <div class="col-xl-12" wire:ignore.self>
                <div class="dashboard-box margin-top-0">
                    <div class="headline d-flex justify-content-between">
                        <h3><i class="icon-material-outline-supervisor-account"></i> modification  Secteur</h3>
                    </div>
                    <form wire:submit.prevent='updateSecteur' method="post" enctype="multipart/form-data" >
                        <div class="content">
                            <div class="col-xl-6 col-md-6">
                                <div class="section-headline margin-top-25 margin-bottom-12">
                                    <h5>Nom Secteur</h5>
                                </div>
                                <div class="input-with-icon-left no-border">
                                    <i class="icon-feather-activity"></i>
                                    <input type="text" class="input-text" placeholder="Entrez le nom de secteur"  wire:model='nomsecteur2'>
                                    @error('nomsecteur')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5>Photo Secteur</h5>
                                    </div>
                                    <input class="padding-left-0"  type="file" placeholder="Placeholder" wire:model='photosecteur'>
                                    @error('photosecteur')
                                        <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                    <div class="freelancer-avatar ia">
                                        <a href="#"><img src={{asset('/storage/'.$photosecteur) }} alt="" height='76px' width='76px' style="border-radius: 50% !important"></a>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4">
                                    <button wire:click='change("all")' type='button' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                    <button type="submit" class="button ripple-effect button-sliding-icon">Modifier<i class="icon-feather-check"></i></button>
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
        @elseif(session('opS')=='delete')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="headline d-flex justify-content-between">
                        <h3><i class="icon-material-outline-supervisor-account"></i> Ajouter  utilisateur</h3>
                    </div>
                        <center>
                            <div class="content">
                                Vous avez sûr de supprimer <br> le secteur <mark> {{ $nomsecteur }}</mark>  :
                                <br>
                                    <button wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon margin-top-20 margin-bottom-20"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                    <button wire:click='deleteSecteur' class="button ripple-effect button-sliding-icon margin-top-20 margin-bottom-20">supprimer<i class="icon-feather-check"></i></button>
        
                                </div>
                        </div>
                        </center>
            </div>
        @endif
        <!-- Footer -->
        @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->


    </div>
</div>



