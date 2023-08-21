<div class="dashboard-content-container">
    <div class="dashboard-content-inner">
        @if (session('opO') == 'all' || session('opO')=='')
            <div class="dashboard-headline">
                <h3 class="">Manage offres</h3>
            </div>
            <a class='button grey ripple-effect button-sliding-icon' wire:click='change("ajoute")' title="Ajouter Offre"
                data-tippy-placement="top">Ajouter Offre<i class="icon-material-outline-add"></i></a>


            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <br>
                        <center>
                            <div class="tt">
                                <div><span class="tts">Min Price : {{ $minPrice }} DH </span><input
                                        type="range"  wire:model="minPrice" value="0"
                                        max="10000" step="500"/></div>
                                <div><span>Max Price : {{ $maxPrice }} DH </span><input type="range"
                                        id="range" wire:model="maxPrice" value="10000" max="10000"
                                        step="500" /></div>

                            </div>
                        </center>

                            <div class="dd d-flex justify-content-between">
                                <div class="col-6">

                                    <label for="start_date">Date Debut:</label>
                                    <input class="di" type="date" class="input-text" wire:model="dateFilter1">
                                </div>
                                <div class="col-6">
                                    <label for="end_date">Date Fin:</label>
                                    <input class="di" type="date" class="input-text" wire:model="dateFilter2">
                                </div>
                            </div>
                        <!-- Headline -->
                        <div class="isma headline d-flex justify-content-between ">



                            <select wire:model="type" class="nn col-3 form-select"
                                wire:change="filterByTypeOffre($event.target.value)">
                                <option value="">Toutes les type d'offre </option>
                                    <option value='stage'>Stage</option>
                                    <option value='emploi'>emploi</option>
                            </select>
                            <select wire:model="entreprises" class="nn col-3 form-select"
                                wire:change="filterByEnreprise($event.target.value)">
                                <option value="">Toutes les Entreprise</option>
                                @forelse ($entreprise as $item)
                                    <option value={{ $item->idEntreprise }}>{{ $item->nomEntreprise }}</option>
                                @empty
                                @endforelse
                            </select>
                            <select wire:model="secteurs" class="nn col-3 form-select"
                                wire:change="filterBySecteurs($event.target.value)">
                                <option value="">Toutes les secteurs d'activiter </option>

                                  @forelse ($secteuractiviterr as $item)
                                <option value={{$item->idSecteurActiviter}}>{{$item->nomSecteurActiviter}}</option>
                            @empty

                            @endforelse
                            </select>

                            <div class='nn input-with-icon-left'>
                                <i class="icon-material-outline-search"></i><input class="sd" wire:model="filterby" type="search"
                                    placeholder="titre d'offre ...">

                            </div>

                            <br>


                        </div>


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
                                                        <h4 class='text-capitalize'><a>{{ $item->titreOffre }}</a></h4>

                                                        <!-- Details -->
                                                        <span class="freelancer-detail-item text-capitalize"><a><i
                                                                    class="icon-material-outline-business-center"></i>
                                                                {{ $item->competenceRequise }}</a></span>
                                                        <span class="freelancer-detail-item"><i
                                                                class="icon-line-awesome-money"></i>{!! $item->RemunurationPropose==0?"<strong>No Remunuration</strong>":$item->RemunurationPropose.' DH' !!}
                                                            </span>
                                                        <br>
                                                        <span class="freelancer-detail-item text-capitalize"><i
                                                                class="icon-material-outline-business"></i>{{ $item->entreprise_has_secteurs->entreprises->nomEntreprise }} ({{ $item->secteur->nomSecteurActiviter }})</span>
                                                        <span class="freelancer-detail-item text-capitalize"><i
                                                            class=""></i>{{ $item->typeOffre }}</span>
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
                                                <mark class='color'>No Offres</mark>
                                            </div>
                                        </center>
                                        <br>
                                @endforelse
                                </li>

                            </ul>


                        </div>
                    </div>
                    {{ $offres->links('livewire.layoutsLivewire.pagination') }}
                </div>

            </div>
        @elseif(session('opO') == 'ajoute')

            <!-- Dashboard Headline -->
            <div class="dashboard-headline">
                <h3>Ajouter offre</h3>
            </div>

            <!-- Row -->
            <div class="row">
                <form wire:submit.prevent='ajouterOffres' method="post" enctype="multipart/form-data">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="headline">
                            <h3><i class="icon-feather-folder-plus"></i>Ajouter Offre</h3>
                        </div>

                        <div class="content with-padding padding-bottom-10">
                            <div class="row">

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Titre offre</h5>

                                        <input type="text" class="with-border" placeholder="entre le titre"
                                            wire:model.defer='titre'>
                                        @error('titre')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Competence Requise</h5>

                                        <input type="text" class="textarea" wire:model.defer='competenceRequise'
                                            placeholder="entre votre competence Requise">
                                        @error('competenceRequise')
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
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Remunuration Proposer</h5>

                                            <input type="RemunurationPropose" class="input-text"
                                                wire:model.defer='RemunurationPropose' placeholder="entre Remunuration Propose">
                                            @error('RemunurationPropose')
                                                <span class='text-danger'>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>date Publie</h5>
                                        <input type="date" class="input-date" wire:model.defer='datePublie'
                                            placeholder="entre datePublie">
                                        @error('datePublie')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>date Cloture</h5>


                                        <input type="date" class="input-text" wire:model.defer='dateCloture'>
                                        @error('dateCloture')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Entreprise</h5>
                                        <select wire:model='Valentreprise'>
                                            <option value="">selecter l entreprise</option>
                                            @forelse ($entreprise as $item)
                                                <option value={{ $item->idEntreprise }}>{{ $item->nomEntreprise }}
                                                </option>
                                            @empty
                                                <option>no One</option>
                                            @endforelse
                                        </select>

                                    </div>
                                </div>

                                @if (isset($secteuractiviter) && count($secteuractiviter)>=1)
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Secteur d'Activiter</h5>
                                            <select wire:model='Valsecteuractiviter'>
                                                <option>selecter d'Activiter</option>
                                                @forelse ($secteuractiviter as $item)
                                                    <option value={{ $item->idSecteurActiviter }}>
                                                        {{ $item->nomSecteurActiviter }}</option>
                                                @empty
                                                    <option>no Secteur</option>
                                                @endforelse
                                            </select>
                                        </div>
                                </div>

                                @elseif ($Valentreprise!=='' && isset($secteuractiviter) && count($secteuractiviter)<=1)
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Secteur d'Activiter</h5>
                                        <div class="section-headline">
                                            <mark>rien secteur pour cette entreprise</mark>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-xl-4">
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
                                        <textarea cols="30" rows="5" placeholder="entre le description" wire:model.defer='description' class="with-border"></textarea>

                                @error('description')
                                <span class='text-danger'>{{ $message }}</span>
                                @enderror
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <center>
                                    <button type='button' wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                    <button type="submit" class="button  ripple-effect button-sliding-icon">ajouter<i class="icon-feather-check"></i></button>
                                        </center>
                                <br>        </div>
                            </div>
                        </div>
                    </div>
                </div>


                </form>
            </div>
            <!-- Row / End -->
        @elseif(session('opO') == 'edit')
            <!-- Row -->
            <div class="row" wire:ignore.self>
                <form wire:submit.prevent='ajouterOffres' method="post" enctype="multipart/form-data">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="headline">
                            <h3><i class="icon-feather-folder-plus"></i>modification Offre :</h3>
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
                                            <option value="Stage">Stage</option>
                                            <option value="emploi">emploi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Entreprise</h5>
                                        <select wire:model='ValentrepriseDelete'>
                                            <option value="">selecter l entreprise</option>
                                            @forelse ($entreprise as $item)
                                            <option value={{ $item->idEntreprise }}
                                                {{ $ValentrepriseDelete == $item->idEntreprise ? 'selected' : '' }}>
                                                {{ $item->nomEntreprise }}</option>
                                            @empty
                                                <option>no One</option>
                                            @endforelse
                                        </select>

                                    </div>
                                </div>
                                @if (isset($secteuractiviter) && count($secteuractiviter)>=1)
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Secteur d'Activiter</h5>
                                            <select wire:model='ValsecteuractiviterDelete'>
                                                <option>selecter d'Activiter</option>
                                                @forelse ($secteuractiviter as $item)
                                                <option value={{ $item->idSecteurActiviter }} {{ $ValsecteuractiviterDelete==$item->idSecteurActiviter?'selected':'' }}>{{ $item->nomSecteurActiviter }}</option>
                                                @empty
                                                    <option>no Secteur</option>
                                                @endforelse
                                            </select>
                                        </div>
                                </div>
                                @elseif ($ValentrepriseDelete!=='' && isset($secteuractiviter) && count($secteuractiviter)<1)
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Secteur d'Activiter</h5>
                                        <div class="section-headline">
                                            <mark>rien secteur pour cette entreprise</mark>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                                    <button type='button' wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                    <button type='button' wire:click='update()' class="button ripple-effect button-sliding-icon">Modifier<i class="icon-feather-check"></i></button>
                                        </center>
                                <br>        </div>
                            </div>
                        </div>
                    </div>
                </div>


                </form>
            </div>
            <!-- Row / End -->

        @elseif(session('opO') == 'delete')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="headline ">
                        <h3><i class="icon-material-outline-supervisor-account"></i> delete offre</h3>
                    </div>
                    <center>
                        <div class="content">
                            <br>
                            confirmer la supprimer d'Offre <mark> {{ $titreDelete }}</mark> :
                            <br><br>
                            <button wire:click='change("all")' type="button"
                                class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                            <button wire:click='delete'
                                class="button ripple-effect button-sliding-icon">supprimer<i
                                    class="icon-feather-check"></i></button>
                            <br><br>
                        </div>
                    </center>
                </div>
            </div>

        @elseif(session('opO') == 'historiquecandidatures')
            <livewire:admin.candidatures :prop1="$offreId" />
        @endif
        <!-- Footer -->
        @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->
