<div class="dashboard-content-container">
    <div class="dashboard-content-inner">

        
        @if ($op == 'all')
            <div class="dashboard-headline">
                <h3 class="">Manage offres</h3>
            </div>
            <a class='button grey ripple-effect button-sliding-icon' wire:click='change("ajoute")' title="Ajouter Offre"
                data-tippy-placement="top">Ajouter Offre<i class="icon-material-outline-add"></i></a>


            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                       

                        <div class="content">


                            <!-- Overview -->
                            <ul class="dashboard-box-list">
                                @forelse ($offres as $item)
                                    <li>
                                        <div class="freelancer-overview manage-candidates">
                                            <div class="freelancer-overview-inner ">
                                                <div>


                                                    <!-- Name -->
                                                    <div class="freelancer-name">
                                                        <h4><a>{{ $item->titreOffre }}</a></h4>

                                                        <!-- Details -->
                                                        <span class="freelancer-detail-item"><a><i
                                                                    class="icon-material-outline-business-center"></i>
                                                                {{ $item->competenceRequise }}</a></span>
                                                        <span class="freelancer-detail-item"><i
                                                                class="icon-line-awesome-money"></i>{{ $item->RemunurationPropose }}
                                                            DH</span>
                                                        <br>
                                                        <span class="freelancer-detail-item"><i
                                                                class="icon-material-outline-business"></i>{{ $item->entreprise_has_secteurs->entreprises->nomEntreprise }}</span>
                                                        <span class="freelancer-detail-item"><i
                                                                class="icon-material-outline-business"></i>{{ $item->entreprise_has_secteurs->secteur_activiters->nomSecteurActiviter }}</span>
                                                        <br>
                                                        <span
                                                            class="freelancer-detail-item dashboard-status-button green">Posted
                                                            :
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->datePublie)->locale('fr_FR')->isoFormat('DD MMMM YYYY') }}</span>
                                                        <span
                                                            class="freelancer-detail-item dashboard-status-button red">Expiring
                                                            :
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->dateCloture)->locale('fr_FR')->isoFormat('DD MMMM YYYY') }}</span>
                                                       

                                                        

                                                        <!-- Buttons -->
                                                        <div
                                                            class="buttons-to-right always-visible margin-top-25 margin-bottom-5">

                                                            <a wire:click="tocandidate({{ $item->idOffre }})"
                                                                class="button ripple-effect"><i
                                                                    class="icon-material-outline-supervisor-account"></i>
                                                                Manage Candidates <span
                                                                    class="button-info">{{ count($offres->find($item->idOffre)->candidatures) }}</span></a>

                                                            <a wire:click="edit({{ $item->idOffre }})"
                                                                class="button gray ripple-effect ico"
                                                                title="modifier Offre" data-tippy-placement="top"><i
                                                                    class="icon-feather-edit"></i></a>

                                                            <a wire:click="change('delete',{{ $item->idOffre }})"
                                                                class="button gray ripple-effect ico"
                                                                title="supprimer Offre" data-tippy-placement="top"><i
                                                                    class="icon-feather-trash-2"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @empty
                                        <br>
                                        <center class='d-flex justify-content-center col-12'>
                                            <div class="freelancer">
                                                <mark class='color'>No Offres Publié</mark>
                                            </div>
                                        </center>
                                        <br>
                                @endforelse
                                </li>

                            </ul>


                        </div>
                    </div>
                   
                </div>
                @elseif($op == 'ajoute')
           
                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>Ajouter offre</h3>
    
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Dashboard</a></li>
                            <li>Post a Job</li>
                        </ul>
                    </nav>
                </div>
    
                <!-- Row -->
                <div class="row">
                    <form wire:submit.prevent='ajouterOffres' method="post" enctype="multipart/form-data">
                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">
    
                            <!-- Headline -->
                            <div class="headline">
                                <h3><i class="icon-feather-folder-plus"></i>Offre Formulaire</h3>
                            </div>
    
                            <div class="content with-padding padding-bottom-10">
                                <div class="row">
                                    
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Titre offre</h5>
    
                                            <input type="text" class="with-border" placeholder="entre le titre"
                                                wire:model='titre'>
                                            @error('titre')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Competence Requise</h5>
    
                                            <input type="text" class="textarea" wire:model='competenceRequise'
                                                placeholder="entre votre competence Requise">
                                            @error('competenceRequise')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Remunuration Proposer</h5>
    
                                            <input type="RemunurationPropose" class="input-text"
                                                wire:model='RemunurationPropose' placeholder="entre Remunuration Propose">
                                            @error('RemunurationPropose')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
    
    
    
    
    
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>date Publie</h5>
    
    
                                            <input type="date" class="input-date" wire:model='datePublie'
                                                placeholder="entre datePublie">
                                            @error('datePublie')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
    
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>date Cloture</h5>
    
    
                                            <input type="date" class="input-text" wire:model='dateCloture'>
                                            @error('dateCloture')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
    
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>type d'offre</h5>
    
    
                                            <select wire:model='Valtypeoffre'>
                                                <option>choissisez le type d'offre</option>
    
                                                <option value="Stage">Stage</option>
                                                <option value="emploi">emploi</option>
    
                                            </select>
    
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Secteur d'Activiter</h5>
                                                <select wire:model='Valsecteuractiviter'>
                                                    <option>Choissisez le Secteur</option>
                                                    @forelse (Auth::guard('entreprise')->user()->secteurs as $item)
                                                        <option  value={{ $item->idSecteurActiviter }}>
                                                            {{ $item->nomSecteurActiviter }}</option>
                                                    @empty
                                                        <option>no Secteur</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Test Competence</h5>
                                                <select wire:model='test'>
                                                    <option>choissisez si il y'a test</option>
                                                    <option value="non">non</option>
                                                    <option value="oui">oui</option>
                                                </select>
                                                @error('test')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
    
    
    
    
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>Description Offre</h5>
                                            <textarea cols="30" rows="5" placeholder="entre le description" wire:model='description' class="with-border"></textarea>
                                            
                                    @error('description')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <center>
                                        <button wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                                <button type="submit" class="button dark ripple-effect button-sliding-icon">ajouter<i class="icon-feather-check"></i></button>
                                            </center>
                                    <br>        </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    
                    </form>
                </div>
                <!-- Row / End -->
            @elseif($op == 'edit')
                <!-- Row -->
                <div class="row">
                    <form wire:submit.prevent='ajouterOffres' method="post" enctype="multipart/form-data">
                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">
    
                            <!-- Headline -->
                            <div class="headline">
                                <h3><i class="icon-material-outline-local-offer"></i>Modification Offre :</h3>
                            </div>
    
                            <div class="content with-padding padding-bottom-10">
                                <div class="row">
                                    
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Titre offre</h5>
    
                                            <input type="text" class="with-border" placeholder="entre le titre"
                                                wire:model='titreDelete'>
                                            @error('titreDelete')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Competence Requise</h5>
    
                                            <input type="text" class="textarea" wire:model='competenceRequiseDelete'
                                                placeholder="entre votre competence Requise">
                                            @error('competenceRequiseDelete')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Remunuration Proposer</h5>
    
                                            <input type="RemunurationPropose" class="input-text"
                                                wire:model='RemunurationProposeDelete' placeholder="entre Remunuration Propose">
                                            @error('RemunurationProposeDelete')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>date Publie</h5>
    
    
                                            <input type="date" class="input-date" wire:model='datePublieDelete'
                                                placeholder="entre datePublie">
                                            @error('datePublieDelete')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
    
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>date Cloture</h5>
    
    
                                            <input type="date" class="input-text" wire:model='dateClotureDelete'>
                                            @error('dateClotureDelete')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
    
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>type d'offre</h5>
    
    
                                            <select wire:model='ValtypeoffreDelete'>
                                                <option>choissisez le type d'offre</option>
                                                @forelse ($typeOffre as $item)
                                                <option value={{ $item }}
                                                    {{ $ValtypeoffreDelete == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @empty
                                                <option>no One</option>
                                            @endforelse
    
                                            </select>
    
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Secteur d'Activiter</h5>
                                                <select wire:model='ValsecteuractiviterDelete'>
                                                    @forelse (Auth::guard('entreprise')->user()->secteurs as $item)
                                                    <option value={{ $item->idSecteurActiviter }} {{ $ValsecteuractiviterDelete==$item->idSecteurActiviter?'selected':'' }}>{{ $item->nomSecteurActiviter }}</option>
                                                    @empty
                                                        <option>no Secteur</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Test Competence</h5>
                                                <select wire:model='test'>
                                                    <option>choissisez si il y'a test</option>
                                                    <option value="non" {{ $test=='non'?'selected':'' }}>non</option>
                                                    <option value="oui" {{ $test=='oui'?'selected':'' }}>oui</option>
                                                </select>
                                                @error('test')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>Description offre</h5>
                                            <textarea cols="30" rows="5" placeholder="entre le description" wire:model='descriptionDelete' class="with-border"></textarea>
                                            
                                    @error('descriptionDelete')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <center>
                                        <button wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                        <button wire:click='update()' class="button dark ripple-effect button-sliding-icon">Modifier<i class="icon-feather-check"></i></button>
                                            </center>
                                    <br> </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    
                    </form>
                </div>
                <!-- Row / End -->
                
            @elseif($op == 'delete')
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <div class="headline ">
                            <h3><i class="icon-material-outline-local-offer"></i> Supprimer Offre</h3>
                        </div>
                        <center>
                            <div class="content">
                                <br>
                                Confirmer la suppression d'Offre <mark> {{ $titreDelete }}</mark> :
                                <br><br>
                                <button type='button' wire:click='change("all")' type="button"
                                    class="button ripple-effect button-sliding-icon"><i
                                        class="icon-material-outline-arrow-back"></i>Annuler</button>
                                <button wire:click='delete'
                                    class="button dark ripple-effect button-sliding-icon">supprimer<i
                                        class="icon-feather-check"></i></button>
                                <br><br>
                            </div>
                        </center>
                    </div>
                </div>
    
            @elseif($op == 'historiquecandidatures')
                <livewire:admin.candidatures :prop1="$offreId" />
    
            @endif
            <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
            <!-- Footer / End -->
