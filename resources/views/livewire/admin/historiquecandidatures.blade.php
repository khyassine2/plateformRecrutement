
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >

        <!-- Dashboard Headline -->

        @if($op=='all')
        <div class="dashboard-headline">
            <h3 class="">Manage offres</h3>
        </div>

        <div class="row">
            <!-- Dashboard Box -->
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <br>


                    <!-- Headline -->
                    <div class="isma headline d-flex justify-content-between ">


                       <h3>Historique Candidature</h3>

                    </div>


                    <div class="content">


                        <!-- Overview -->
                        <ul class="dashboard-box-list">
                                    @forelse ($historique as $item)
                                    <li>
                                <div class="freelancer-overview manage-candidates">
                                    <div class="freelancer-overview-inner ">
                                        <div >


                                        <!-- Name -->
                                        <div class="freelancer-name">
                                            <h3>{{$item->candidatures->users->nomUtilisateur .' '.$item->candidatures->users->prenomUtilisateur}}</h3>

                                            <!-- Details -->
                                            <span class="freelancer-detail-item"><i class="icon-material-outline-gavel"></i><a >{{ $item->status }}</a></span>
                                            <span class="freelancer-detail-item"><i class="icon-material-outline-date-range"></i>{{$item->dateSoumission}} </span>
                                            <br>
                                            <span class="freelancer-detail-item"><i class="icon-material-outline-business-center"></i><a >{{ $item->candidatures->offres->titreOffre }}</a></span>
                                            <span class="freelancer-detail-item"><i class="icon-material-outline-date-range"></i>{{$item->candidatures->offres->entreprise_has_secteurs->secteur_activiters->nomSecteurActiviter}} </span>
                                            <span class="freelancer-detail-item"><i class="icon-material-outline-business"></i>{{$item->candidatures->offres->entreprise_has_secteurs->entreprises->nomEntreprise}} </span>



                                            <!-- Buttons -->
                                            <div class="buttons-to-right  buttons-to-right single-right-button">

                                                <a wire:click="change('delete',{{$item->idHistorique}})" class="button gray ripple-effect ico"  title="supprimer Offre" data-tippy-placement="left"><i class="icon-feather-trash-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @empty
                                <br>
                                <center class='d-flex justify-content-center col-12'>
                                            <div class="freelancer">
                                                <mark class='color'>No Historique candidature</mark>
                                            </div>
                                        </center>
                                <br>
                                @endforelse
                            </li>

                        </ul>


                    </div>
                </div>
            </div>

        </div>
        @elseif($op=='delete')
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">
                <div class="headline ">
                   <h3><i class="icon-material-outline-supervisor-account"></i> delete  offre</h3>
                </div>
                <center>
                    <div class="content">
                        <br>
                    confirmation de supression de candidature du <mark> {{ $offreDelete }}</mark> :
                     <br><br>
                        <button wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                        <button wire:click='delete' class="button ripple-effect button-sliding-icon">supprimer<i class="icon-feather-check"></i></button>
                    <br><br>
                    </div>
                    </center>
            </div>
        </div>
        @endif
