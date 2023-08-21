@extends('layouts.app')

@section('content')
<!-- Titlebar
    ================================================== -->
<div class="single-page-header freelancer-header" data-background-image={{asset('/storage/'.$user->photo)}}>
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image freelancer-avatar"><img src={{asset('/storage/'.$user->photo)}} alt="" width='140px' height='140px' ></div>
                            <div class="header-details">
                                <h3>{{ $user->nomUtilisateur.' '.$user->prenomUtilisateur }} <span>{{ $user->donners->niveauEtude }}</span></h3>
                                <ul>
                                    <li><div class="star-rating" data-rating="{{ $user->levelSite->nomLevelSite }}"></div></li>
                                    <li><i class="icon-material-outline-location-on"></i> {{ $user->ville }}</strong></li>
                                    <li><strong><i class="icon-feather-phone"></i></strong>
                                        @if(Auth::guard('entreprise')->check() || Auth::guard('web')->user()->idUtilisateur==$user->idUtilisateur)
                                            {{$user->telephone}}
                                        @else
                                            {{ Str::limit($user->telephone,3) }}
                                        @endif
                                        </li>
                                    <li><strong><i class="icon-feather-mail"></i></strong>
                                        @if(Auth::guard('entreprise')->check() || Auth::guard('web')->user()->idUtilisateur==$user->idUtilisateur)
                                        {{  $user->email }}
                                        @else
                                            {{ Str::limit($user->email,3) }}
                                        @endif
                                    </li>
                                    <li>{{ $age }}Ans</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Page Content
    ================================================== -->
    <div class="container ">
        <div class="row">
            <!-- Content -->
            <div class="col-xl-12 col-lg-12 content-right-offset margin-bottom-30">

                <!-- Page Content -->
                <div class="single-page-section margin-bottom-0">
                    <h3 class=""><strong>Experiance</strong> :{{ $user->donners->experiances }}</h3>
                </div>
                <div class="single-page-section margin-bottom-0">
                    <h3 class=""><strong>Competences</strong> : {{ $user->donners->competences }}</h3>
                </div>
                <div class="single-page-section margin-bottom-0">
                    <h3 class=""><strong>Niveau d etudes </strong> : {{ $user->donners->niveauEtude }}</h3>
                </div>

            </div>
           @if(Auth::guard('entreprise')->check())
                <div class='d-flex justify-content-center'>
                <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim ">Envoyer Email<i class="icon-material-outline-arrow-forward"></i></a>
                </div>
           @endif
            {{--  popup email  --}}
            <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

                <!--Tabs -->
                <div class="sign-in-form">

                    <ul class="popup-tabs-nav">
                        <li><a href="#tab">Email</a></li>
                    </ul>

                    <div class="popup-tabs-container">

                        <!-- Tab -->
                        <div class="popup-tab-content" id="tab">

                            <!-- Welcome Text -->
                            <div class="welcome-text">
                                <h3>Envoyer Un Email </h3>
                            </div>

                            <!-- Form -->
                            <form action="{{route('envoyerEmail')}}" method="post">
                                @csrf
                                <div class="">
                                    <input type="text" name='object' placeholder="Entrez l'object de email">
                                </div>
                                <input type="hidden" value="{{ $user->idUtilisateur }}" name='id' >
                                <div class="">
                                    <textarea cols="30" rows="5" class="with-border" name='msg' placeholder="Entrez le contenue de email"></textarea>
                                </div>

                            <!-- Button -->
                            <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit">Envoyer Email <i class="icon-feather-mail"></i></button>
                        </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
            <div class="container">
                <div class="row">

                    <div class="col-xl-12">
                        <!-- Section Headline -->
                        <div class="section-headline margin-top-0 margin-bottom-25">
                            <h3>Suggestion</h3>
                            <a href="{{ route('utilisateur') }}" class="headline-link">Afficher tous</a>
                        </div>
                    </div>

                    <div class="col-xl-12" >
                        <div class="default-slick-carousel freelancers-container freelancers-grid-layout" >
                            @forelse ($utilisateur as $key=>$item)
                            <div class="freelancer">

                                <!-- Overview -->
                                <div class="freelancer-overview">
                                    <div class="freelancer-overview-inner">
                                        <!-- Avatar -->
                                        <div class="freelancer-avatar">
                                            <a href="{{route('ProfileUser',$item->idUtilisateur) }}"><img src={{asset('/storage/'.$item->photo)}} alt="" width='110px' height='110px'></a>
                                        </div>

                                        <!-- Name -->
                                        <div class="freelancer-name">
                                            <h4><a href="{{route('ProfileUser',$item->idUtilisateur) }}">{{ $item->nomUtilisateur }} {{$item->prenomUtilisateur}}</a></h4>
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

                            @endforelse

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer')
@include('layouts.footer')
@endsection


