<div>
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </div>
    @if(session('registerForm')==true)
        <div class="container">

        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success" style='width: {!! ($step == 1) ? "10%" : (($step == 2) ? "50%" : "100%") !!}' >{{ ($step == 1) ? "0%" : (($step == 2) ? "50%" : "100%") }}</div>
        </div>
        </div>
    @endif

    @if(session('registerForm')==false)

        <div class="container">
            <div class="row">
                <div class="col-xl-5 offset-xl-3">
                    <div class="login-register-page">
                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h3>Nous sommes heureux de vous revoir!!!</h3>
                            <span>Vous n’avez pas de compte ? <a href="#" wire:click='register'>Sign Up!</a></span>
                        </div>

                        <!-- Form -->
                        <form method="post" wire:submit.prevent='login' id="register-account-form">


                            <div class="input-with-icon-left">
                                <i class="icon-material-baseline-mail-outline"></i>
                                <input type="text" class="input-text with-border" wire:model.defer="email" id="emailaddress-register" placeholder="Email Address"  value="{{ old('email') }}"/>
                                @error('email')
                                    <span>
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>

                            <div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
                                <i class="icon-material-outline-lock"></i>
                                <input type="password" class="input-text with-border" wire:model.defer="password" placeholder="Password" value="{{ old('password') }}" />
                                @error('password')
                                    <span>
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>

                        <!-- Button -->
                            <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type='submit'>login <i class="icon-material-outline-arrow-right-alt"></i></button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    @else
        <div class="container margin-top-30">
            <div class="row">
                <div class="col-xl-5 offset-xl-3">

                    <div class="login-register-page">
                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h3 style="font-size: 26px;">
                                Créons votre compte !!</h3>
                            <span>Vous avez déjà un compte? <a wire:click='register' href='#'>Log In!</a></span>
                        </div>

                        <!-- Account Type -->
                        <div class="account-type">
                            <div class="{!! $step!=1&&$type=='entreprise'?'d-none':'' !!}">
                                <input type="radio" name="account-type-radio" id="freelancer-radio" class="account-type-radio" wire:model='type' value='utilisateur' {{ $type=='utilisateur'?'checked':''}} />
                                <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Utilisateur</label>
                            </div>

                            <div class="{!! $step!=1&&$type=='utilisateur'?'d-none':'' !!}">
                                <input type="radio" name="account-type-radio" id="employer-radio" class="account-type-radio" value='entreprise' wire:model='type' {{ $type=='entreprise'?'checked':'' }}/>
                                <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Entreprise</label>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="post" wire:submit.prevent='registerCreate' id="register-account-form" enctype="multipart/form-data">
                            @csrf
                            @if($type=='utilisateur')
                                @if($step==1)
                                    <div class="input-with-icon-left">
                                        <i class="icon-material-baseline-mail-outline"></i>
                                        <input type="text" class="input-text with-border" wire:model="email"  placeholder="Email"/>
                                        @error('email')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
                                        <i class="icon-material-outline-lock"></i>
                                        <input type="password" class="input-text with-border" wire:model="password"  placeholder="Password"/>
                                    </div>
                                    <div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
                                        <i class="icon-material-outline-lock"></i>
                                        <input type="password" class="input-text with-border" wire:model="password_confirmation"  placeholder="Password Confirmation" />
                                        @error('password')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                @elseif($step==2)
                                    <div class="input-with-icon-left">
                                        <i class="icon-feather-user"></i>
                                        <input type="text" class="input-text with-border" wire:model="nom" placeholder="nom utilisateur"/>
                                        @error('nom')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-with-icon-left">
                                        <i class="icon-feather-user"></i>
                                        <input type="text" class="input-text with-border" wire:model="prenom"  placeholder="Prenom utilisateur"  />
                                        @error('prenom')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-with-icon-left">
                                        <i class="icon-feather-phone"></i>
                                        <input type="text" class="input-text with-border" wire:model="telephone"  placeholder="+2126666666" title='debut par +212'  />
                                        @error('telephone')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-with-icon-left">
                                        <i class="icon-material-outline-date-range"></i>
                                        <input type="date" class="input-text with-border" wire:model="dateNaissance"  placeholder="dateNaissance utilisateur"  />
                                        @error('dateNaissance')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div >

                                        <input type="file" class="input-text with-border form-control h-25" wire:model="photo"  placeholder="photo utilisateur"  />
                                        @error('photo')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    <select wire:model.defer='ville' title="choisissez votre ville">
                                    <option value=''>Choissisez Votre Ville</option>
                                    @forelse ($villeC as $item)
                                        <option value={{ $item->nomVille }}>{{ $item->nomVille }}</option>
                                    @empty
                                        <option>no ville</option>
                                    @endforelse
                                    </select>
                                    @error('ville')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                    @enderror
                                    </div>
                                @elseif($step==3)
                                    <div class="">
                                        <textarea cols="30" rows="5" class="with-border" wire:model='experiances' placeholder="Écrire votre expériences sous format des tiré
                                        "></textarea>

                                        @error('experiances')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div >
                                        <textarea cols="30" rows="5" class="with-border" wire:model='competences' placeholder="Écrire votre competences sous format des tiré
                                        " wire:model="competences"></textarea>
                                        @error('competences')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div >
                                        <select wire:model='niveauEtude'>
                                            <option>choisir le niveau  d'etude</option>
                                            <option value="Bac" {{ $niveauEtude=='Bac'?'selected':'' }}>Bac</option>
                                            <option value="Bac+1" {{ $niveauEtude=='Bac+1'?'selected':'' }}>Bac+1</option>
                                            <option value="Bac+2" {{ $niveauEtude=='Bac+2'?'selected':'' }}>Bac+2</option>
                                            <option value="Bac+3" {{ $niveauEtude=='Bac+3'?'selected':'' }}>Bac+3</option>
                                            <option value="Bac+4" {{ $niveauEtude=='Bac+4'?'selected':'' }}>Bac+4</option>
                                            <option value="Bac+5" {{ $niveauEtude=='Bac+5'?'selected':'' }}>Bac+5</option>
                                            <option value="Plus de Bac+5" {{ $niveauEtude=='Plus de Bac+5'?'selected':'' }}>Plus de Bac+5</option>
                                            <option value="Niveau Bac" {{ $niveauEtude=='Niveau Bac'?'selected':'' }}>Niveau Bac</option>
                                            <option value="CQP"  {{ $niveauEtude=='CQP'?'selected':'' }}>CQP</option>
                                        </select>
                                        @error('niveauEtude')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                        <input type="file" class="input-text with-border form-control h-25" wire:model="cv" title='uploader votre CV' placeholder='uploader votre CV'/>
                                        @error('cv')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                @endif
                            @elseif($type=='entreprise')
                                @if($step==1)
                                    <div class="input-with-icon-left" >
                                        <i class="icon-material-baseline-mail-outline"></i>
                                        <input type="text" class="input-text with-border" wire:model="emailentreprise"  placeholder="Email"  />
                                        @error('emailentreprise')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-with-icon-left" title="le mode de passe doit etre superieure a 8 charactere" data-tippy-placement="bottom">
                                        <i class="icon-material-outline-lock"></i>
                                        <input type="password" class="input-text with-border" wire:model="passwordentreprise" placeholder="Password"  />
                                        @error('passwordentreprise')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-with-icon-left" title="confirmer ton password" data-tippy-placement="bottom">
                                        <i class="icon-material-outline-lock"></i>
                                        <input type="password" class="input-text with-border" wire:model="passwordentreprise_confirmation"  placeholder="Password Confirmation"  />
                                        @error('passwordentreprise_confirmation')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                @elseif($step==2)
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" wire:model="nomentreprise"  placeholder="Entrez le nom Entreprise"/>
                                    @error('nomentreprise')
                                        <span class='text-danger'>
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-with-icon-left">
                                    <i class="icon-material-outline-language"></i>
                                    <input type="text" class="input-text with-border" wire:model="sitewebEntreprise"  placeholder="Entrez le nom site d'entreprise"/>
                                    @error('sitewebEntreprise')
                                        <span class='text-danger'>
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                                    
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-phone"></i>
                                    <input type="text" class="input-text with-border" wire:model="telephoneEntreprise"  placeholder="+212666666"/>
                                    @error('telephoneEntreprise')
                                        <span class='text-danger'>
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-with-icon-left">
                                    <i class="icon-material-outline-add-location"></i>
                                    <input type="text" class="input-text with-border" wire:model="adresseEntreprise"  placeholder="Entrez adresse  Entreprise"/>
                                    @error('adresseEntreprise')
                                        <span class='text-danger'>
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                               <div>
                                    <select wire:model='villeEntreprise' title="choisissez votre ville">
                                        <option value="">Choissisez Votre Ville</option>
                                        @forelse ($villeC as $item)
                                            <option value={{ $item->id }}>{{ $item->nomVille }}</option>
                                        @empty
                                            <option>no ville</option>
                                        @endforelse
                                    </select>
                                    @error('villeEntreprise')
                                            <span class='text-danger'>
                                                {{$message}}
                                            </span>
                                    @enderror
                               </div>
                               <input type="file" class="input-text with-border form-control h-25" wire:model="photoEntreprise"  placeholder="Photo Entreprise" title="Photo d'entreprise" />
                                    @error('photoEntreprise')
                                        <span class='text-danger'>
                                            {{$message}}
                                        </span>
                                    @enderror
                                @elseif($step==3)
                                    <div>
                                        <h3 class="margin-bottom-10">secteur activiter<span style="font-size: 10px">(Click sur <kbd>Ctrl</kbd> + <kbd>Click</kbd>)</span></h3>
                                        <select wire:model='secteurEntreprise' style='height: 100px !important;' multiple size="8" title="choisissez votre secteur">
                                            @forelse ($secteurActiviter as $item)
                                                <option value={{ $item->idSecteurActiviter }}>{{ $item->nomSecteurActiviter }}</option>
                                            @empty
                                                <option>no Secteur</option>
                                            @endforelse
                                        </select>
                                        @error('secteurEntreprise')
                                                <span class='text-danger'>
                                                    {{$message}}
                                                </span>
                                        @enderror
                                    </div>
                                @endif



                                {{--  <div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
                                    <i class="icon-material-outline-lock"></i>
                                    <input type="password" class="input-text with-border" wire:model="password_confirmation"  placeholder="Password"  />
                                    @error('password_confirmation')
                                        <span class='text-danger'>
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>  --}}
                            @endif



                        <!-- Button -->
                        {{--  <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" >Register <i class="icon-material-outline-arrow-right-alt"></i></button>  --}}

                        <div class='d-flex justify-content-around'>
                            <button type='button' wire:click='previousStep' class="button ripple-effect button-sliding-icon {{ $step==1?'d-none':'' }} margin-bottom-40" style='cursor:{!! $step==1?"not-allowed":"" !!}'><i class="icon-line-awesome-angle-left"></i>previous</button>
                            @if($step==3)
                            <button type='submit' class="button dark ripple-effect button-sliding-icon margin-bottom-40" >submit<i class="icon-feather-check"></i></button>
                            {{--  <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" >Register <i class="icon-material-outline-arrow-right-alt"></i></button>  --}}
                            @else
                            <a wire:click='nextStep' class="button dark ripple-effect button-sliding-icon margin-bottom-40" style='cursor:{!! $step==3?"not-allowed":"" !!}'>Suivant<i class="icon-line-awesome-angle-right"></i></a>
                            @endif
                        </div>
                        </form>
                        
                    </div>

                </div>
            </div>
        </div>

    @endif
</div>
