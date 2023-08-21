<div style='width: 96% !important'>
@if(session('opAlldemande')=='allDemande' || session('opAlldemande')=='')
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="sidebar-container margin-top-30 margin-left-15">
                    <!-- Location -->
                     <div class="sidebar-widget">
                        <h3>Type de demande</h3>
                        <select wire:model='typeDemandeSearch'>
                            <option value=''>Choisir le type de demande</option>
                            <option value="stage">Stage</option>
                            <option value="emploi">Emploi</option>
                        </select>
                    </div>
                    @if($typeDemandeSearch=='stage')
                        <div class="sidebar-widget">
                            <h3>Début période de stage</h3>
                            <input type="date" wire:model='dateDebutStage'>
                        </div>
                            <div class="sidebar-widget">
                            <h3>Duree de Stage</h3>
                            <div class="input-with-icon">
                                <div id="autocomplete-container">
                                    <select wire:model="dureeStage">
                                        <option value="">Choissisez la duree</option>
                                        <option value="1 mois">1 mois</option>
                                        <option value="2 mois">2 mois</option>
                                        <option value="3 mois">3 mois</option>
                                        <option value="4 mois">4 mois</option>
                                        <option value="5 mois">5 mois</option>
                                        <option value="6 mois">6 mois</option>
                                        <option value="Plus de 6 mois">Plus de 6 mois</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                    @endif
                   
                    
    
                    <!-- Category -->
                    <div class="sidebar-widget">
                        <h3>Formation</h3>
                        <select wire:model='formationSearch' >
                            <option value="">Choisissez une Formation</option>
                            @forelse ($typeFormation as $item)
                                <option value="{{ $item->idSecteurActiviter }}">{{ $item->nomSecteurActiviter }}</option>
                            @empty
                                <option value="">no Formation/option>
                            @endforelse
                        </select>
                    </div>
                    <div class="sidebar-widget">
                        <h3>Niveau Etudes</h3>
                        <select wire:model='niveauEtude'>
                            <option value="Bac">Choisissez Niveau d'etude</option>'
                            <option value="Bac">Bac</option>
                            <option value="Bac+1">Bac+1</option>
                            <option value="Bac+2">Bac+2</option>
                            <option value="Bac+3">Bac+3</option>
                            <option value="Bac+4">Bac+4</option>
                            <option value="Bac+5">Bac+5</option>
                            <option value="Plus de Bac+5">Plus de Bac+5</option>
                            <option value="Niveau Bac">Niveau Bac</option>
                            <option value="CQP">CQP</option>
                        </select>
                    </div>
                    <div class="sidebar-widget">
                        <h3>Ville</h3>
                        <div class="input-with-icon">
                            <div>
                                <select wire:model='villeSearch'>
                                    <option value="">Choisissez la ville</option>
                                    @forelse ($villes as $item)
                                        <option value="{{ $item->id }}">{{ $item->nomVille }}</option>
                                    @empty
                                        <option value="">No ville</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 content-left-offset padding-top-35">

                <h3 class="page-title">Recherche Results</h3>
                <div class="freelancers-container freelancers-grid-layout margin-top-35">

                    <!--Freelancer -->
                    @forelse ($demande as $key=>$item)
                    <div class="freelancer">

                        <!-- Overview -->
                        <div class="freelancer-overview">
                            <div class="freelancer-overview-inner">

                                <!-- Bookmark Icon -->

                                <!-- Avatar -->
                                <div class="freelancer-avatar">
                                    <a  wire:click="change('detailsDemande',{{ $item->idDemande }})" title='{{ $item->utilisateurs->nomUtilisateur." ".$item->utilisateurs->prenomUtilisateur }}'><img src={{asset('/storage/'.$item->utilisateurs->photo)}} alt="" height='100px'></a>
                                </div>

                                <!-- Name -->
                                <div class="freelancer-name">
                                    <h4 class='text-capitalize'><a href="single-freelancer-profile.html">{{ $item->titreDemande." (".$item->villes->nomVille.")" }}</a></h4>
                                    <span>{{ $item->niveauEtude }}</span>
                                </div>
                                <!-- Rating -->
                                <div class="freelancer-rating margin-top-10">

                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="freelancer-details">
                            <div class="freelancer-details-list">
                                <ul>
                                  <center>
                                    <li>Formation <strong class='text-capitalize'>{{ $item->secteurActiviter->nomSecteurActiviter }}</strong></li>
                                    @if($item->typeDemande=='stage')
                                        <li>Type Stage <strong class='text-capitalize'>{{ $item->typeStage }}</strong></li>
                                    @endif
                                        <li>Type Demande <strong class='text-capitalize'>{{ $item->typeDemande }}</strong></li>
                                  </center>
                                </ul>
                            </div>
                            <center>
                                <button type="button" wire:click="change('detailsDemande',{{ $item->idDemande }})" class="button button-sliding-icon ripple-effect">Afficher Demande <i class="icon-material-outline-arrow-right-alt"></i></button>
                            </center>
                        </div>
                    </div>
                    @empty
                        <center class='d-flex justify-content-center col-12'>
                            <div class="freelancer">
                                <mark class='color'>no demande dans votre recherche</mark>
                            </div>
                        </center>
                    @endforelse
                <!-- Freelancers List Container -->


                <!-- Tasks Container / End -->


                <!-- Pagination -->
                <div class="clearfix"></div>
                <div class='col-12'>
                    <center>
                    {{$demande->links('livewire.layoutsLivewire.pagination')}}
                </center>
                </div>
                <!-- Pagination / End -->

            </div>
            <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
            <!-- Footer / End -->
        </div>
@elseif(session('opAlldemande')=='detailsDemande')
        <div class="single-page-header freelancer-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="single-page-header-inner">
                            <div class="left-side">
                                <div class="header-image freelancer-avatar"><img src={{asset('/storage/' .$this->demandedata->utilisateurs->photo)}} alt="" width='140px' height='140px'></div>
                                <div class="header-details">
                                    <h3>{{ $demandedata->utilisateurs->nomUtilisateur.' '.$demandedata->utilisateurs->prenomUtilisateur }} {!! "<span class='d-inline'>($age Ans)</span>" !!} <span>{{ $demandedata->niveaEtude }}</span></h3><br>
                                    <ul>
                                        <li><div><br>
                                            @for($i = 1; $i <= 5; $i++)
                                            @if(isset($demandedata->utilisateurs->levelSite) &&$demandedata->utilisateurs->levelSite->nomLevelSite >= $i)
                                                <i class="icon-line-awesome-star" style="color: #febe42 !important;font-size: 22px !important"></i>
                                            @elseif(isset($demandedata->utilisateurs->levelSite) && $demandedata->utilisateurs->levelSite->nomLevelSite >= $i-0.5)
                                                <i class="icon-line-awesome-star-half-o" style="color: #febe42 !important;font-size: 22px !important"></i>
                                            @else
                                                <i class="icon-line-awesome-star-o" style="color: #febe42 !important;font-size: 22px !important"></i>
                                            @endif
                                            @endfor
                                        </div></li>
                                        <li><strong><i class="icon-material-outline-location-on"></i> {{ $demandedata->utilisateurs->ville }}</strong></li>
                                        <li><strong>
                                            @if($afftele==false)
                                                <button type="button" wire:click="verify('telephone',{{ $demandedata->utilisateurs }})" class="button button-sliding-icon ripple-effect">Afficher Numero<i class="icon-feather-phone"></i></button>
                                            @elseif($afftele==true)
                                                <i class="icon-feather-phone"></i>
                                                {{ $demandedata->utilisateurs->telephone }}
                                            @endif
                                        </strong></li>
                                        <li><strong>
                                            @if($affemail==false)
                                                <button type="button" wire:click="verify('email',{{ $demandedata->utilisateurs }})" class="button button-sliding-icon ripple-effect">Afficher Email<i class="icon-feather-mail"></i></button>
                                            @elseif($affemail==true)
                                                <i class="icon-feather-mail"></i>
                                                {{$demandedata->utilisateurs->email}}
                                            @endif
                                        </strong></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <!-- Page Content
        ================================================== -->
            <div class="container ">
                <div class="row ">
                    <!-- Content -->
                    <div class="col-xl-12 col-lg-12 content-right-offset margin-bottom-30">

                        <!-- Page Content -->
                        <div class="single-page-section margin-bottom-0">
                            <h3 class="text-capitalize"><strong>Titre Demande</strong> : {{ $demandedata->titreDemande }}</h3>
                        </div>
                        <div class="single-page-section margin-bottom-0">
                            <h3 class="text-capitalize"><strong>Type Demande</strong> : {{ $demandedata->typeDemande }}</h3>
                        </div>
                        <div class="single-page-section margin-bottom-0">
                            <h3 class="text-capitalize"><strong>Formation</strong> : {{ $demandedata->niveauEtude }}</h3>
                        </div>
                        <div class="single-page-section margin-bottom-0">
                            <h3 class="text-capitalize"><strong>Type de Formation</strong> : {{ $demandedata->secteurActiviter->nomSecteurActiviter }}</h3>
                        </div>
                        @if($demandedata->typeDemande=='stage')
                        <div class="single-page-section margin-bottom-0">
                            <h3 class=""><strong>Durée du stage </strong> : {!!"<span class='d-inline'> $demandedata->dureeStage($dateDebut au $dateFin)</span>" !!}</h3>
                        </div>
                        <div class="single-page-section margin-bottom-0">
                            <h3 class="margin-bottom-15 text-capitalize"><strong>Type de Stage </strong> : {{ $demandedata->typeStage }}</h3>
                        </div>
                        @endif
                        <div class="single-page-section margin-bottom-0">
                            <h3 class="margin-bottom-15 text-capitalize"><strong>Ville {{ $demandedata->typeDemande }}: </strong>  {{ $demandedata->villes->nomVille }}</h3>
                        </div>
                        <div class="single-page-section margin-bottom-0">
                            <h3 class="margin-bottom-15"><strong>curriculum vitae </strong> : <button type="button" wire:click="verify('cv',{{ $demandedata->utilisateurs }})" class="button button-sliding-icon">Telecharger<i class="icon-material-outline-save-alt"></i></button></h3>
                        </div>
                        @if(session('showEmail')==true)
                        <div class="single-page-section margin-bottom-0 ">
                            <h3 class="margin-bottom-15"><strong>Object de l'email </strong> :</h3>
                            <input type="text" class='w-50' wire:model.defer='object'>
                        </div>
                        <div class="single-page-section margin-bottom-0">
                            <h3 class="margin-bottom-15"><strong>Message de l'email </strong> :</h3>
                            <textarea cols="30" rows="5" class="with-border w-50" wire:model.defer='message' ></textarea>
                        </div>
                        @endif
    <!-- Boxed List -->
                <div class="boxed-list margin-bottom-60">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-business-center"></i>Suggestion demande</h3>
                    </div>

                    <div class="listings-container compact-list-layout">

                        <!-- Job Listing -->
                        @forelse ($demandeSugestion as $key=>$item)
                            <a wire:click="change('detailsDemande',{{ $item->idDemande }})" class="job-listing" title="{{$item->utilisateurs->nomUtilisateur.'_'.$item->utilisateurs->prenomUtilisateur  }}">
                                <!-- Job Listing Details -->
                                <div class="job-listing-details">

                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <div class="d-flex">
                                            <img style="border-radius: 50% !important" src={{asset('/storage/'.$item->utilisateurs->photo)}} alt="" width='60px' height='60px' >
                                            <div class="margin-left-20">
                                                <h3 class="job-listing-title"><strong>{{ $item->titreDemande }}</strong>
                                                <span>
                                                    @if($item->typeDemande=='stage')
                                                        ({{ $item->typeStage }})
                                                    @endif
                                                </span>
                                                </h3>
                                                <div class="job-listing-footer">
                                                    <ul>
                                                        <li><i class="icon-material-outline-location-on"></i> {{ $item->villes->nomVille }}</li>
                                                        <li><i class="icon-material-outline-business-center"></i> {{ $item->secteurActiviter->nomSecteurActiviter }}</li>
                                                        @if($item->typeDemande=='stage')
                                                        <li><i class="icon-material-outline-date-range"></i> {{ $item->DateDebutStage }}</li>
                                                        @endif
                                                        <li><i class="icon-material-outline-settings"></i> {{ $item->typeDemande }}</li>
                                                        <li><i class="icon-material-outline-access-time"></i> {{ $dateDiff[$key] }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Job Listing Footer -->

                                    </div>

                                </div>
                            </a>
                        @empty

                        @endforelse

                    </div>

                </div>
    <!-- Boxed List / End -->
    <div class="col-12">
        <center>
            <button type="button" wire:click="change('allDemande')" class="button button-sliding-icon ripple-effect"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
            @if(Auth::guard('entreprise')->check())
            @if(session('showEmail')==true)
                <button type="button" wire:click="sendemail({{$demandedata}})" class="button button-sliding-icon ripple-effect">Send Email<i class="icon-feather-mail"></i></button>
            @else
                <button type="button" wire:click="change('showEmail')" class="button button-sliding-icon ripple-effect" wire:loading.attr="disabled">Envoyer Email<i class="icon-material-outline-arrow-forward"></i></button>
            @endif
            @endif
        </center>
        </div>
    </div>
                    </div>
            </div>
        </div>
            <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
            <!-- Footer / End -->
        </div>
@endif
</div>
