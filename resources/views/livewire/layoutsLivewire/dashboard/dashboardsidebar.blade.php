<div >
    <!-- Dashboard Sidebar
        ================================================== -->
        <div class="dashboard-sidebar">
            <div class="dashboard-sidebar-inner" >
                <div class="dashboard-nav-container">

                    <!-- Responsive Navigation Trigger -->
                    <a href="#" class="dashboard-responsive-nav-trigger">
                        <span class="hamburger hamburger--collapse" >
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </span>
                        <span class="trigger-title">Dashboard Navigation</span>
                    </a>
                    <!-- Navigation -->
                    <div class="dashboard-nav">
                        <div class="dashboard-nav-inner">

                            <ul data-submenu-title="Start">
                                <li class="{{ $type=='all'?'active':'' }}"><a wire:click='changeType("all")'><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>
                                {{--  <li><a href="dashboard-messages.html"><i class="icon-material-outline-question-answer"></i> Messages <span class="nav-tag">2</span></a></li>  --}}
                                {{--  <li><a href="dashboard-bookmarks.html"><i class="icon-material-outline-star-border"></i> Bookmarks</a></li>  --}}
                                {{--  <li><a href="dashboard-reviews.html"><i class="icon-material-outline-rate-review"></i> Reviews</a></li>  --}}
                            </ul>
                            @if(Auth::guard('web')->check())
                            @if(Auth::user()->roles()->first()->nomRole=='admin')
                            <ul data-submenu-title="Organize and Manage">
                                <li class="{{ $type=='utilisateur'?'active':'' }}"><a><i class="icon-material-outline-person-pin "></i>
                                    Utilisateur</a>
                                    <ul>
                                        <li><a wire:click='changeType("utilisateur","all")'>gestion utilisateur <span class="nav-tag">{{ $count }}</span></a></li>
                                        <li><a wire:click='changeType("role","all")'>gestion des roles <span class="nav-tag">{{ $countRole }}</span></a></li>
                                        </ul>
                                </li>
                                <li class="{{ $type=='entreprise'?'active':'' }}"><a><i class="icon-material-outline-business"></i>
                                    Entreprisse</a>
                                    <ul>
                                        <li><a wire:click='changeType("entreprise","all")'>gestion Entreprisse<span class="nav-tag">{{ $countEn }}</span></a></li>
                                        <li><a wire:click='changeType("secteurActiviter","all")'>gestion secteur<span class="nav-tag">{{ $countSe }}</span></a></li>
                                    </ul>
                                </li>
                                <li class="{{ $type=='offres'?'active':'' }}"><a ><i class="icon-material-outline-local-offer"></i> Offre</a>
                                    <ul>
                                        <li><a wire:click='changeType("offres","all")'>gestion Offre </a></li>
                                        <li><a wire:click='changeType("historiquecandidatures","all")'>Historique Candidature</a></li>

                                    </ul>
                                </li>
                                <li class="{{ $type=='test'?'active':'' }}"><a><i class="icon-material-outline-question-answer"></i>
                                    Test</a>
                                    <ul>
                                        <li><a wire:click='changeType("test","all")'>gestion  des test<span class="nav-tag">{{ $countTest }}</span></a></li>
                                    </ul>
                                </li>



                            </ul>
                            @elseif(Auth::user()->roles()->first()->nomRole=='user')
                            {{--  partie demandes de stage  --}}
                            <ul data-submenu-title="Gerer les demandes">
                                <li class="{{ $type=='demandeStage'?'active':'' }}"><a class="padding-right-20"><i class="icon-feather-git-pull-request"></i>
                                    Demande </a>
                                    <ul>
                                        <li><a wire:click='changeType("demandeStage","all")'>Afficher les demandes<span class="nav-tag">{{ $countDemande }}</span></a></li>
                                        </ul>
                                </li>
                                <li class="{{ $type=='candidatureUser'?'active':'' }}"><a class="padding-right-20"><i class="icon-feather-git-pull-request"></i>
                                    Mes Candidatures</a>
                                    <ul>
                                        <li><a wire:click='changeType("candidatureUser","all")'>Mes candidatures<span class="nav-tag">{{ $countCandidatures }}</span></a></a></li>

                                        </ul>
                                </li>
                            </ul>
                            {{--  partie testCompetence  --}}
                            <ul data-submenu-title="Gerer les testes">
                                <li class="{{ $type=='testUtilisateur'?'active':'' }}"><a class="padding-right-20"><i class="icon-material-outline-question-answer"></i>
                                    Test</a>
                                    <ul>
                                        <li><a wire:click='changeType("testUtilisateur","all")'>Afficher les test
                                        </a></li>
                                        </ul>
                                </li>
                            </ul>
                            @endif
                            @elseif(Auth::guard('entreprise')->check())
                            <ul data-submenu-title="Organize and Manage">
                                <li class="{{ $type=='utilisateur'?'active':'' }}"><a class="padding-right-20"><i class="icon-material-outline-question-answer"></i>
                                    Test</a>
                                    <ul>
                                        <li><a wire:click='changeType("testEntreprise","all")'>Gerer les Test<span class="nav-tag">{{ $countTest }}</span></a></li>
                                        </ul>
                                </li>
                                <li class="{{ $type=='entrepriseoffre'?'active':'' }}"><a class="padding-right-20"><i class="icon-material-outline-local-offer"></i>
                                    Offres</a>
                                    <ul>
                                        <li><a wire:click='changeType("entrepriseoffre","all")'>Offre d'entreprise</a></li>

                                        </ul>
                                </li>

                            </ul>
                            @endif
                            <ul data-submenu-title="Account">
                                <li><a href="{{ route('setting') }}"><i class="icon-material-outline-settings"></i> Settings</a></li>
                                <li><a href="{{ route('logout') }}"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                            </ul>

                        </div>
                    </div>
                    <!-- Navigation / End -->

                </div>
            </div>
        </div>
        <!-- Dashboard Sidebar / End -->
</div>
