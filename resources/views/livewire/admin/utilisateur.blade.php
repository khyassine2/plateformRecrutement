<div class="dashboard-content-container" >
    <div class="dashboard-content-inner" >
        <!-- Dashboard Headline -->
        <div class="dashboard-headline">
            <h3>Manage Utilisateur</h3>
            <!-- Breadcrumbs -->
        </div>
        @if(session('opU')=='' || session('opU')=="all")
            <div >
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
                            <h3><i class="icon-material-outline-supervisor-account"></i> {{ $count }} Utilisateur</h3>
                            <div class='d-flex justify-content-between'>
                                <select wire:model='select' class="with-border">
                                    <option value="nomUtilisateur">Par Nom</option>
                                    <option value="prenomUtilisateur">Par Prenom</option>
                                    <option value="email">Par email</option>
                                    <option value="Role_id">Par role</option>
                                </select>
                                @if($select!='Role_id')
                                <input type="text" class="with-border" wire:model.debounce.100ms='search'>
                                @else
                                    <select wire:model='searchRole' class="with-border">
                                        <option value="">choisser le role</option>
                                        @foreach ($role as $item)
                                            <option value="{{ $item->idRole }}">{{ $item->nomRole }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>




                        </div>

                        <div class="content">
                            <ul class="dashboard-box-list">
                                <li>
                                    <!-- Overview -->
                                    @forelse ($utilisateur as $item)
                                    <div class="freelancer-overview manage-candidates">
                                        <div class="freelancer-overview-inner">

                                            <!-- Avatar -->
                                            <div class="freelancer-avatar ia">
                                                <a href="#"><img src={{asset('/storage/'.$item->photo) }} alt="" height='76px' width='76px'></a>
                                            </div>

                                            <!-- Name -->
                                            <div class="freelancer-name">
                                                <h4><a href="#">{{ $item->nomUtilisateur.' '.$item->prenomUtilisateur }}</a></h4>

                                                <!-- Details -->
                                                <span class="freelancer-detail-item"><a href="#"><i class="icon-feather-mail"></i> <span class="__cf_email__" data-cfemail="81f2e8efe5f8c1e4f9e0ecf1ede4afe2eeec">{{ $item->email }}</span></a></span>
                                                <span class="freelancer-detail-item"><i class="icon-feather-phone"></i> (+212) {{$item->telephone}}</span>
                                                <span class="freelancer-detail-item fw-bolder"> {!! isset($item->roles()->first()->nomRole)?$item->roles()->first()->nomRole:'<mark>no role</mark>' !!}</span>

                                                {{--  <!-- Rating -->
                                                <div class="freelancer-rating">
                                                    <div class="star-rating" data-rating="5.0"></div>
                                                </div>  --}}
                                                {{--  {{ dd($utilisateur) }}  --}}
                                                <!-- Buttons -->
                                                <div class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
                                                    @if($item->roles->nomRole=='user')
                                                        <a wire:click="downloadFile({{ $item->idUtilisateur}})" class="button ripple-effect"><i class="icon-feather-file-text"></i>Telecharger CV</a>
                                                    @endif


                                                    <a wire:click="edit({{$item->idUtilisateur}})" class="button gray ripple-effect ico" title="modifier Utilisateur" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>

                                                    <a wire:click="change('delete',{{$item->idUtilisateur}})" class="button gray ripple-effect ico"  title="supprimer Utilisateur" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                        <center class='d-flex justify-content-center col-12'>
                                            <div class="freelancer">
                                                <mark class='color'>No Utilisateur</mark>
                                            </div>
                                        </center>
                                    @endforelse
                                </li>
                                {{ $utilisateur->links('livewire.layoutsLivewire.pagination') }}
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        @elseif(session('opU')=='edit')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="headline d-flex justify-content-between">
                        <h3><i class="icon-material-outline-supervisor-account"></i> modification  utilisateur</h3>
                    </div>
                        <div class="row padding-left-10 padding-top-30 padding-right-30">
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Nom</h5>
                                    <input type="text" class="input-text" placeholder="Entrez le nom"  wire:model='nom'>
                                    @error('nom')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Prenom</h5>
                                    <input type="text" placeholder="Entrez le prenom" class="input-text" wire:model='prenom'>
                                    @error('prenom')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Email</h5>
                                    <input type="text" class="input-text" wire:model='email' placeholder="Entrez email">
                                    @error('email')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Telephone</h5>
                                    <input type="text" class="input-text" wire:model='telephone' placeholder="Entrez telephone">
                                    @error('telephone')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Date naissance</h5>
                                    <input type="date" class="input-text" wire:model='dateNaissance'>
                                    @error('dateNaissance')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="submit-field">
                                    <h5>Role</h5>
                                <select wire:model='Valrole'>
                                    <option>Selecter le role</option>
                                    @forelse ($role as $item)
                                        <option value={{ $item->idRole }} {{ $Valrole==$item->nomRole?selected:'' }}>{{ $item->nomRole }}</option>
                                    @empty
                                        <option>no role</option>
                                    @endforelse
                                </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="submit-field">
                                    <h5>Photo</h5>
                                <input class="padding-left-0" type="file" placeholder="Placeholder" wire:model='photo'>
                                @error('photo')
                                    <span class='text-danger'>{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                        <center>
                            <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4">
                                <button wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                <button wire:click='update' class="button ripple-effect button-sliding-icon">modifier<i class="icon-feather-check"></i></button>
                            </div>
                        </center>


                            <div class="col-xl-6 col-md-6 mb-5"></div>
                            <div class="col-xl-6 col-md-6 mb-5"></div>


                        </div>
                        </div>

                    <div>

                    </div>
            </div>
        @elseif(session('opU')=='ajoute')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="headline d-flex justify-content-between">
                        <h3><i class="icon-material-outline-supervisor-account"></i> Ajouter  utilisateur</h3>
                    </div>
                    <form wire:submit.prevent='ajouterUtilisateur' method="post" enctype="multipart/form-data">
                        <div class="row padding-left-30 padding-top-30 padding-right-30">
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Nom</h5>
                                    <input type="text" class="input-text" placeholder="Entrez le nom"  wire:model='nom'>
                                    @error('nom')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Prenom</h5>
                                    <input type="text" placeholder="Entrez le prenom" class="input-text" wire:model='prenom'>
                                    @error('prenom')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Email</h5>
                                    <input type="text" class="input-text" wire:model='email' placeholder="Entrez email">
                                    @error('email')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Password</h5>
                                    <input type="password" class="input-text" wire:model='password' placeholder="Entrez password">
                                    @error('password')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Telephone</h5>
                                    <input type="text" class="input-text" wire:model='telephone' placeholder="Entrez telephone">
                                    @error('telephone')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="submit-field">
                                    <h5>Date naissance</h5>
                                    <input type="date" class="input-text" wire:model='dateNaissance'>
                                    @error('dateNaissance')
                                    <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="submit-field">
                                    <h5>Role</h5>
                                <select wire:model='Valrole'>
                                    <option>Selecter le role</option>
                                    @forelse ($role as $item)
                                        <option value={{ $item->idRole }}>{{ $item->nomRole }}</option>
                                    @empty
                                        <option>no role</option>
                                    @endforelse
                                </select>
                                </div>
                            </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="submit-field">
                                        <h5>Photo</h5>
                                    <input class="padding-left-0" style='' type="file" placeholder="Placeholder" wire:model='photo'>
                                    @error('photo')
                                        <span class='text-danger'>{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                        </div>
                        <center>
                                <div  class="centered-button margin-top-35 col-xl-4 col-md-4">
                                    <button type='button' wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                    <button type="submit" class="button  ripple-effect button-sliding-icon">Ajouter<i class="icon-feather-check"></i></button>
                                </div>
                        </center>
                            <div class="col-xl-4 col-md-4 mb-5"></div>
                            <div class="col-xl-4 col-md-4 mb-5"></div>
                        </div>
                    </form>
                        </div>
                    <div>
                    </div>
            </div>
        @elseif(session('opU')=='delete')
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">
                <div class="headline d-flex justify-content-between">
                    <h3><i class="icon-material-outline-supervisor-account"></i> Suprimer  utilisateur</h3>
                </div>
                    <center><div class="content margin-top-15">
                        Vous avez sur de supprimer utilisateur <mark> {{ $nom }}</mark>  :<br>
                            <button type='button' wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                            <button wire:click='delete' class="button ripple-effect button-sliding-icon">supprimer<i class="icon-feather-check"></i></button>

                        </div></center>
            </div>
        </div>
        @endif
        <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->


    </div>
</div>


