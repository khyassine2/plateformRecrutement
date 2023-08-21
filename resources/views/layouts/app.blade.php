<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>UgmeOffre</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<!-- CSS
================================================== -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="shortcut icon" href="{{ asset('images/logoUmge.png') }}" type="image/x-icon">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link rel="stylesheet" href="{{asset('css/colors/blue.css')}}">
@livewireStyles
</head>
<body class='gray'>

<!-- Wrapper -->
<div id="wrapper" class="">

<!-- Header Container
================================================== -->
<header id="header-container" class="fullwidth r">

	<!-- Header -->
	<div id="header">
		<div class="container">

			<!-- Left Side Content -->
			<div class="left-side">

				<!-- Logo -->
				<div id="logo">
					<a href="{{ route('home') }}"><img class='logoUgme' src="{{ asset('images/logoUmge.png') }}" alt=""></a>
				</div>

				<!-- Main Navigation -->
				<nav id="navigation">
					<ul id="responsive" >

						<li><a href="{{ route('home') }}">Home</a>
						</li>

						<li><a href='#'>Pour Utilisateur</a>
							<ul class="dropdown-nav">
                                <li><a href="{{route('alloffres') }}">Les Offres</a></li>
                                <li><a href="{{ route('allEntreprise') }}">Les Entreprise</a></li>

							</ul>
						</li>
						<li><a href="#">Pour Entreprise</a>
							<ul class="dropdown-nav">
								<li><a href="{{ route('utilisateur') }}">chercher un candidats</a>
								</li>
								<li><a href="{{ route('AllDemandeStage') }}">Demandes</a></li>
							</ul>
						</li>
                        <li><a href="{{ route('contact') }}" >Contactez-nous</a>
						</li>

						{{--  <li><a href="#">Dashboard</a>
							<ul class="dropdown-nav">
								<li><a href={{ route('dashboard',['typee'=>'all']) }}>Dashboard</a></li>
								<li><a href="dashboard-messages.html">Messages</a></li>
								<li><a href="dashboard-bookmarks.html">Bookmarks</a></li>
								<li><a href="dashboard-reviews.html">Reviews</a></li>
								<li><a href="dashboard-manage-jobs.html">Jobs</a>
									<ul class="dropdown-nav">
										<li><a href="dashboard-manage-jobs.html">Manage Jobs</a></li>
										<li><a href="dashboard-manage-candidates.html">Manage Candidates</a></li>
										<li><a href="dashboard-post-a-job.html">Post a Job</a></li>
									</ul>
								</li>
								<li><a href="dashboard-manage-tasks.html">Tasks</a>
									<ul class="dropdown-nav">
										<li><a href="dashboard-manage-tasks.html">Manage Tasks</a></li>
										<li><a href="dashboard-manage-bidders.html">Manage Bidders</a></li>
										<li><a href="dashboard-my-active-bids.html">My Active Bids</a></li>
										<li><a href="dashboard-post-a-task.html">Post a Task</a></li>
									</ul>
								</li>
								<li><a href="dashboard-settings.html">Settings</a></li>
							</ul>
						</li>  --}}
                        @if(!Auth::guard('web')->check() && !Auth::guard('entreprise')->check())
                        <li><a href="#">login</a>
                            <ul class="dropdown-nav">
                                <li><a href="{{route('Authentification',['op'=>'login'])}}">login</a></li>
                                <li><a href="{{route('Authentification',['op'=>'register'])}}">Register</a></li>
                            </ul>
                        </li>
                        @endif
					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->

			</div>
			<!-- Left Side Content / End -->


			<!-- Right Side Content / End -->
			<div class="right-side">


				<!-- User Menu -->
                @if(Auth::guard('entreprise')->check() || Auth::guard('web')->check())
                <div class="header-widget">
					<!-- Messages -->
					<div class="header-notifications user-menu">
						<div class="header-notifications-trigger">
							<a href="#"><div class="user-avatar status-online">
                                @if(Auth::guard('web')->check())
                                <img  src="{{asset('/storage/'.Auth::guard('web')->user()->photo) }}" width='42px' height='42px'>
                                @elseif(Auth::guard('entreprise')->check())
                                <img src="{{ asset('/storage/'.Auth::guard('entreprise')->user()->photo) }}" width='42px' height='42px'>
                                @endif
                            </div></a>
						</div>

						<!-- Dropdown -->
						<div class="header-notifications-dropdown">

							<!-- User Status -->
							<div class="user-status">

								<!-- User Name / Avatar -->
								<div class="user-details">
									<div class="user-avatar status-online">
                                        @if(Auth::guard('web')->check())
                                        <img  src="{{ asset('/storage/'.Auth::guard('web')->user()->photo) }}" width='42px' height='42px'>
                                        @elseif(Auth::guard('entreprise')->check())
                                        <img src="{{ asset('/storage/'.Auth::guard('entreprise')->user()->photo) }}" width='42px' height='42px'>
                                        @endif
                                       </div>
									<div class="user-name">
                                        @if(Auth::guard('entreprise')->check())
                                        {!! Auth::guard('entreprise')->user()->nomEntreprise.' <span> Entreprise</span>' !!}
                                        @elseif(Auth::guard('web')->user()->roles->nomRole=='admin')
                                       {!! Auth::guard('web')->user()->nomUtilisateur.' '.Auth::guard('web')->user()->prenomUtilisateur.' <span> Admin</span>'!!}
                                        @else
                                        {!! Auth::guard('web')->user()->nomUtilisateur.' '.Auth::guard('web')->user()->prenomUtilisateur.' <span> Utilisateur</span>' !!}
                                        @endif
										
									</div>
								</div>

						</div>

						<ul class="user-menu-small-nav">
							<li><a href={{ route('dashboard')  }}><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>
							<li><a href="{{ route('setting') }}"><i class="icon-material-outline-settings"></i> Settings</a></li>
							<li><a href="{{ route('logout') }}"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
						</ul>

						</div>
					</div>

				</div>
                @endif

				<!-- Mobile Navigation Button -->
				<span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->

{{--  contenu  --}}
@yield('content')
{{--  end contenu  --}}


{{--  footer  --}}
@yield('footer')
{{--  endFotter  --}}
</div>
<!-- Wrapper / End -->


<!-- Scripts
================================================== -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/mmenu.min.js') }}"></script>
<script src="{{ asset('js/tippy.all.min.js') }}"></script>
{{--  <script src="{{ asset('js/simplebar.min.js') }}"></script>  --}}
<script src="{{ asset('js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/snackbar.js') }}"></script>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="{{ asset('js/counterup.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script data-cfasync="false" src="{{ asset('../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script><script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Snackbar   -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
// Snackbar for user status switcher
$('#snackbar-user-status label').click(function() {
	Snackbar.show({
		text: 'Your status has been changed!',
		pos: 'bottom-center',
		showAction: false,
		actionText: "Dismiss",
		duration: 3000,
		textColor: '#fff',
		backgroundColor: '#383838'
	});
});
const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    showCloseButton: true,
    timer: 5000,
    timerProgressBar:true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.addEventListener('alert',({detail:{type,message}})=>{
    Toast.fire({
        icon:type,
        title:message
    })
})

window.addEventListener('Modal',({detail:{type,message,text,color}})=>{

    Swal.fire({
        title: message,
        text: text,
        icon: type,
        showCancelButton: false,
        showConfirmButton: false
      })
})

</script>
@stack('scripts')

<!-- Google Autocomplete -->
<script>
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)'],
		  // componentRestrictions: {country: "us"}
		 };

		 var input = document.getElementById('autocomplete-input');
		 var autocomplete = new google.maps.places.Autocomplete(input, options);
	}

	// Autocomplete adjustment for homepage
	if ($('.intro-banner-search-form')[0]) {
	    setTimeout(function(){
	        $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
	    }, 300);
	}

</script>

<!-- Google API -->
{{--  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaoOT9ioUE4SA8h-anaFyU4K63a7H-7bc&amp;libraries=places&amp;callback=initAutocomplete"></script>  --}}
<!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
	Chart.defaults.global.defaultFontFamily = "Nunito";
	Chart.defaults.global.defaultFontColor = '#888';
	Chart.defaults.global.defaultFontSize = '14';

	var ctx = document.getElementById('chart').getContext('2d');

	var chart = new Chart(ctx, {
		type: 'line',

		// The data for our dataset
		data: {
			labels: ["January", "February", "March", "April", "May", "June"],
			// Information about the dataset
	   		datasets: [{
				label: "Views",
				backgroundColor: 'rgba(42,65,232,0.08)',
				borderColor: '#00e2bd',
				borderWidth: "3",
				data: [196,132,215,362,210,252],
				pointRadius: 5,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			}]
		},

		// Configuration options
		options: {

		    layout: {
		      padding: 10,
		  	},

			legend: { display: false },
			title:  { display: false },

			scales: {
				yAxes: [{
					scaleLabel: {
						display: false
					},
					gridLines: {
						 borderDash: [6, 10],
						 color: "#d8d8d8",
						 lineWidth: 1,
	            	},
				}],
				xAxes: [{
					scaleLabel: { display: false },
					gridLines:  { display: false },
				}],
			},

		    tooltips: {
		      backgroundColor: '#333',
		      titleFontSize: 13,
		      titleFontColor: '#fff',
		      bodyFontColor: '#fff',
		      bodyFontSize: 13,
		      displayColors: false,
		      xPadding: 10,
		      yPadding: 10,
		      intersect: false
		    }
		},


});

</script>
@livewireScripts
</body>
</html>
