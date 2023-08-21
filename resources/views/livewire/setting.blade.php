<div wire:ignore>
    <div class="dashboard-container" style="width: 100% !important;left:0vh">
    <div class="dashboard-content-container" style="left: 0% !important" >
        <div class="dashboard-content-inner" >
            <!-- Dashboard Headline -->
            <div class="dashboard-headline">
                <h3>Settings</h3>

            </div>
            <div>
                @if(session('status'))
                <div class="notification success closeable">
                    <p>{{ session('status') }}</p>
                    <a class="close" href="#"></a>
                </div>
                @endif
            </div>
        <!-- Row -->
            <div class="row">

                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <form action="post" wire:submit.prevent='modifier' enctype="multipart/form-data">
                        <!-- Headline -->
                        <div class="headline d-flex">
                            <h3 class='col-11'><i class="icon-material-outline-account-circle "></i> My Account</h3>
                        </div>

                        <div class="content with-padding padding-bottom-0">

                            <div class="row">

                                <div class="col-auto">
                                    <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Image">
                                        <img class="profile-pic" src="{{asset('/storage/'.$photo) }}" alt="" wire:ignore/>
                                        <div class="upload-button"></div>
                                        <input class="file-upload" type="file" accept="image/*" wire:model='photo'/>
                                    </div>
                                </div>

                                <div class="col-xl">
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{!! $type=='utilisateur'?'Nom Utilisateur':'Nom Entreprise' !!}</h5>
                                                <input type="text" class="with-border" wire:model.defer='nom'>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{!! $type=='utilisateur'?'Prenom Utilisateur':'Site Web Entreprise' !!}</h5>
                                                <input type="text" class="with-border" wire:model.defer={!! $type=='utilisateur'?'prenom':'siteWebEntreprise'!!}>
                                            </div>
                                        </div>

                                        <div class="{{ $type=='utilisateur'?'col-xl-3':'col-xl-6' }}">
                                            <!-- Account Type -->
                                            <div class="submit-field">
                                                <h5>Type Profile</h5>
                                                <div class="account-type">
                                                    <div class="{{ $type=='utilisateur'?'':'d-none' }}">
                                                        <input type="radio" name="account-type-radio" id="freelancer-radio" class="account-type-radio" {{ $type=='utilisateur'?'checked':'' }}/>
                                                        <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Utilisateur</label>
                                                    </div>

                                                    <div class="{{ $type=='entreprise'?'':'d-none' }}">
                                                        <input type="radio" name="account-type-radio" id="employer-radio" class="account-type-radio" {{ $type=='entreprise'?'checked':'' }}/>
                                                        <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Entreprise</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($type=='utilisateur')
                                            <div class="col-xl-3">
                                                <!-- Account Type -->
                                                <div class="submit-field">
                                                    <h5>Role Utilisateur</h5>
                                                    <div class="account-type">
                                                        <div>
                                                            <input type="radio" class="account-type-radio" checked/>
                                                            <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> {{ $nomRole }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-xl-6">
                                            <div class="submit-field" >
                                                <h5>{{ $type=='utilisateur'?'Email Utilisateur':'Email Entreprise' }}</h5>
                                                <input type="text" class="with-border" wire:model.defer='email'>
                                            </div>
                                        </div>
                                        <div class="{{ $type=='utilisateur'?'col-xl-6':'col-xl-12' }}">
                                            <div class="submit-field">
                                                <h5>{{ $type=='utilisateur'?'Telephone Utilisateur':'Telephone Entreprise' }}</h5>
                                                <input type="text" class="with-border" wire:model.defer='telephone'>
                                            </div>
                                        </div>
                                        @if($type=='utilisateur')
                                            <div class="col-xl-6">
                                                <div class="submit-field">
                                                    <h5>Date Naissance Utilisateur</h5>
                                                    <input type="date" class="with-border" wire:model.defer="dateNaissance">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box">

                        <!-- Headline -->
                        <div class="headline">
                            <h3><i class="icon-material-outline-face"></i> My Profile</h3>
                        </div>

                        <div class="content">
                            <ul class="fields-ul">
                            <li>
                                <div class="row">
                                    @if($type=='entreprise')
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Adresse Entreprise </h5>
                                                <input type="text" class="with-border" wire:model.defer='adresse' >
                                            </div>
                                        </div>
                                    @endif
                                    <div class="{{ $type=='utilisateur'?'col-xl-6':'col-xl-6' }}" wire:ignore>
                                        <div class="submit-field">
                                            <h5>{{ $type=='utilisateur'?'Ville Utilisateur':'Ville Entreprise' }}</h5>
                                            @if($type=='utilisateur')
                                                  <select class='selectpicker with-border' title="Select ville" wire:model='ville' >
                                                 
                                                @forelse ($ville1 as $item)
                                                    <option value={{ $item->nomVille }} {{ $ville==$item->nomVille?'selected':'' }}>{{ $item->nomVille }}</option>
                                                @empty
                                                    <option>no ville</option>
                                                @endforelse
                                            </select>
                                            @elseif($type=='entreprise')
                                                  <select class='selectpicker with-border' title="Select ville" wire:model='ville' >
                                                 
                                                @forelse ($ville1 as $item)
                                                    <option value={{ $item->id }} {{ $ville==$item->id?'selected':'' }}>{{ $item->nomVille }}</option>
                                                @empty
                                                    <option>no ville</option>
                                                @endforelse
                                            </select>
                                            @endif
                                        </div>
                                    </div>
                                    @if(Auth::guard('web')->check())
                                        @if(Auth::guard('web')->user()->roles->nomRole=='user')
                                          <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Niveau Etude Utilisateur</h5>
                                                <input type="text" class="with-border" wire:model.defer='niveauEtude' >
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field" data-tippy-placement="bottom" title="sous format des ligne">
                                                <h5>Experiances Utilisateur</h5>
                                                <textarea cols="30" rows="5" class="with-border" wire:model.defer='experiances'></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field" data-tippy-placement="bottom" title="sous format des ligne">
                                                <h5>Competences Utilisateur</h5>
                                                <textarea cols="30" rows="5" class="with-border" wire:model.defer='competences'></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <!-- Attachments -->
                                                <div class="attachments-container margin-top-0 margin-bottom-0 {{$etatDeleteFile==true || $cv==''?'d-none':''}} d-flex flex-column">
                                                <h5>Attachments</h5><br>
                                                    <div class="attachment-box ripple-effect">
                                                        <span>curriculum vitae</span>
                                                        <i>{{ $extension }}</i>
                                                        <button class="remove-attachment" data-tippy-placement="top" type='button' title="supprimer" wire:click='removecv'></button>
                                                        <button class="download-attachment" data-tippy-placement="top" type="button" title="telecharger" wire:click='telechargerCv'></button>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <!-- Upload Button -->
                                               @if ($cv==null && Auth::guard('web')->user()->roles->nomRole!=='admin'  )
                                                    <div class="uploadButton margin-top-0" wire:ignore>
                                                        <input class="uploadButton-input" type="file" accept="image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" id="upload" multiple wire:model.defer='cv' />
                                                        <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                                        <span class="uploadButton-file-name">Maximum file size: 10 MB</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @elseif($type=='entreprise')
                                        <div class="col-xl-6" wire:ignore>
                                            <div class="submit-field" >
                                                <h5>Secteur Activiter Entreprise</h5>
                                                <select class='selectpicker with-border'  onchange="selectChanged(event)" multiple data-live-search="true"  wire:ignore>
                                                    @forelse ($secteur as $key=>$item)
                                                    @php
                                                    $isSelected = false;
                                                    foreach ($secteurEntreprise as $secteurItem) {
                                                        if ($secteurItem['idSecteurActiviter'] == $item->idSecteurActiviter) {
                                                            $isSelected = true;
                                                            break;
                                                        }
                                                    }
                                                    @endphp
                                                    <option value="{{$item->idSecteurActiviter}}" {{ $isSelected ? 'selected' : '' }} >{{$item->nomSecteurActiviter}}</option>

                                                    @empty
                                                        <option>no secteur</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                {{--  <button wire:click='telechargerCv'>telecharger</button>  --}}
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div id="test1" class="dashboard-box">

                        <!-- Headline -->
                        <div class="headline">
                            <h3><i class="icon-material-outline-lock"></i> Mot de passe & Securité</h3>
                        </div>

                        <div class="content with-padding">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Current Mot de passe</h5>
                                        <input type="password" class="with-border" wire:model.lazy='password'>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>New Password</h5>
                                        <input type="password" class="with-border" wire:model.defer='passwordNew'>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Repeat New Password</h5>
                                        <input type="password" class="with-border" wire:model.defer='passwordNew_confirmation'>
                                    </div>
                                    @error('passwordNew')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-xl-6 text-danger">
                                    <center>
                                        @if($erourePassword==true)
                                            Le mot de passe actuel est incorrect.
                                        @endif
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button -->
               <center>
                <div class="col-xl-12 ">
                    <button type="submit" class="button ripple-effect big margin-top-30">Sauvegarder</button>
                </div>
               </center>
            </form>

            </div>
            <!-- Row / End -->

            <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
            <!-- Footer / End -->

        </div>
    </div>

</div>
</div>


<script>
function selectChanged(event) {
  var selectedValues = Array.from(event.target.selectedOptions, option => option.value);
  Livewire.emit('selectChanged', selectedValues);
}
</script>
