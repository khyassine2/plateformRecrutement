<div class="dashboard-content-container padding-left-20" >
    <div class="dashboard-content-inner" >
        <div class="dashboard-headline">
            <h3>Gerer Mes candidatures</h3>
        </div>
        @if(session('opCu')=='all' || session('opCu')=='')
            <div class="row">
            <div class="col-xl-12"> 
                <div class="dashboard-box margin-top-0">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-material-outline-business-center"></i> Mes candidatures </h3>
                    </div>

                    <div class="content margin-top-20">
                        @forelse ($histcondidat as $key=>$item)
                        <ul class="dashboard-box-list">
                        <li >
                                    <!-- Overview -->
                                    <div class="freelancer-overview manage-candidates">
                                        <div class="freelancer-overview-inner">

                                            <!-- Avatar -->
                                            <div class="freelancer-avatar">
                                                <a><img class="pic" src={{asset('/storage/'.$item->offres->entreprise_has_secteurs->entreprises->photo) }}   alt="not found"></a>

                                            </div>

                                            <!-- Name -->
                                            <div class="freelancer-name">
                                                <div class='d-flex justify-content-between'>
                                                     <h4>{{$item->offres->titreOffre}}</h4>
                                                @if(!$item->historique_condidatures->isEmpty() &&$item->historique_condidatures->first()->status=='en discussion')
                                                    <h4 class='text-success'>votre postulation accepté</h4>
                                                @elseif($item->historique_condidatures->isEmpty())
                                                    <h4 class='text-warning'>en attente</h4>
                                                @endif
                                                </div>
                                               
                                                <!-- Details -->
                                                <span class="freelancer-detail-item"><a ><i class="icon-material-outline-business"></i> <span >{{' '.$item->offres->entreprise_has_secteurs->entreprises->nomEntreprise.' ' }}<i class="icon-feather-activity"></i>{{' '.$item->offres->entreprise_has_secteurs->secteur_activiters->nomSecteurActiviter }}</span></a></span><br>
                                                <span class="freelancer-detail-item"><a ><i class="icon-material-outline-date-range"></i> <span >{{$item->dateCandidatures}}</span></a></span>
                                                <span class="freelancer-detail-item"><i class="icon-feather-git-pull-request"></i>  {{$item->competenceQualification}}</span>

                                                <!-- Buttons -->

                                                <div class="buttons-to-right  buttons-to-right single-right-button">
                                                    <a class="button gray ripple-effect ico" wire:click="change('delete',{{$item->idCandidature}})" title="Supprimer Postulation" data-tippy-placement="left"><i class="icon-feather-trash-2"></i></a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @empty
                        <br>
                            <center class='d-flex justify-content-center col-12'>
                                <div class="freelancer">
                                    <mark class='color'>Il n'est a pas des Candidatures</mark>
                                </div>
                            </center>
                        <br>
                        @endforelse
                    </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
            <!-- Footer / End -->
            </div>
        @elseif(session('opCu')=='delete')
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="headline ">
                       <h3>Supprimer Candidature</h3>
                    </div>
                        <div class="content">
                            <br><center>
                        Vous avez sur de supprimer <br> votre condidature de l'offre : <mark> {{ $offreDelete }}</mark>  :
                            <br>
                            <button wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon margin-top-10 margin-bottom-10"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                            <button wire:click='delete' class="button ripple-effect button-sliding-icon margin-top-10 margin-bottom-10">supprimer<i class="icon-feather-check"></i></button>
                        <br><br></center>
                        </div>
                </div>
            </div>
        @endif
        
</div>

