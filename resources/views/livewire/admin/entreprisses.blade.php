<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
        <!-- Dashboard Headline -->
        <div class="dashboard-headline">
            <h3>Manage Entreprise</h3>
        </div>
        @if(session('opE')=='all' || session('opE')=='') 
            <div class=''>
                {{--  <div class="uploadButton margin-top-0">
                    <input class="uploadButton-input" type="file" accept=".csv,.xlsx" id="upload" multiple wire:model='fichier' />
                    <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                    <span class="uploadButton-file-name">{{ $fichier }}ss</span>
                </div>  --}}
                <input type="file" wire:model='fichier' class='col-8 p-0'>
                <a wire:click='import()' class="button ripple-effect button-sliding-icon" align='right'>Importer<i class="icon-feather-download"></i></a>
                <a wire:click='change("ajoute")' class="button ripple-effect button-sliding-icon" align='right'>Ajouter<i class="icon-feather-user-plus"></i></a>
                <a wire:click='exporter()' class="button ripple-effect button-sliding-icon" align='right'>Exporter<i class="icon-feather-upload"></i></a>
            </div>
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="headline d-flex justify-content-between col-12">
                            <h3><i class="icon-material-outline-business"></i> {{ $count }} Entreprise</h3>
                            <div class='d-flex justify-content-between'>
                                <select wire:model='select' class="with-border">
                                    <option value="nomEntreprise">Par Nom</option>
                                    <option value="adresseEntreprise">Par adresse</option>
                                    <option value="emailEntreprise">Par email</option>
                                    <option value="villeEntreprise">Par ville</option>
                                    <option value="secteurActiviter">Par Secteur</option>
                                </select>
                                @if($select!='secteurActiviter' && $select!='villeEntreprise')
                                <input type="text" class="with-border" wire:model.debounce.100ms='search'>
                                @elseif($select=='secteurActiviter')
                                    <select wire:model='searchSecteur' class="with-border">
                                        {!! $searchSecteur==null?'<option value="">choisser le secteur</option>':'' !!}
                                        @foreach ($secteurActiviter as $item)
                                            <option value="{{ $item->idSecteurActiviter }}">{{ $item->nomSecteurActiviter }}</option>
                                        @endforeach
                                    </select>
                                @elseif($select=='villeEntreprise')
                                    <select wire:model='villeEntr' class="with-border">
                                        {!! $villeEntr==null?'<option value="">choisser la ville</option>':'' !!}
                                        @foreach ($villeAll as $item)
                                            <option value="{{ $item->id }}">{{ $item->nomVille }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="content">
                            <ul class="dashboard-box-list">
                                <li>
                                    <!-- Overview -->
                                    @forelse ($Entreprises as $item)
                                    <div class="freelancer-overview manage-candidates">
                                        <div class="freelancer-overview-inner">

                                            <!-- Avatar -->
                                            <div class="freelancer-avatar ia">
                                                <a ><img src={{asset('/storage/'.$item->photo) }} alt="" height='76px' width='76px'></a>
                                            </div>

                                            <!-- Name -->
                                            <div class="freelancer-name">
                                                <h4><a href="#">{{ $item->nomEntreprise}}</a></h4>

                                                <!-- Details -->
                                                <span class="freelancer-detail-item"><a href="#"><i class="icon-feather-mail"></i> <span class="__cf_email__" data-cfemail="81f2e8efe5f8c1e4f9e0ecf1ede4afe2eeec">{{ $item->emailEntreprise }}</span></a></span>
                                                <span class="freelancer-detail-item"><i class="icon-feather-phone"></i> (+212) {{$item->telephone}}</span>
                                                <span class="freelancer-detail-item"><i class="icon-material-outline-language"></i>  {{$item->siteWebEntreprise}}</span>
                                                <br>
                                                <span class="freelancer-detail-item"><i class="icon-material-outline-location-city"></i>  {{$item->villes->nomVille??''}}</span>
                                                <span class="freelancer-detail-item"><i class="icon-material-outline-add-location"></i>  {{$item->adresseEntreprise}}</span>
                                                <span class="freelancer-detail-item fw-bolder"><i class="icon-feather-activity"></i> @forelse ($item->secteurs()->get() as $item1)
                                                    <mark class="color">{{ $item1->nomSecteurActiviter }}</mark>
                                                @empty
                                                    <mark>no secteur</mark>
                                                @endforelse</span>
                                                <!-- Buttons -->
                                                <div class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
                                                    <a wire:click="edit({{$item->idEntreprise}})" class="button gray ripple-effect ico" title="modifier Entreprise" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>

                                                    <a wire:click="change('delete',{{$item->idEntreprise}})" class="button gray ripple-effect ico"  title="supprimer Entreprise" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                             <center class='d-flex justify-content-center col-12'>
                                            <div class="freelancer">
                                                <mark class='color'>No Entreprise</mark>
                                            </div>
                                        </center>
                                    @endforelse
                                </li>
                                {{ $Entreprises->links('livewire.layoutsLivewire.pagination') }}
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        @elseif(session('opE')=='update')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="headline d-flex justify-content-between">
                        <h3><i class="icon-material-outline-supervisor-account"></i> Ajouter  Entreprise</h3>
                    </div>
                    <form wire:submit.prevent='update' method="post" enctype="multipart/form-data">
                        <div class="content content with-padding padding-bottom-10">
                            <div class='row'>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Nom Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='nom' placeholder="Entrez le nom Entreprise">
                                    @error('nom')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Adresse Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='adresse' placeholder="Entrez Adresse Entreprise">
                                    @error('adresse')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>ville Entreprise</h5>
                                    <select wire:model='ville'>
                                        <option value="">choisissez la ville </option>
                                        @foreach ($villeAll as $item)
                                            <option value="{{$item->id}}" {{ $ville==$item->id?'selected':'' }}>{{ $item->nomVille }}</option>
                                        @endforeach
                                    </select>
                                    @error('ville')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>email Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='email' placeholder="Entrez Email Entreprise">
                                    @error('email')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Site Web Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='siteweb' placeholder="Entrez SiteWeb Entreprise">
                                    @error('siteweb')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Telephone Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='telephone' placeholder="Entrez telephone Entreprise">
                                    @error('telephone')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{--  class="profile-pic"
                            class="file-upload"   --}}
                            <div class="col-xl-8 col-md-8">
                                <div class="submit-field">
                                    <h5>Photo Entreprise</h5>
                                <div class="d-flex">
                                    <img src="{{asset('/storage/'.$photo)}}" class='margin-top-10 '  width="30px" height='30px' style="border-radius: 50% !important" wire:ignore>
                                    <input type="file" class="padding-left-0 margin-left-10" wire:model='photo' accept="image/*">
                                </div>
                                    @error('photo')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xl-12 col-md-12">
                                <div class="submit-field">
                                    <h5>secteur activiter <span style="font-size: 10px">(Click sur <kbd>Ctrl</kbd> + <kbd>Click</kbd>)</span></h5>
                                    <select onchange="Livewire.emit('selectChanged', Array.from(event.target.selectedOptions, option => option.value));" style='height: 100px !important;' multiple size="8">
                                        @forelse ($secteurActiviter as $item)
                                        @php
                                                        $isSelected = false;
                                                        foreach ($this->secteur as $secteurItem) {
                                                            if ($secteurItem['idSecteurActiviter'] == $item->idSecteurActiviter) {
                                                                $isSelected = true;
                                                                break;
                                                            }
                                                        }
                                                        @endphp
                                            <option value={{ $item->idSecteurActiviter }} {{$isSelected ? 'selected' : '' }}>{{ $item->nomSecteurActiviter }}</option>
                                        @empty
                                            <option>no One</option>
                                        @endforelse
                                    </select>
                                    @error('secteur')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div align='center' class="centered-button margin-top-15 col-xl-12 col-md-12">
                                <center>
                                    <button wire:click='change("all")' type='button' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                <button type="submit" class="button ripple-effect button-sliding-icon">Modifier<i class="icon-feather-check"></i></button>
                                </center>
                            </div>
                            <div class="col-xl-6 col-md-6 mb-5"></div>
                        </div>

                    </form>
                        </div>

                    <div>

                    </div>
            </div>
        @elseif(session('opE')=='ajoute')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="headline d-flex justify-content-between">
                        <h3><i class="icon-material-outline-supervisor-account"></i> Ajouter  Entreprise</h3>
                    </div>
                    <form wire:submit.prevent='ajouterEntreprise' method="post" enctype="multipart/form-data">
                        <div class="content content with-padding padding-bottom-10">
                            <div class='row'>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Nom Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='nom' placeholder="Entrez le nom Entreprise">
                                    @error('nom')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Adresse Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='adresse' placeholder="Entrez Adresse Entreprise">
                                    @error('adresse')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>ville Entreprise</h5>
                                    <select wire:model='ville'>
                                        <option value="">choisissez la ville </option>
                                        @foreach ($villeAll as $item)
                                            <option value="{{$item->id}}">{{ $item->nomVille }}</option>
                                        @endforeach
                                    </select>
                                    @error('ville')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>email Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='email' placeholder="Entrez Email Entreprise">
                                    @error('email')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Password Entreprise</h5>
                                    <input type="password" class="with-border" wire:model='password' placeholder="Entrez Password Entreprise">
                                    @error('password')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Site Web Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='siteweb' placeholder="Entrez SiteWeb Entreprise">
                                    @error('siteweb')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Telephone Entreprise</h5>
                                    <input type="text" class="with-border" wire:model='telephone' placeholder="Entrez telephone Entreprise">
                                    @error('telephone')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-8 col-md-8">
                                <div class="submit-field">
                                    <h5>Photo Entreprise</h5>
                                    <input type="file" class="padding-left-0" wire:model='photo' >
                                    @error('photo')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12">
                                <div class="submit-field">
                                    <h5>secteur activiter <span style="font-size: 10px">(Click sur <kbd>Ctrl</kbd> + <kbd>Click</kbd> )</span></h5>
                                    <select wire:model='secteur' style='height: 100px !important;' multiple size="8">
                                        @forelse ($secteurActiviter as $item)
                                            <option value={{ $item->idSecteurActiviter }}>{{ $item->nomSecteurActiviter }}</option>
                                        @empty
                                            <option>no One</option>
                                        @endforelse
                                    </select>
                                    @error('secteur')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div align='center' class="centered-button margin-top-15 col-xl-12 col-md-12">
                                <center>
                                    <button wire:click='change("all")' type='button' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                <button type="submit" class="button ripple-effect button-sliding-icon">Ajouter<i class="icon-feather-check"></i></button>
                                </center>
                            </div>
                            <div class="col-xl-6 col-md-6 mb-5"></div>
                        </div>
                        </div>

                    </form>
                        </div>

                    <div>

                    </div>
            </div>
        @elseif(session('opE')=='delete')
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">
                <div class="headline d-flex justify-content-between">
                    <h3><i class="icon-material-outline-business"></i> Supprimer Entreprise</h3>
                </div>
                    <div class="content">
                   <center>
                    Vous avez sur de supprimer Entreprise <mark> {{ $nom }}</mark>  :
                    <br>
                    <button wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon margin-bottom-20 margin-top-20"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                    <button wire:click='delete' class="button ripple-effect button-sliding-icon margin-bottom-20 margin-top-20">supprimer<i class="icon-feather-check"></i></button>
                   </center>

                    </div>
            </div>
        </div>

        @endif
        <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->


    </div>
</div>

<script>
    function selectChanged(event) {
      var selectedValues = Array.from(event.target.selectedOptions, option => option.value);
      Livewire.emit('selectChanged', selectedValues);
    }
    </script>


