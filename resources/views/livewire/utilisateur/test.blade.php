<div class="dashboard-content-container padding-left-20" >
    <div class="dashboard-content-inner" >
        <!-- Dashboard Headline -->
        <div class="dashboard-headline">
            <h3>Manage Test</h3>
        </div>

        @if($op=='all')
            <div class="row">
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-material-outline-question-answer"></i> Les Test qui peut Passer</h3>
                    </div>

                    <div class="content">
                        <ul class="dashboard-box-list">
                            @forelse ($test as $key=>$item)
                            <li>
                                <!-- Job Listing -->
                                <div class="job-listing">

                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">

                                        </a>

                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">{{ $item->titreTest }} {!! "<span class='fw-light font-medium'>($item->descriptionTest)</span>" !!}
                                            </h3>

                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li><i class="icon-line-awesome-share"></i> Publie Par {!! $item->type=='admin'?'Le site':'Par Entreprise' !!}</li>
                                                    <li><i class="icon-line-awesome-hourglass-half"></i> {{ $item->duree }}Min</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Buttons -->
                                <div class="buttons-to-right always-visible">
                                    <button type='button' wire:click="afficherResultatTest({{ $item->idTest }})" class="button ripple-effect"><i class="icon-feather-eye"></i>Afficher resultas</button>

                                        @if(Auth::guard('web')->user()->resultats->where('TestId',
                                        $item->idTest)->isEmpty())
                                            <button type='button' wire:click="change('passertest',{{ $item->idTest }})" class="button ripple-effect">Passer Le Test</button>
                                        @endif
                                </div>
                            </li>
                            @empty
                            @endforelse
                            @forelse ($candidatures as $key=>$item)
                                @if(!$item->offres->TestEntrepriseOffre($item->offres->hasSecteurId,$item->offres->hasEntrepriseId)->isEmpty())
                                <li>
                                    <!-- Job Listing -->
                                    <div class="job-listing">

                                        <!-- Job Listing Details -->
                                        <div class="job-listing-details">
                                            </a>
                                            <!-- Details -->
                                            <div class="job-listing-description">
                                                <h3 class="job-listing-title">{{ $item->offres->TestEntrepriseOffre($item->offres->hasSecteurId,$item->offres->hasEntrepriseId)->first()->titreTest }} {!! "<span class='fw-light font-medium'>(". $item->offres->TestEntrepriseOffre($item->offres->hasSecteurId,$item->offres->hasEntrepriseId)->first()->descriptionTest .")</span>" !!}
                                                </h3>

                                                <!-- Job Listing Footer -->
                                                <div class="job-listing-footer">
                                                    <ul>
                                                        <li><i class="icon-line-awesome-share"></i> Publie Par {{ $item->offres->TestEntrepriseOffre($item->offres->hasSecteurId,$item->offres->hasEntrepriseId)->first()->type }} {{($item->offres->entreprise->nomEntreprise) }}(<strong title="nom d'offre">{{ $item->offres->titreOffre }}</strong>) </li>
                                                        <li><i class="icon-line-awesome-hourglass-half"></i> {{ $item->offres->TestEntrepriseOffre($item->offres->hasSecteurId,$item->offres->hasEntrepriseId)->first()->duree }}Min</li>
                                                        {{--  <li><i class="icon-feather-activity"></i> {{ $item->secteurActiviter->nomSecteurActiviter }}</li>  --}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <div class="buttons-to-right always-visible">
                                        <button type='button' wire:click="afficherResultatTest({{ $item->offres->TestEntrepriseOffre($item->offres->hasSecteurId,$item->offres->hasEntrepriseId)->first()->idTest }})" class="button ripple-effect"><i class="icon-feather-eye"></i>Afficher resultas</button>

                                            @if(Auth::guard('web')->user()->resultats->where('TestId',
                                            $item->offres->TestEntrepriseOffre($item->offres->hasSecteurId,$item->offres->hasEntrepriseId)->first()->idTest)->isEmpty())
                                                <button type='button' wire:click="change('passertest',{{ $item->offres->TestEntrepriseOffre($item->offres->hasSecteurId,$item->offres->hasEntrepriseId)->first()->idTest }})" class="button ripple-effect">Passer Le Test</button>
                                            @endif
                                    </div>
                                </li>
                                @endif
                            @empty
                              <center class='d-flex justify-content-center col-12'>
                                <div class="freelancer">
                                    <mark class='color'>No test actualement</mark>
                                </div>
                            </center>
                            @endforelse

                        </ul>
                    </div>
                </div>
            </div>
        @elseif($op=='passertest')
        <livewire:utilisateur.passertest :idtest="$idTest"/>
        @endif
        </div>
        <div class="clearfix"></div><div class="clearfix"></div>
        <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->

    </div>

</div>

