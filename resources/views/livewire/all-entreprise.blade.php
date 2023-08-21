<div class="container-fluid" style="width: 97% !important">
	@if(session('opAllEntreprise')=='all' || session('opAllEntreprise')=='')
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="sidebar-container padding-top-30">
                    <!-- Secteur Activiter -->
                    <div class="sidebar-widget">
                        <h3>Nom Entreprise</h3>
                        <input type="text" wire:model='nomSearch' placeholder="Entrez un nom entreprise">
                    </div>
                    <!-- Location -->
                    <div class="sidebar-widget">
                        <h3>Ville</h3>
                        <div class="input-with-icon">
                            <div id="autocomplete-container">
                                <select wire:model='villeSearch'>
                                    <option value=''>choisissez une Ville</option>
                                    @foreach ($ville as $item)
                                        <option value="{{ $item->id }}">{{ $item->nomVille }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <i class="icon-material-outline-location-on"></i>
                        </div>
                    </div>

                    <!-- Secteur Activiter -->
                    <div class="sidebar-widget">
                        <h3>Secteur Activiter</h3>
                        <select wire:model='secteurSearch' >
                            <option value="">Choisissez un Secteur</option>
                            @forelse ($secteur as $item)
                                <option value="{{ $item->idSecteurActiviter }}">{{ $item->nomSecteurActiviter }}</option>
                            @empty
                                <option value="">no Formation/option>
                            @endforelse
                        </select>
                    </div>

                    
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 content-left-offset padding-top-30">

                <h3 class="page-title">Cherche Resultats</h3>


                <div class="listings-container margin-top-35">

                    <!-- Entreprise Listing -->
                    @forelse ($entreprise as $item)
                        <a wire:click="change('detailsEntreprise',{{ $item->idEntreprise }})" class="job-listing">

                            <!-- Job Listing Details -->
                            
                            <div class="job-listing-details">
                                <!-- Logo -->
                                <div class="job-listing-company-logo">
                                    <img src="{{asset('/storage/'.$item->photo) }}" width='53px' height='55px'  alt="">
                                </div>

                                <!-- Details -->
                                <div class="job-listing-description">
                                    <h4 class="job-listing-company">{{ $item->nomEntreprise }}</h4>
                                    <h3 class="job-listing-title">{{$item->emailEntreprise}}</h3>
                                    <p class="job-listing-text">
                                        @forelse ($item->secteurs as $key1=>$item1)
                                            <mark class="color">{{ $item1->nomSecteurActiviter }}</mark>
                                        @empty

                                        @endforelse
                                    </p>
                                </div>
                            </div>

                            <!-- Job Listing Footer -->
                            <div class="job-listing-footer">
                                <ul>
                                    <li><i class="icon-material-outline-location-on"></i> {{ $item->adresseEntreprise }}({{ $item->villes->nomVille??'' }})</li>
                                    <li><i class="icon-feather-phone"></i>{{$item->telephone}}</li>
                                     <li><i class="icon-material-outline-language"></i> {{ $item->siteWebEntreprise }}</li>
                                   {{--  <li><i class="icon-material-outline-access-time"></i> 2 days ago</li>  --}}
                                </ul>
                            </div>
                        </a>
                    @empty
                        <center class='d-flex justify-content-center col-12'>
                            <div class="freelancer">
                                <mark class='color'>No Entreprise</mark>
                            </div>
                        </center>
                    @endforelse




                    <!-- Pagination -->
                        <div class="clearfix"></div>
                        <div class='col-12'>
                            <center>
                            {{$entreprise->links('livewire.layoutsLivewire.pagination')}}
                        </center>
                        </div>
                    <!-- Pagination / End -->

                </div>

                         <!-- Footer -->
                            @include('livewire.layoutsLivewire.footerDashboard')
                        <!-- Footer / End -->
            </div>
            
        </div>
    @elseif(session('opAllEntreprise')=='detailsEntreprise')
        <div>
            <div class="single-page-header" style='background-image: url("images/single-company.jpg") !important'>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="single-page-header-inner">
                                <div class="left-side">
                                    <div class="header-image"><a href="#"><img  src="{{ asset('/storage/'.$oneEntreprise->photo) }}" alt=""></a></div>
                                    {{--  <div class="header-image padding-left-0 padding-right-0 padding-top-0"><img  alt="" height='120px'></div>  --}}
                                    <div class="header-details">
                                        <h3>{{ $oneEntreprise->nomEntreprise }} 
                                            <span>
                                                @if(!Auth::guard('web')->check() && !Auth::guard('entreprise')->check())
                                                    {{ Str::limit($oneEntreprise->emailEntreprise,6) }}
                                                @else
                                                    {{ $oneEntreprise->emailEntreprise }}
                                                @endif
                                            </span></h3>
                                        <ul>
                                            <li><div><i class="icon-material-outline-location-on"></i>{{ $oneEntreprise->villes->nomVille }}</div></li>
                                            <li><i class="icon-feather-phone"></i>{{$oneEntreprise->telephone}}</li>
                                            <li><i class="icon-material-outline-language"></i>{{ $oneEntreprise->siteWebEntreprise }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container">
            <div class="row">
                
                <!-- Content -->
                <div class="col-xl-12 col-lg-12 content-right-offset">
        
                    <div class="single-page-section">
                        <h3 class="margin-bottom-25">À propos d'Entreprise :</h3>
                        <p>Chez notre entreprise, nous croyons que notre succès dépend de nos employés. Nous sommes fiers de créer un environnement de travail inclusif et collaboratif qui encourage nos employés à exceller dans leur travail et à réaliser leur plein potentiel. Nous recherchons des personnes talentueuses, motivées et passionnées qui souhaitent faire partie de notre équipe dynamique. 
                            {{--  Nous offrons des possibilités de développement de carrière et des avantages compétitifs pour nos employés, ainsi que des programmes de formation continue pour les aider à acquérir les compétences et les connaissances nécessaires pour exceller dans leur travail. Si vous êtes prêt à relever des défis passionnants et à travailler avec une équipe formidable, rejoignez-nous dès maintenant et faites partie de notre succès!  --}}
                        </p>
        
                        <p>Notre entreprise est un leader dans les secteurs d'activité suivants :
                            @forelse ($oneEntreprise->secteurs as $key=>$item)
                                <strong>{{ $item->nomSecteurActiviter}} {{ $key+1==count($oneEntreprise->secteurs)?" .":" , " }}</strong>
                            @empty
                                
                            @endforelse
                            Nous sommes engagés dans la fourniture de produits et services de qualité à nos clients dans ces domaines et nous sommes constamment à la recherche de nouvelles idées pour améliorer notre offre. 
                            {{--  En tant que membre de notre équipe, vous aurez l'occasion de travailler dans des environnements stimulants et dynamiques, en développant des compétences précieuses et en contribuant à des projets innovants. Nous sommes convaincus que nos employés sont notre atout le plus précieux et nous nous engageons à leur fournir un environnement de travail inclusif, équitable et respectueux. Rejoignez-nous et découvrez les opportunités passionnantes que nous avons à offrir dans ces secteurs en pleine croissance.  --}}
                        </p>
                    </div>
                    
                    <!-- Boxed List -->
                    <div class="boxed-list margin-bottom-60">
                        <div class="boxed-list-headline">
                            <h3><i class="icon-material-outline-business-center"></i> Suggestion</h3>
                        </div>
        
                        <div class="listings-container compact-list-layout">
                            
                            <!-- Entreprise Listing -->
                            @forelse ($EntrepriseRef as $key=>$item)
                            <a wire:click="change('detailsEntreprise',{{ $item->idEntreprise }})" class="job-listing">
        
                                <!-- Job Listing Details -->
                                <div class="job-listing-details">
                                    
                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <div class="d-flex">
                                            <img style="border-radius: 50% !important" src={{asset('/storage/'.$item->photo)}} alt="" width='60px' height='60px' >
                                            <div class="margin-left-20">
                                                <h3 class="job-listing-title"><strong>{{ $item->nomEntreprise }}</strong><span> ({{ $item->villes->nomVille }})</span>
                                                </h3>
                                                <div class="job-listing-footer">
                                                    <ul>
                                                        <li><i class="icon-feather-activity"></i>
                                                        @forelse ($item->secteurs as $item)
                                                            {{$item->nomSecteurActiviter.' |'}}
                                                        @empty
                                                        @endforelse
                                                        </li>
                                                        {{--  <li><i class="icon-material-outline-business-center"></i> {{ $item->secteurActiviter->nomSecteurActiviter }}</li>
                                                        <li><i class="icon-material-outline-date-range"></i> {{ $item->DateDebutStage }}</li>
                                                        <li><i class="icon-material-outline-access-time"></i> {{ $dateDiff[$key] }}</li>  --}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
        
                                        {{--  <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-location-on"></i> Berlin</li>
                                                <li><i class="icon-material-outline-business-center"></i> Full Time</li>
                                                <li><i class="icon-material-outline-access-time"></i> 2 days ago</li>
                                            </ul>
                                        </div>  --}}
                                    </div>
        
                                </div>
        
                            </a>     
                            @empty
                                
                            @endforelse                 
                        </div>
                        <center><button type='button' wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Return</button></center>
                    </div>
                    <!-- Boxed List / End -->
        
                </div>
                
        
                <!-- Sidebar -->
                {{--  <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-container">
        
                        <!-- Location -->
                        <div class="sidebar-widget">
                            <h3>Location</h3>
                            <div id="single-job-map-container">
                                <div class="google_map_area">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="google_map_area">
                                                <iframe class="map" src="https://snazzymaps.com/embed/65241"></iframe>		
                                            </div>
                                        </div>				
                                    </div>
                                </div>
                                <a href="#" id="streetView">Street View</a>
                            </div>
                        </div>
                    </div>
                </div>  --}}
        
            </div>
        </div>
        </div>
    @endif
</div>
