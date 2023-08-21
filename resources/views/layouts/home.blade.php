@extends('layouts.app')

@section('content')
<!-- Intro Banner
    ================================================== -->
    <!-- add class "disable-gradient" to enable consistent background overlay -->
    <div class="intro-banner dark-overlay big-padding">

        <!-- Transparent Header Spacer -->
        <div class="transparent-header-spacer"></div>

        <div class="container">

            <!-- Intro Headline -->
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-headline-alt">
                        <h3>Trouvez votre prochain emploi</h3>
                        <span>Trouver les meilleurs emplois dans votre intérisé secteur</span>
                    </div>
                </div>
            </div>
        <form method="POST" action="{{ route('alloffresid') }}" name="myform">
                @csrf
                <!-- Search Bar -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="intro-banner-search-form margin-top-95">
                            <!-- Search Field -->
                            <div class="intro-search-field with-autocomplete with-label"><div class="pac-container pac-logo" style="display: none; width: 364px; position: absolute; left: 111px; top: 500px;"></div>
						<label for="autocomplete-input"></label>
						<div class="input-with-icon">
							<input id="autocomplete-input" name='myinput' type="text" placeholder="Entrez nom d'offres" class="pac-target-input" autocomplete="off">
							<i class="icon-material-outline-search"></i>
						</div>
					</div>
                            <div class="intro-search-field">
                                <select name="select" class="selectpicker"  title="Tous les Secteurs" data-live-search="true">
                                    @foreach ($Allsecteur as $item)
                                    <option value={{$item->idSecteurActiviter}}>{{$item->nomSecteurActiviter}}</option>
                                @endforeach
                                </select>
                            </div>

                            <!-- Button -->
                            <div class="intro-search-button">
                                <button type='submit' class="button ripple-effect" >Chercher</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
            <!-- Stats -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="intro-stats margin-top-45 hide-under-992px">
                        <li>
                            <strong class="counter">{{ $CountOffres }}</strong>
                            <span>Offres Publie</span>
                        </li>
                        <li>
                            <strong class="counter">{{$countSecteur}}</strong>
                            <span>Secteur</span>
                        </li>
                        <li>
                            <strong class="counter">{{ $countEntreprise }}</strong>
                            <span>Entreprise</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Video Container -->
        <div class="video-container" data-background-image="{{asset('images/home-video-background-poster.jpg')}}">
            <video loop autoplay muted>
                <source src="{{asset('images/home-video-background.mp4')}}" type="video/mp4">
            </video>
        </div>

    </div>


    <!-- Content
    ================================================== -->
    <!-- Category Boxes -->
    <div class="section padding-top-65 margin-bottom-30">
        <div class="container">
            <div class="row justify-content-center">

                <!-- Section Headline -->
                <div class="col-xl-12">
                    <div class="section-headline centered margin-top-0 margin-bottom-45">
                        <h3>Populaires Secteur</h3>
                    </div>
                </div>
                @forelse ($secteur as $key=>$item)
                <div class="col-xl-4 col-md-6">
                    <!-- Photo Box -->
                    <a href="{{route('alloffresid',['op' => 'secteur', 'id2' => $item->idSecteurActiviter]) }}" class="photo-box small" data-background-image="{{asset('/storage/'.$item->photo)}}">
                        <div class="photo-box-content">
                            <h3>{{ $item->nomSecteurActiviter }}</h3>
                            <span>{{ $countOffresParSecteur[$key] }}</span>
                        </div>
                    </a>
                </div>
                @empty
                    <center><h1><mark class='color'>No secteur</mark></h1></center>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Category Boxes / End -->


    <!-- Features Jobs -->
    <div class="section gray margin-top-45 padding-top-65 padding-bottom-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <!-- Section Headline -->
                    <div class="section-headline margin-top-0 margin-bottom-35">
                        <h3>Dernier Offres</h3>
                        <a href="{{route('alloffres') }}" class="headline-link">Afficher Tous</a>
                    </div>

                    <!-- Jobs Container -->
                    <div class="listings-container compact-list-layout margin-top-35">
                        @forelse ($offres as $key=>$item)
                        <!-- Job Listing -->
                        <a href={{route('alloffresid', ['op' => 'offre6', 'id2' => $item->idOffre]) }} style="cursor:pointer"  class="job-listing with-apply-button">

                            <!-- Job Listing Details -->
                            <div class="job-listing-details">

                                <!-- Logo -->
                                <div class="job-listing-company-logo">
                                    <img class="ie" src={{asset('/storage/'.$item->entreprise_has_secteurs->entreprises->photo) }}  height="50px"  alt="">
                                </div>

                                <!-- Details -->
                                <div class="job-listing-description">
                                    <h3 class="job-listing-title">{{ $item->titreOffre }}</h3>

                                    <!-- Job Listing Footer -->
                                    <div class="job-listing-footer">
                                        <ul>
                                            <li><i class="icon-material-outline-business"></i> {{$item->entreprise->nomEntreprise}} </li><li><i class="icon-feather-activity"></i> {{$item->secteur->nomSecteurActiviter}} </li>
                                            <li><i class="icon-material-outline-location-on"></i> {{$item->entreprise_has_secteurs->entreprises->Villes->nomVille}} </li>
                                            <li><i class="icon-material-outline-business-center"></i>{{$item->typeOffre}}</li>
                                            <li><i class="icon-material-outline-access-time"></i>{{ $datePublieOffre[$key] }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Apply Button -->
                                <span class="list-apply-button ripple-effect">Postulez maintenant</span>
                            </div>
                        </a>
                        @empty
                            <a href="#" class="job-listing with-apply-button">

                                <!-- Job Listing Details -->
                                <div class="job-listing-details d-flex justify-content-center">


                                    <div>
                                        <center style="font-size: 24pt">No Offre actuellemente</center>
                                    </div>

                                </div>
                            </a>
                        @endforelse


                    </div>
                    <!-- Jobs Container / End -->

                </div>
            </div>
        </div>
    </div>
    <!-- Featured Jobs / End -->


    <!-- demande Container -->
    <div class="section gray  padding-top-65 padding-bottom-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <!-- Section Headline -->
                    <div class="section-headline margin-top-0 margin-bottom-35">
                        <h3>Derniere Demande</h3>
                        <a href="{{ route('AllDemandeStage') }}" class="headline-link">Afficher Tous</a>
                    </div>
                    <div class="listings-container compact-list-layout margin-top-35">
                        @forelse ($DemandeStage as $key=>$item)
                            <!-- demande Listing -->
                            @if(!empty($item->utilisateurs))
                            <a href="{{ route('AllDemandeStage',['opp'=>'detailsDemande','idD'=>$item->idDemande]) }}" class="job-listing with-apply-button">

                                <!-- Job Listing Details -->
                                <div class="job-listing-details">

                                    <!-- Logo -->
                                    <div class="job-listing-company-logo">
                                        <img src="{{ asset('/storage/'.$item->utilisateurs->photo??'') }}" width='50px' height='50px' alt="" title="{{ $item->utilisateurs->nomUtilisateur.' '.$item->utilisateurs->prenomUtilisateur }}" data-tippy-placement="left">
                                    </div>

                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">{{ $item->titreDemande }} ({{$item->niveauEtude}})</h3>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li title="Type Formation" data-tippy-placement="top"><i class=""></i> {{$item->secteurActiviter->nomSecteurActiviter}}
                                                    {{--  <div class="verified-badge" title="Verified Employer" data-tippy-placement="top"></div>  --}}
                                                </li>
                                                <li title="Type de Stage" data-tippy-placement="top"><i class=""></i>{{ $item->typeStage }}</li>
                                                <li title="ville Stage" data-tippy-placement="top"><i class="icon-material-outline-location-on"></i> {{ $item->villes->nomVille }}</li>
                                                @if($item->typeDemande=='stage')
                                                <li title="date debut de stage" data-tippy-placement="top"><i class="icon-line-awesome-calendar-check-o"></i> {{ $item->DateDebutStage }} </li>
                                                @endif
                                                <li title="le type de demande" data-tippy-placement="top"><i class="icon-material-outline-settings"></i> {{ $item->typeDemande }} </li>
                                                <li><i class="icon-material-outline-access-time"></i> {{ $datePublie[$key] }}</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Apply Button -->
                                    <span class="list-apply-button ripple-effect">Afficher</span>
                                </div>
                            </a>
                            @endif
                        @empty
                        <a href="#" class="job-listing with-apply-button">

                            <!-- Job Listing Details -->
                            <div class="job-listing-details d-flex justify-content-center">


                                <div>
                                    <center style="font-size: 24pt">No Demande actuellemente</center>
                                </div>

                            </div>
                        </a>
                        
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jobs Container / End -->



    <!-- Features Cities -->
    <div class="section  padding-bottom-65">
        <div class="container">
            <div class="row justify-content-center">

                <!-- Section Headline -->
                <div class="col-xl-12">
                    <div class="section-headline centered margin-top-0 margin-bottom-45">
                        <h3>Offres par ville</h3>
                    </div>
                </div>
                @forelse ($Ville as $key=>$item)

                <div class="col-xl-3 col-md-6">
                    <!-- Photo Box -->
                    <a href={{route('alloffresid', ['op' => 'ville', 'id2' => $item->villes->id]) }} class="photo-box" data-background-image="{{asset( '/storage/'.$item->villes->photoVille) }}">
                        <div class="photo-box-content">
                            <h3 class='text-capitalize'>{{$item->villes->nomVille}}</h3>
                            <span>{{ $countOffresParVille[$key]??0 }}</span>

                        </div>
                    </a>
                </div>
                @empty
                    <center><h1><mark class='color'>No Offres maintenant</mark></h1></center>
                @endforelse


            </div>
        </div>
    </div>
    <!-- Features Cities / End -->


    <!-- Highest Rated Utilisateur -->
    <div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <!-- Section Headline -->
                    <div class="section-headline margin-top-0 margin-bottom-25">
                        <h3>Suggestion Utilisateur</h3>
                        <a href="{{ route('utilisateur') }}" class="headline-link">Afficher tous</a>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="default-slick-carousel freelancers-container freelancers-grid-layout">
                        @forelse ($utilisateur as $key=>$item)
                        <div class="freelancer">

                            <!-- Overview -->
                            <div class="freelancer-overview">
                                <div class="freelancer-overview-inner">
                                    <!-- Avatar -->
                                    <div class="freelancer-avatar">
                                        <a href="single-freelancer-profile.html"><img src={{asset('/storage/'.$item->photo)}} alt="" width='110px' height='110px'></a>
                                    </div>

                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <h4><a href="single-freelancer-profile.html">{{ $item->nomUtilisateur }} {{$item->prenomUtilisateur}}</a></h4>
                                        <span>{{ $item->niveauEtude }}</span>
                                    </div>

                                    <!-- Rating -->
                                    <div class="freelancer-rating">
                                        <div class="star-rating" data-rating={{ $item->nomLevelSite }}></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Details -->
                            <center><div class="freelancer-details">
                                <div class="freelancer-details-list">
                                    <ul>
                                        <li>Location <strong><i class="icon-material-outline-location-on"></i> {{ $item->ville }}</strong></li>
                                    </ul>
                                </div>
                                <a class="button button-sliding-icon ripple-effect" href="{{route('ProfileUser',$item->idUtilisateur) }}">Consulter Profile</a>
                            </div></center>
                        </div>
                        @empty
                            <center><h1><mark class='color'>No Utilisateur</mark></h1></center>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Highest Rated utilisateur / End-->

    <!-- Highest Rated Entreprisse -->
    <div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <!-- Section Headline -->
                    <div class="section-headline margin-top-0 margin-bottom-25">
                        <h3>Suggestion Entreprise</h3>
                        <a href="{{ route('allEntreprise') }}" class="headline-link">Afficher tous</a>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="default-slick-carousel freelancers-container freelancers-grid-layout">
                        @forelse ($entreprise as $key=>$item)
                        <div class="freelancer">

                            <!-- Overview -->
                            <div class="freelancer-overview">
                                <div class="freelancer-overview-inner">
                                    <!-- Avatar -->
                                    <div class="freelancer-avatar">
                                        <a href="{{ route('allEntreprise',['opp'=>'detailsEntreprise','idD'=>$item->idEntreprise]) }}"><img src={{asset('/storage/'.$item->photo)}} alt="" width='110px' height='110px'></a>
                                    </div>

                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <h4><a href="{{ route('allEntreprise',['opp'=>'detailsEntreprise','idD'=>$item->idEntreprise]) }}">{{ $item->nomEntreprise }}</a></h4>
                                        <span>{{ $item->niveauEtude }}</span>
                                    </div>

                                    <!-- Secteur -->
                                    <div title='Secteur activiter' data-tippy-placement="top">
                                        <div>
                                            @forelse ($item->secteurs as $key1=>$item1)
                                                <mark class="color">{{ $item1->nomSecteurActiviter }}</mark>
                                            @empty

                                            @endforelse

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Details -->
                            <center><div class="freelancer-details">
                                <div class="freelancer-details-list">
                                    <ul>
                                        <li>Location <strong><i class="icon-material-outline-location-on"></i> {!! $item->villes->nomVille??"vide" !!}</strong></li>
                                    </ul>
                                </div>
                                <a class="button button-sliding-icon ripple-effect" href="{{ route('allEntreprise',['opp'=>'detailsEntreprise','idD'=>$item->idEntreprise]) }}">Consulter Profile</a>
                            </div></center>
                        </div>
                        @empty
                            <center><h1><mark class='color'>No Entreprise</mark></h1></center>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Highest Rated Entreprisse / End-->

    {{--  <div class="section padding-top-70 padding-bottom-75">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="counters-container">

                        <div class="single-counter">
                            <i class="icon-line-awesome-user"></i>
                            <div class="counter-inner">
                                <h3><span class="counter">{{ $countUtilisateur }}</span></h3>
                                <span class="counter-title">Nombre Utilisateur</span>
                            </div>
                        </div>
                        <!-- Counter -->
                        <div class="single-counter">
                            <i class="icon-line-awesome-suitcase"></i>
                            <div class="counter-inner">
                                <h3><span class="counter">2,543</span></h3>
                                <span class="counter-title">Jobs Posted</span>
                            </div>
                        </div>

                        <!-- Counter -->
                        <div class="single-counter">
                            <i class="icon-line-awesome-legal"></i>
                            <div class="counter-inner">
                                <h3><span class="counter">1,543</span></h3>
                                <span class="counter-title">Tasks Posted</span>
                            </div>
                        </div>

                        <!-- Counter -->


                        <!-- Counter -->
                        <div class="single-counter">
                            <i class="icon-line-awesome-trophy"></i>
                            <div class="counter-inner">
                                <h3><span class="counter">99</span>%</h3>
                                <span class="counter-title">Satisfaction Rate</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>  --}}

@endsection
@section('footer')
@include('layouts.footer')
@endsection
