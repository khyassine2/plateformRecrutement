<div  wire:ignore.self>
<!-- Dashboard Container -->
<div class="dashboard-container ">
@livewire('layoutslivewire.dashboard.dashboardsidebar')
    @if(session('typee')=='' || session('typee')=='all')
        <div class="dashboard-content-container padding-left-30">
        <div class="dashboard-content-inner" >
            <!-- Dashboard Headline -->
            <div class="dashboard-headline">
                <h3>
                    @if(Auth::guard('web')->check())
                        {{ Auth::guard('web')->user()->nomUtilisateur.' '.Auth::guard('web')->user()->prenomUtilisateur }} !!
                    @elseif(Auth::guard('entreprise')->check())
                    {{ Auth::guard('entreprise')->user()->nomEntreprise  }}!!
                    @endif
                </h3>
                <span>Nous sommes heureuses de vous revoir!</span>

                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>Dashboard</li>
                    </ul>
                </nav>
            </div>
            <!-- Fun Facts Container -->
            <div class="fun-facts-container">
                @if(Auth::guard('web')->check())
                @if(Auth::guard('web')->user()->roles->nomRole=='admin')
                    {{--  admin  --}}
                    <div class="fun-fact">
                        <div class="fun-fact-text">
                            <span>Nombre Utilisateur</span>
                            <h4>{{ $count }}</h4>
                        </div>
                        <div class="fun-fact-icon"  style="background-color: #68ffb144"><i class="icon-feather-user"  style="color: #36bd78"></i></div>
                    </div>
                    <div class="fun-fact">
                        <div class="fun-fact-text">
                            <span>Nombre d'entreprise</span>
                            <h4>{{ $countEntreprise }}</h4>
                        </div>
                        <div class="fun-fact-icon"  style="background-color:  #ef3a2d23"><i class="icon-material-outline-business"  style="color:  #ef3a2df9"></i></div>
                    </div>
                    <div class="fun-fact">
                        <div class="fun-fact-text">
                            <span>Nombre Offres</span>
                            <h4>{{ $countOffre }}</h4>
                        </div>
                        <div class="fun-fact-icon"  style="background-color: #f179c558"><i class="icon-material-outline-business-center" style="color: #b81b7f"></i></div>
                    </div>
                    <div class="fun-fact">
                        <div class="fun-fact-text">
                            <span>Nombre des Test</span>
                            <h4>{{ $countTest }}</h4>
                        </div>
                        <div class="fun-fact-icon"  style="background-color: #f1bd783c"><i class="icon-material-outline-question-answer" style="color: #f1bd78"></i></div>
                    </div>
                @elseif (Auth::guard('web')->user()->roles->nomRole=='user')
                {{--  utilisateur  --}}
                    <div class="fun-fact">
                        <div class="fun-fact-text">
                            <span>Test Passer</span>
                            <h4>{{ $countTest }}</h4>
                        </div>
                        <div class="fun-fact-icon"  style="background-color: #68ffb144"><i class="icon-material-outline-question-answer"  style="color: #36bd78"></i></div>
                    </div>
                    <div class="fun-fact">
                        <div class="fun-fact-text">
                            <span>Offres Postuler</span>
                            <h4>{{ $countOffre }}</h4>
                        </div>
                        <div class="fun-fact-icon"  style="background-color: #f179c558"><i class="icon-material-outline-business-center" style="color: #b81b7f"></i></div>
                    </div>
                     <div class="fun-fact" >
                    <div class="fun-fact-text">
                        <span>Vues de ce mois-ci</span>
                        <h4>{{ $viewParMois }}</h4>
                    </div>
                    <div class="fun-fact-icon" style="background-color: #7281f553"><i class="icon-feather-trending-up" style="color: #2a41e6"></i></div>
                    </div>
                @endif
                @endif
                @if(Auth::guard('entreprise')->check())
                    {{--  entrepirse  --}}
                <div class="fun-fact">
                    <div class="fun-fact-text">
                        <span>Test Publie</span>
                        <h4>{{ $countTest }}</h4>
                    </div>
                    <div class="fun-fact-icon"  style="background-color: #68ffb144"><i class="icon-material-outline-question-answer"  style="color: #36bd78"></i></div>
                </div>
                <div class="fun-fact">
                    <div class="fun-fact-text">
                        <span>Offres Publie</span>
                        <h4>{{ $countOffre }}</h4>
                    </div>
                    <div class="fun-fact-icon"  style="background-color: #f179c558"><i class="icon-material-outline-business-center" style="color: #b81b7f"></i></div>
                </div>
                <div class="fun-fact" >
                    <div class="fun-fact-text">
                        <span>Vues de ce mois-ci</span>
                        <h4>{{ $viewParMois }}</h4>
                    </div>
                    <div class="fun-fact-icon" style="background-color: #7281f553"><i class="icon-feather-trending-up" style="color: #2a41e6"></i></div>
                </div>
                @endif
            </div>
            <!-- Row -->
            <div class="row">

                @if(Auth::guard('web')->check())
                    @if (Auth::guard('web')->user()->roles->nomRole=='user')
                        <div class="col-xl-12">
                            <!-- Dashboard Box -->
                            <div class="dashboard-box main-box-in-row">
                                <div class="headline">
                                    <h3><i class="icon-feather-bar-chart-2"></i> Profile visite: <span class="nav-tag status-online">{{ count($visiteCompte) }}</span>
                                    </h3>
                                </div>
                                <div class="content margin-left-20 margin-top-20 padding-bottom-20">
                                    @forelse ($visiteCompte as $key=>$item)
                                        @if($item->type_connecteCompteId==1)
                                            {{--  utilisateur  --}}
                                            @if($item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->roles->nomRole=='admin')
                                            <a href="#">
                                            <img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo) }}" width="60px" height='60px' style='border-radius: 50% !important;' title="{{ $item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->nomUtilisateur.' '.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->prenomUtilisateur }} Admin"  >
                                            </a>
                                            @elseif($key<=1)
                                            <a href="{{ route('ProfileUser',$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->idUtilisateur) }}">
                                            <img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo) }}" width="60px" height='60px' style='border-radius: 50% !important;' title="{{ $item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->nomUtilisateur.' '.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->prenomUtilisateur }} Utilisateur"  >
                                            </a>
                                            <!--@elseif($key>3)-->
                                            <!--<img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo) }}" width="60px" height='60px' style='border-radius: 50% !important;filter: blur(0.8px)' title="vous n'avez pas accees de visite">-->
                                            
                                            @endif
                                        @elseif($item->type_connecteCompteId==2)
                                                {{--  entreprise  --}}
                                            <!--@if($key<=2)-->
                                                <a href="{{ route('allEntreprise',['opp'=>'detailsEntreprise','idD'=>$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->idEntreprise]) }}">
                                                <img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo) }}" width="60px" height='60px' style='border-radius: 50% !important;' title="{{ $item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->nomEntreprise}} Entrepirse">
                                                </a>
                                            <!--    @elseif($key>3)-->
                                            <!--    <img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo) }}" width="60px" height='60px' style='border-radius: 50% !important;filter: blur(0.8px)' title="vous n'avez pas accees de visite">-->
                                            <!--@endif-->
                                        @endif
                                        @empty
                                        <center class='d-flex justify-content-center col-12'>
                                            <div class="freelancer">
                                                <mark class='color'>No Personne consulter votre profil</mark>
                                            </div>
                                        </center>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                @endif
                @elseif(Auth::guard('entreprise')->check())
                <div class="col-xl-12">
                    <!-- Dashboard Box -->
                    <div class="dashboard-box main-box-in-row">
                        <div class="headline">
                            <h3><i class="icon-feather-bar-chart-2"></i> Profile visite:
                            <span class="nav-tag status-online">{{ count($visiteCompte) }}</span></h3>
                        </div>
                        <div class="content margin-left-20 margin-top-20 padding-bottom-20">
                            @forelse ($visiteCompte as $key=>$item)
                                @if($item->type_connecteCompteId==1)
                                    {{--  utilisateur  --}}
                                    @if($key<=1)
                                    <a href="{{ route('ProfileUser',$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->idUtilisateur) }}">
                                    <img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo) }}" width="60px" height='60px' style='border-radius: 50% !important;' title="{{ $item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->nomUtilisateur.' '.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->prenomUtilisateur }} Utilisateur">
                                    </a>
                                    @elseif($key>1)
                                    <img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo) }}" width="60px" height='60px' style='border-radius: 50% !important;filter: blur(0.8px)' title="vous n'avez pas accees de visite">
                                    @endif
                                @elseif($item->type_connecteCompteId==2)
                                        {{--  entreprise  --}}
                                    @if($key<=1)
                                        <a href="{{ route('allEntreprise',['opp'=>'detailsEntreprise','idD'=>$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->idEntreprise]) }}">
                                        <img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo)}}" width="60px" height='60px' style='border-radius: 50% !important;' title="{{ $item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->nomEntreprise}} Entrepirse">
                                        </a>
                                        @elseif($key>1)
                                        <img src="{{asset('/storage/'.$item->visiteComptes($visiteCompte[$key]->type_connecteCompteId,$visiteCompte[$key]->connectecompteid)->photo) }}" width="60px" height='60px' style='border-radius: 50% !important;filter: blur(0.8px)' title="vous n'avez pas accees de visite">
                                    @endif
                                @endif
                                @empty
                                <center>
                                <h1> <mark>no personne consulter votre profil</mark></h1>
                                </center>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <!-- Row / End -->

            <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
            <!-- Footer / End -->

        </div>
        </div>
    @elseif(session('typee')=='utilisateur')
        @livewire('admin.utilisateur')
    @elseif(session('typee')=='entreprise')
        @livewire('admin.entreprisses')
    @elseif(session('typee')=='role')
        @livewire('admin.role')
    @elseif(session('typee')=='secteurActiviter')
        @livewire('admin.secteuractiviter')
    @elseif(session('typee')=='test')
        @livewire('admin.testcompetence')
    @elseif(session('typee')=='testEntreprise')
        @livewire('entreprise.testcompetence')
    @elseif(session('typee')=='demandeStage')
        @livewire('utilisateur.demande-stage')
    @elseif(session('typee')=='testUtilisateur')
        @livewire('utilisateur.test')
    {{--  /* partie ISmail */  --}}
    @elseif(session('typee')=='offres')
    @livewire('admin.offres')
    @elseif(session('typee')=='historiquecandidatures')
        @livewire("admin.historiquecandidatures")
    @elseif(session('typee')=='candidatureUser')
        @livewire('utilisateur.candidatureuser')
    @elseif(session('typee')=='entrepriseoffre')
        @livewire('entreprise.entrepriseoffre')
    @endif
</div>

</div>








