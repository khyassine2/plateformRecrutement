<div class="dashboard-content-container padding-left-20" style='overflow-x: hidden !important' >
    <div class="dashboard-content-inner" >
        <div class="dashboard-headline">
            <h3>Gerer les demandes</h3>
        </div>
        @if(session('opDu')=='all' || session('opDu')=='')
            <a wire:click='change("ajouter")' class="button ripple-effect button-sliding-icon text-muted" align='right'>Ajouter une Demande<i class="icon-feather-edit"></i></a>
            <div class="row">
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-material-outline-business-center"></i> Demande </h3>
                    </div>

                    <div class="content">
                        <ul class="dashboard-box-list">
                            @forelse ($demandeStage as $key=>$item)
                            <li>
                                <!-- Job Listing -->
                                <div class="job-listing">

                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">

                                        </a>

                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">{{ $item->titreDemande }} <span class="dashboard-status-button {{ $item->status!=='en attente'?'green':'yellow' }}">{{ $item->status }}</span></h3>

                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li><i class="icon-material-outline-date-range"></i> Publie le {{ $date[$key] }}</li>
                                                    <li><i class="icon-feather-activity"></i> {!! isset($item->secteurActiviter) && $item->secteurActiviter->nomSecteurActiviter ? $item->secteurActiviter->nomSecteurActiviter : "<span class='text-danger'>no TypeFormation</span>" !!}</li>
                                                    <li><i class="icon-material-outline-settings"></i> {{ $item->typeDemande }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="buttons-to-right always-visible">
                                    <button type='button' wire:click="change('details',{{ $item->idDemande }})" class="button ripple-effect"><i class="icon-feather-eye"></i>Details Demande</button>
                                    <button type="button" wire:click="change('edit',{{ $item->idDemande }})" class="button ripple-effect ico" title="Modifier Demande" data-tippy-placement="top"><i class="icon-feather-edit"></i></button>
                                    <button type="button" wire:click="change('delete',{{ $item->idDemande }})" class="button ripple-effect ico" title="Supprimer Demande" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></button>
                                </div>
                            </li>
                            @empty
                            <center class='d-flex justify-content-center col-12'>
                                            <div class="freelancer">
                                                <mark class='color'>No demande actuellement</mark>
                                            </div>
                            </center>
                                @endforelse


                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @elseif(session('opDu')=='details')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-material-outline-business-center"></i>Details Demande </h3>
                    </div>
                        <div class="content with-padding padding-bottom-10">
                            <div class="row">
                                    <div class="col-xl-12">
                                            <div >
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Titre demande</h5>
                                                            <textarea cols="1" rows="1" class="with-border" wire:model='titreDemande' disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Niveau d'études</h5>
                                                            <input type="text" class="with-border" wire:model="niveauEtude" disabled>
                                                        </div>
                                                    </div>
                                                    @if($typeDemande==="stage")
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Type Demande</h5>
                                                            <input type="text" class="with-border" wire:model='typeStage' disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Duree Stage</h5>
                                                            <input type="text" class="with-border" wire:model='dureeStage' disabled>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Date Publie Demande</h5>
                                                            <input type="date" class="with-border" wire:model='datePublie' disabled>
                                                        </div>
                                                    </div>

                                                    @if($typeDemande=='stage')
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Date Debut Stage</h5>
                                                            <input type="date" class="with-border" wire:model='DateDebutStage' disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Date Fin Stage</h5>
                                                            <input type="date" class="with-border" wire:model='DateFinStage' disabled>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Ville demande</h5>
                                                            <input type="text" class="with-border" wire:model='ville' disabled>
                                                        </div>
                                                    </div>
                                                    @if($typeDemande=='stage')
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Status Demande</h5>
                                                            <input type="text" class="with-border" wire:model='status' disabled>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Type Formation</h5>
                                                            <input type="text" class="with-border" wire:model='typeFormation' disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Type Demande</h5>
                                                            <input type="text" class="with-border" wire:model='typeDemande' disabled>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <div align='center' class="centered-button margin-top-35 col-xl-8 col-md-8 margin-left-100">
                                                <center><button wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button></center>
                                                </div>
                                    </div>
                                </div>

                        </div>

                    </div>
            </div>
        @elseif(session('opDu')=='delete')
            <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">
                <div class="headline d-flex justify-content-between">
                    <h3><i class="icon-material-outline-supervisor-account"></i> supprimer Demande</h3>
                </div>
                    <center>
                        <div class="content">
                            Vous avez sur de supprimer la demande <br>de {{ $typeDemande }}
                             <mark> {{ $titreDemande }} </mark>  :<br>
                                <button wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon margin-top-10 margin-bottom-10"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                <button wire:click='deleteDemande' class="button ripple-effect button-sliding-icon margin-top-10 margin-bottom-10">supprimer<i class="icon-feather-check"></i></button>

                            </div>
                    </center>
            </div>
            </div>
        @elseif(session('opDu')=='ajouter')
            <div class="col-xl-12 ">
                <div class="dashboard-box margin-top-0">
                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-material-outline-business-center"></i>Ajouter une Demande </h3>
                    </div>
                    <form wire:submit.prevent='ajouterDemande' method='POST'>
                        @csrf
                        <div class="padding-top-20 padding-left-20 with-padding padding-bottom-10">
                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Titre Demande</h5>
                                                            <textarea  cols="1" rows="1" class="with-border" wire:model.defer='titreDemande' placeholder="Ecrire le Titre de demande"></textarea>
                                                            @error('titreDemande')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Type demande</h5>
                                                            <select wire:model='typeDemande'>
                                                                {!! $typeDemande==''?"<option>choisir le type de demande</option>":"" !!}
                                                                <option value="stage">Stage</option>
                                                                <option value="emploi">Emploi</option>
                                                            </select>
                                                            @error('typeDemande')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    @if($typeDemande=='stage')
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <h5>Niveau d'étude</h5>
                                                                <select wire:model='niveauEtude'>
                                                                    {!! $niveauEtude==''?"<option>choisir le niveau  d'etude</option>":"" !!}
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
                                                                @error('niveaEtude')
                                                                    <span class="text-danger">
                                                                        {{ $message }}
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <h5>Type Stage</h5>
                                                                <select wire:model='typeStage'>
                                                                    {!! $typeStage==''?"<option>choisir le type de stage</option>":"" !!}
                                                                    <option value="à distance">à distance</option>
                                                                    <option value="Stage d'observation">Stage d'observation</option>
                                                                    <option value="Stage de fin d'etudes">Stage de fin d'etudes</option>
                                                                    <option value="Stage en alternance">Stage en alternance</option>
                                                                    <option value="Stage fonctionnel">Stage fonctionnel</option>
                                                                "</select>
                                                                @error('typeStage')
                                                                    <span class="text-danger">
                                                                        {{ $message }}
                                                                    </span>
                                                                @enderror
                                                                {{--  "  --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <h5>Duree Stage</h5>
                                                                <select wire:model="dureeStage">
                                                                    {!! $dureeStage==''?"<option>choisir la duree de stage</option>":"" !!}
                                                                    <option value="1 mois">1 mois</option>
                                                                    <option value="2 mois">2 mois</option>
                                                                    <option value="3 mois">3 mois</option>
                                                                    <option value="4 mois">4 mois</option>
                                                                    <option value="5 mois">5 mois</option>
                                                                    <option value="6 mois">6 mois</option>
                                                                    <option value="Plus de 6 mois">Plus de 6 mois</option>
                                                                </select>
                                                                @error('dureeStage')
                                                                    <span class="text-danger">
                                                                        {{ $message }}
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <h5>Date Debut Stage</h5>
                                                                <input type="date" class="with-border" wire:model='DateDebutStage' >
                                                                @error('DateDebutStage')
                                                                    <span class="text-danger">
                                                                        {{ $message }}
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <h5>Date Fin Stage</h5>
                                                                <input type="date" class="with-border" wire:model='DateFinStage' >
                                                            @error('DateFinStage')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                            @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <h5>Ville Stage</h5>
                                                                <select wire:model='ville'>
                                                                    {!! $ville==''?"<option>choisir la ville de Stage</option>":"" !!}
                                                                    @forelse ($villeO as $item)
                                                                        <option value="{{ $item->id }}">{{$item->nomVille}}</option>
                                                                    @empty
                                                                        <option>No Ville</option>
                                                                    @endforelse
                                                                </select>
                                                                @error('ville')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <h5>Type Formation</h5>
                                                                <select wire:model='typeFormation'>
                                                                    {!! $typeFormation==''?"<option>choisir le type de formation</option>":"" !!}
                                                                    @forelse ($typeFormationO as $item)
                                                                        <option value="{{ $item->idSecteurActiviter }}">{{$item->nomSecteurActiviter}}</option>
                                                                    @empty
                                                                        <option>No Type Formation</option>
                                                                    @endforelse
                                                                </select>
                                                                @error('typeFormation')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @elseif($typeDemande=='emploi')
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Niveau d'étude</h5>
                                                            <select wire:model='niveauEtude'>
                                                                {!! $niveauEtude==''?"<option>choisir le niveau  d'etude</option>":"" !!}
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
                                                            @error('niveaEtude')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Ville Emploi</h5>
                                                            <select wire:model='ville'>
                                                                {!! $ville==''?"<option>choisir la ville de Stage</option>":"" !!}
                                                                @forelse ($villeO as $item)
                                                                    <option value="{{ $item->id }}">{{$item->nomVille}}</option>
                                                                @empty
                                                                    <option>No Ville</option>
                                                                @endforelse
                                                            </select>
                                                            @error('ville')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Type Formation</h5>
                                                            <select wire:model='typeFormation'>
                                                                {!! $typeFormation==''?"<option>choisir le type de formation</option>":"" !!}
                                                                @forelse ($typeFormationO as $item)
                                                                    <option value="{{ $item->idSecteurActiviter }}">{{$item->nomSecteurActiviter}}</option>
                                                                @empty
                                                                    <option>No Type Formation</option>
                                                                @endforelse
                                                            </select>
                                                            @error('typeFormation')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    @endif
                                                    {{--  j'ai fait ce test pour afficher le message d'eroure quand la dateFin et n'est pas null  --}}
                                                    @if($DateFinStage!=='')
                                                    @error('erour1')
                                                            <strong><span class="text-danger">
                                                                {{ $message }}
                                                            </span></strong>
                                                    @enderror
                                                    @endif
                                                    <div class="centered-button margin-top-35 col-xl-12 col-md-12">
                                                        <center>
                                                            <button type='button' wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                                            {{--  j'ai tester pour afficher la button quand il y'a pas d'eroure  --}}
                                                            @if($erour1==false)
                                                            <button type='submit' class="button ripple-effect button-sliding-icon">Ajouter<i class="icon-feather-check"></i></button>
                                                            @endif


                                                        </center>
                                                    </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
        @elseif(session('opDu')=='edit')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-material-outline-business-center"></i>Modifier une Demande Stage </h3>
                    </div>
                    <form wire:submit.prevent='modifierDemande' method='POST'>
                        <div class="content with-padding padding-bottom-10">
                            <div class="row">
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Titre Stage</h5>
                                                            <textarea cols="30" rows="5" class="with-border" wire:model='titreDemande' placeholder="Ecrire le Titre de demande de stage"></textarea>
                                                            @error('titreDemande')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Type demande</h5>
                                                            <select wire:model='typeDemande'>
                                                                <option value="stage"  {{$typeDemande=='stage'?'selected':''}}>Stage</option>
                                                                <option value="emploi" {{$typeDemande=='emploi'?'selected':''}}>Emploi</option>
                                                            </select>
                                                            @error('typeDemande')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Niveau d'étude</h5>
                                                            <select wire:model='niveauEtude'>
                                                                {!! $niveauEtude==null?"<option>choisir le niveau  d'etude</option>":"" !!}
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
                                                            @error('niveaEtude')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    @if($typeDemande=='stage')
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Type Stage</h5>
                                                            <select wire:model='typeStage'>
                                                                {!! $typeStage==null?"<option value=''>choissisez votre type de stage</option>":'' !!}
                                                                <option value="à distance" {{ $typeStage=='à distance'?'selected':'' }}>à distance</option>

                                                                <option value="Stage d'observation" {{ $typeStage=="Stage d'observation"?'selected':'' }}>Stage d'observation</option>

                                                                <option value="Stage de fin d'etudes" {{ $typeStage==="Stage de fin d'etudes"?'selected':'' }} >Stage de fin d'etudes</option>

                                                                <option value="Stage en alternance" {{ $typeStage=="Stage en alternance"?'selected':'' }}>Stage en alternance</option>
                                                                <option value="Stage fonctionnel">Stage fonctionnel</option>
                                                            "</select>
                                                            @error('typeStage')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Duree Stage</h5>
                                                            <select wire:model="dureeStage">
                                                                {!! $dureeStage==''?"<option>choisir la duree de stage</option>":"" !!}
                                                                <option value="1 mois" {{ $dureeStage=="1 mois"?'selected':'' }}>1 mois</option>
                                                                <option value="2 mois" {{ $dureeStage=="2 mois"?'selected':'' }}>2 mois</option>
                                                                <option value="3 mois" {{ $dureeStage=="3 mois"?'selected':'' }}>3 mois</option>
                                                                <option value="4 mois" {{ $dureeStage=="4 mois"?'selected':'' }}>4 mois</option>
                                                                <option value="5 mois" {{ $dureeStage=="5 mois"?'selected':'' }}>5 mois</option>
                                                                <option value="6 mois" {{ $dureeStage=="6 mois"?'selected':'' }}>6 mois</option>
                                                                <option value="Plus de 6 mois" {{ $dureeStage=="Plus de 6 mois"?'selected':'' }}>Plus de 6 mois</option>
                                                            </select>
                                                            @error('dureeStage')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Date Debut Stage</h5>
                                                            <input type="date" class="with-border" wire:model='DateDebutStage' >
                                                            @error('DateDebutStage')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Date Fin Stage</h5>
                                                            <input type="date" class="with-border" wire:model='DateFinStage' >
                                                        @error('DateFinStage')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                        @enderror
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Ville Demande</h5>
                                                            <select wire:model='ville'>
                                                                {!! $ville==''?"<option>choisir la ville de Stage</option>":"" !!}
                                                                @forelse ($villeO as $item)
                                                                    <option value="{{ $item->id }}">{{$item->nomVille}}</option>
                                                                @empty
                                                                    <option>No Ville</option>
                                                                @endforelse
                                                            </select>
                                                            @error('ville')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Type Formation</h5>
                                                            <select wire:model='typeFormation'>
                                                                {!! $typeFormation==''?"<option>choisir le type de formation</option>":"" !!}
                                                                @forelse ($typeFormationO as $item)
                                                                    <option value="{{ $item->idSecteurActiviter }}">{{$item->nomSecteurActiviter}}</option>
                                                                @empty
                                                                    <option>No Type Formation</option>
                                                                @endforelse
                                                            </select>
                                                            @error('typeFormation')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{--  j'ai fait ce test pour afficher le message d'eroure quand la dateFin et n'est pas null  --}}
                                                    @if($DateFinStage!=='')
                                                    @error('erour1')
                                                            <strong><span class="text-danger">
                                                                {{ $message }}
                                                            </span></strong>
                                                    @enderror
                                                    @endif
                                                    <div class="centered-button margin-top-35 col-xl-12 col-md-12">
                                                        <center>
                                                            <button type='button' wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                                            {{--  j'ai tester pour afficher la button quand il y'a pas d'eroure  --}}
                                                            @if(!$errors->any())
                                                            <button type='submit' class="button ripple-effect button-sliding-icon"><i class="icon-feather-check"></i>Modifier</button>
                                                            @endif
                                                        </center>
                                                    </div>
                                    </div>
                                </div>
                    </form>
                    </div>
        @endif
        </div>

        <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->

    </div>

</div>

