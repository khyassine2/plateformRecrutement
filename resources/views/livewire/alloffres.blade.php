@if (session('opAllOffre') == 'all' || session('opAllOffre')=='')
    <div class="{{session('opAllOffre')=='info'?'container':'container-fluid'}}" style='width:97% !important'>
        <div class="row">

            <div class="col-xl-3 col-lg-4">
                <div class="sidebar-container padding-top-20 margin-left-10">
                    <br>
                    <!-- Chercher par titre d'offre -->
                    <div class="sidebar-widget">
                        <h3 class='text-capitalize'>nom offre</h3>
                        <input type="text" wire:model='filterby' placeholder="Entrez le nom d'offre">
                    </div>
                    <div class="sidebar-widget">
                        <h3 class='text-capitalize'>ville</h3>
                        <select wire:model="ville" class="sidebar-widget" wire:change="filterByville($event.target.value)">
                            <option value="">Toutes les type d'offre </option>
                            @forelse ($villes as $item)
                                <option value={{$item->id}}>{{$item->nomVille}}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <!-- Entreprises -->
                    <div class="sidebar-widget">

                        <h3 class='text-capitalize'>Entreprise</h3>
                        <select wire:model="entreprises" class="sidebar-widget" wire:change="filterByEnreprise($event.target.value)">
                            <option value="">Toutes les Entreprise</option>
                            @forelse ($entreprise as $item)

                                <option value={{$item->idEntreprise}}>{{$item->nomEntreprise}}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>

                    <!-- secteuractiviter -->
                    <div class="sidebar-widget">
                        <h3 class='text-capitalize'>Secteur d'Activiter</h3>
                        <select wire:model="secteurs" class="sidebar-widget" wire:change="filterBySecteurs($event.target.value)">
                            <option value="">Toutes les secteurs</option>
                            @forelse ($secteuractiviter as $item)
                            @if ($secteurs)
                            <option value={{ $item->idSecteurActiviter }} {{ $secteurs==$item->idSecteurActiviter || request('select') == $item->idSecteurActiviter ? 'selected' : '' }}>{{ $item->nomSecteurActiviter }}</option>
                            @else
                            <option value={{$item->idSecteurActiviter}}>{{$item->nomSecteurActiviter}}</option>

                            @endif
                            @empty

                            @endforelse
                        </select>
                    </div>


                    <!-- Job Types -->
                    <div class="sidebar-widget">
                        <h3>Type d'offre</h3>
                        <select wire:model="type" class="sidebar-widget" wire:change="filterByTypeOffre($event.target.value)">
                            <option value="">Toutes les type d'offre </option>
                            @forelse ($typeOffre as $item)
                                <option value={{$item}}>{{$item}}</option>
                            @empty

                            @endforelse
                        </select>


                    </div>

                    <!-- Salary -->
                    <div class="sidebar-widget">
                        <h3 class='text-capitalize'>Salaire</h3>
                        <div >
                            <div class="rc"><span >Min Price : {{ $minPrice }} DH </span><input class="r" type="range" id="range" wire:model="minPrice" value="0" max="10000" step="500"/></div><br>
                            <div class="rc"><span>Max Price : {{ $maxPrice }} DH </span><input class="r" type="range" id="range" wire:model="maxPrice" value="10000" max="10000" step="500"/></div>

                        </div>

                        <!-- Range Slider -->


                    </div>

                    <div class="sidebar-widget">
                        <h3 class='text-capitalize'>filter date</h3>
                        <div >
                        <span  class='text-capitalize'> date publier : </span><input  type="date" class="input-text" wire:model="dateFilter1"><br>
                        <span class='text-capitalize'> date cloture :  </span><input  type="date" class="input-text" wire:model="dateFilter2">




                    </div>
                            </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 content-left-offset padding-top-20">
                <br>
                <h3 class="page-title">Résultats de recherche</h3>
                <div class="listings-container grid-layout margin-top-35">

                    @forelse ($offres as $item)
                    <!-- Job Listing -->
                    <a wire:click="changediv('info',{{$item->idOffre}})" style="cursor:pointer" class="job-listing">

                        <!-- Job Listing Details -->
                        <div class="job-listing-details">
                            <!-- Logo -->
                            <div class="job-listing-company-logo">
                                <img src={{asset('/storage/'.$item->entreprise_has_secteurs->entreprises->photo) }} alt=""  height="60px">
                            </div>
                            <!-- Details -->
                            <div class="job-listing-description">
                                <h4 class="job-listing-company">{{$item->entreprise_has_secteurs->entreprises->nomEntreprise.' '}}<span class="verified-badge" title="Verified Employer" data-tippy-placement="top"></span></h4>
                                <h4 class="job-listing-company">{{$item->entreprise_has_secteurs->secteur_activiters->nomSecteurActiviter}}</h4>
                                <h3 class="job-listing-title">{{ $item->titreOffre}}</h3>
                            </div>
                        </div>

                        <!-- Job Listing Footer -->
                        <div class="job-listing-footer">
                            <ul>
                                <li><i class="icon-material-outline-location-on"></i>{{ $item->entreprise_has_secteurs->entreprises->villes->nomVille}}</li>
                                <li><i class="icon-material-outline-business-center"></i>Type offre : {{ $item->typeOffre}}</li>
                                <li><i class="icon-material-outline-account-balance-wallet"></i>{{$item->RemunurationPropose==0?'no rémunération':$item->RemunurationPropose.' DH'}}</li> <br>
                                {{--  <li>{{ $item->test=='oui'?"Test obligatoire":"" }}</li> <br>  --}}
                                <li class="freelancer-detail-item dashboard-status-button green margin-top-10"><i class="icon-material-outline-access-time"></i>Publie : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->datePublie)->locale('fr_FR')->isoFormat('DD MMMM YYYY')}}</li>
                                <li class="freelancer-detail-item dashboard-status-button red"><i class="icon-material-outline-access-time"></i>Experie : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->dateCloture)->locale('fr_FR')->isoFormat('DD MMMM YYYY')}}</li>
                            <br><br><center><button wire:click="changediv('info',{{$item->idOffre}})" class="button ripple-effect ">consulter l'offre</button></center><br>
                            </ul>
                        </div>
                    </a>
                    @empty
                                    <br>
                                        <center class='d-flex justify-content-center col-12'>
                            <div class="freelancer">
                                <mark class='color'>No Offres</mark>
                            </div>
                        </center>
                                    <br>
                    @endforelse



            </div>
            {{ $offres->links('livewire.layoutsLivewire.pagination') }}
              <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->
        </div>
    
    </div>
@elseif ($selectedDiv == 'info')
		<div class="container">
			<div class="single-page-header" data-background-image={{asset('/storage/'.$offre->entreprise_has_secteurs->entreprises->photo) }}>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image padding-left-0 padding-right-0"><img src={{asset('/storage/'.$offre->entreprise_has_secteurs->entreprises->photo) }} alt="" height='140' ></div>
						<div class="header-details">
							<h3>{{$offre->titreOffre}}</h3>
							<h5>À propos de l'entreprise</h5>
							<ul>

								<li><a href="{{ route('allEntreprise',['opp'=>'detailsEntreprise','idD'=>$offre->entreprise->idEntreprise]) }}"><i class="icon-material-outline-business"></i> {{$offre->entreprise->nomEntreprise}}</a></li>
                                <li> <i class="icon-feather-activity"></i> {{$offre->secteur->nomSecteurActiviter}}</li>

							</ul>
						</div>
					</div>
					<div class="right-side">
						<div class="salary-box">
							<div class="salary-type">Salaire Mensuel</div>
							<div class="salary-amount">{{$offre->RemunurationPropose==0?'no rémunération':$offre->RemunurationPropose.'DH'}} </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="row">

		<!-- Content -->
		<div class="col-xl-8 col-lg-8 content-right-offset">
           
            <div class="single-page-section margin-bottom-0">
                <h3 class="margin-bottom-15 text-capitalize"><strong>Description d'offre : </strong>{{$offre->descriptionOffre}}</h3>
            </div>
            <div class="single-page-section margin-bottom-0">
                <h3 class="margin-bottom-15 text-capitalize"><strong>CompetenceRequise d'offre : </strong>{{$offre->competenceRequise}}</h3>
            </div>
            <div class="single-page-section margin-bottom-50">
                <h3 class="margin-bottom-15 text-capitalize"><strong>obligation de passer Test : </strong>{{$offre->test}}</h3>
            </div>
				{{--  <div >
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d41195.59631485697!2d-5.010765748099864!3d34.01781690563143!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1680049606808!5m2!1sen!2sus" width="450" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>  --}}


				<div class="single-page-section">
                    <h3 class="margin-bottom-25">Offres simulaires</h3>
        
                    <!-- Listings Container -->
                    <div class="listings-container grid-layout">
        
                            <!-- Job Listing -->
                            @forelse ($offresumilaire as $item)
                                
                            <a href={{route('alloffresid', ['op' => 'offre', 'id2' => $item->idOffre]) }} class="job-listing ">
        
                                <!-- Job Listing Details -->
                                <div class="job-listing-details">
                                    <!-- Logo -->
                                    <div class="job-listing-company-logo">
                                        <img src={{asset('/storage/'.$item->entreprise->photo) }} width="60" height="60" alt="">
                                    </div>
        
                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <h4 class="job-listing-company">{{$item->entreprise->nomEntreprise}}</h4>
                                        <h3 class="job-listing-title">{{$item->titreOffre}}</h3>
                                    </div>
                                </div>
        
                                <!-- Job Listing Footer -->
                                <div class="job-listing-footer">
                                    <ul>
                                        <li><i class="icon-material-outline-location-on"></i>{{$item->entreprise->villes->nomVille}}</li>
                                        <li><i class="icon-material-outline-business-center"></i> {{$item->typeOffre}}</li>
                                        <li><i class="icon-material-outline-account-balance-wallet"></i> {{$item->RemunurationPropose=='0'?'no rémunération':$item->RemunurationPropose.' DH'}} </li>
                                        <li><i class="icon-material-outline-access-time"></i>{{$item->datePublie}}</li>
                                    </ul>
                                </div>
                            </a>
                            @empty
                                <center>
                                    <h1>
                                        <mark>il n'est a pas d'offres simulaires</mark>
                                    </h1>
                                </center>
                            @endforelse
        
                            
        
                        </div>
                        <!-- Listings Container / End -->
        
                    </div>
                <center><button type='button' wire:click='changediv("all",null)' class="button ripple-effect button-sliding-icon margin-bottom-30 padding-right-10"><i class="icon-material-outline-arrow-back"></i>Return</button></center>

	</div>
	<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">
				{{-- {{dd(!$offre->candidatures->isEmpty())}} --}}
				@can('user')
                    <a  class="apply-now-button popup-with-zoom-anim " style="cursor:pointer" wire:click="tocandidate({{$offre->idOffre}})">Postuler <i class="icon-material-outline-arrow-right-alt"></i></a>
                @endcan

				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<div class="job-overview">
						<div class="job-overview-headline">Résumé d'Offre</div>
						<div class="job-overview-inner">
							<ul>
								<li>
									<i class="icon-material-outline-location-on"></i>
									<span>Location</span>
									<h5> {{$offre->entreprise_has_secteurs->entreprises->adresseEntreprise}} , {{$offre->entreprise_has_secteurs->entreprises->villes->nomVille}}</h5>
								</li>
								<li>
									<i class="icon-material-outline-business-center"></i>
									<span>Type d'offre</span>
									<h5>{{$offre->typeOffre}}</h5>
								</li>
								<li>
									<i class="icon-material-outline-local-atm"></i>
									<span>Salaire Mensuel</span>
									<h5>{{$offre->RemunurationPropose=='0'?'no rémunération':$offre->RemunurationPropose.' DH'}} </h5>
								</li>
								<li>
									<i class="icon-material-outline-access-time"></i>
									<span>Date de Publication</span>
									<h5>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $offre->datePublie)->locale('fr_FR')->isoFormat('DD MMMM YYYY')}}</h5>
								</li>
								<li>
									<i class="icon-material-outline-access-time"></i>
									<span>Date de Cloture</span>
									<h5>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $offre->dateCloture)->locale('fr_FR')->isoFormat('DD MMMM YYYY')}}</h5>
								</li>
							</ul>
						</div>
					</div>
				</div>



			</div>
		</div>
    {{--  endsidebar  --}}
    
</div>
@endif
