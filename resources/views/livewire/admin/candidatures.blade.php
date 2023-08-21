
<div>
    <div class="dashboard-content-inner" >

        <!-- Dashboard Headline -->

        <div class="dashboard-headline">
            <h3>Manage Candidates</h3>
            @if($histcondidat->first()!==null)
            <span class='margin-top-7'>Les candidature pour l'offre : <a style="color: #000000;font-weight: bolder">{{$histcondidat->first()->offres()->first()->titreOffre}}</a></span>
            @endif
        </div>

@if(session('opC')=='all' || session('opC')=='')
<!-- Row -->
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3><i class="icon-material-outline-business-center"></i> les condidatures</h3>
            </div>
            <div class="content">
                @forelse ($histcondidat as $key=>$item)
                <ul class="dashboard-box-list">
                <li >
                            <!-- Overview -->
                            <div class="freelancer-overview manage-candidates">
                                <div class="freelancer-overview-inner">

                                    <!-- Avatar -->
                                    <div class="freelancer-avatar">

                                        <a><img class="pic" src={{asset('/storage/'.$item->users->photo) }}   alt="not found"></a>
                                    </div>

                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <h4>{{$item->users->nomUtilisateur.' '.$item->users->prenomUtilisateur}}</h4>

                                        <!-- Details -->
                                        <span class="freelancer-detail-item"><a ><i class="icon-feather-mail"></i> <span >{{$item->users->email}}</span></a></span>
                                        <span class="freelancer-detail-item"><i class="icon-feather-phone"></i> (+212) {{$item->users->telephone}}</span>


                                        <!-- Buttons -->

                                        <div class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
                                            <a  class="button ripple-effect" wire:click="downloadFile('{{ $item->users->donners->cv }}')"><i class="icon-feather-file-text"></i> Download CV</a>
                                                <a  class="popup-with-zoom-anim button dark ripple-effect" wire:click='sendMessage({{ $item->users->telephone }})'><i class="icon-brand-whatsapp"></i> Send Message</a>
                                            @if (!$item->historique_condidatures->isEmpty())
                                                <a  class="popup-with-zoom-anim button ripple-effect d-none" wire:click="accepterCandidat('{{ $item->idCandidature }}')"><i class="icon-material-outline-check"></i> Accepter</a>

                                            @else
                                                <a class="popup-with-zoom-anim button ripple-effect " wire:click="accepterCandidat('{{ $item->idCandidature }}')"><i class="icon-material-outline-check"></i> Accepter</a>
                                            @endif
                                            <a class="button gray ripple-effect ico" wire:click="change('delete',{{$item->idCandidature}})" title="Candidate" data-tippy-placement="left"><i class="icon-feather-trash-2"></i></a>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                @empty
                <br>
                    <center>
                        <h1>
                            <mark class='color'>il n'est a pas de candidature</mark>
                        </h1>
                        <br>
                        <button type='button' wire:click='toBack' type="button" class="button ripple-effect button-sliding-icon margin-top-20"><i class="icon-material-outline-arrow-back"></i>retour</button>
                    </center>
                <br>
                @endforelse
            </div>
        </div>
    </div>


</div>
@elseif(session('opC')=='delete')
<div class="col-xl-12">
    <div class="dashboard-box margin-top-0">
        <div class="headline ">
           <h3><i class="icon-material-outline-supervisor-account"></i> delete  offre</h3>
        </div>
            <center>
                <div class="content">
                Vous avez sur de supprimer candidatures <br> de l'offre d'utilisateur <strong>
                    {{ $nomUtilisateur }}</strong> : <mark> {{ $offreDelete }}</mark>  : <br>
                    <button type='button' wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon margin-top-20 margin-bottom-20"><i class="icon-material-outline-arrow-back "></i>Annuler</button>
                    <button type='button' wire:click='delete()' class="button ripple-effect button-sliding-icon margin-top-20 margin-bottom-20">supprimer<i class="icon-feather-check"></i></button>
                </div>
            </center>
    </div>
</div>
@endif
</div>
