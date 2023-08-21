@extends('layouts.app')

@section('content')
<div class="container margin-top-100">
	<div class="row">

		<div class="col-xl-12">
			<div class="contact-location-info margin-bottom-50">
				<div class="contact-address">
					<ul>
						<li class="contact-address-headline">Union Général des Micro Entreprises</li>
						<li class='text-uppercase'>21 lot farah pol urbane bnsouda</li>
						<li>Phone (+212)619077717 | (+212)532052239</li>
						<li>Email
						<a  href="https://mail.google.com/mail/?view=cm&to=hafidmaktoub@gmail.com"><span > hafidmaktoub@gmail.com</span></a>
						<a  href="https://mail.google.com/mail/?view=cm&to=ugme777@gmail.com" class='margin-left-50'><span > ugme777@gmail.com</span></a>
						</li>

						<li>
							<div class="freelancer-socials">
								<ul>
									<li><a href="https://web.facebook.com/profile.php?id=100064098552288" title="Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
									<li><a href="http://www.ugme.org/" title="site web" data-tippy-placement="top"><i class="icon-material-outline-language"></i></a></li>
								</ul>
							</div>
						</li>
					</ul>

				</div>
				<div id="single-job-map-container">
					<div class="google_map_area">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="google_map_area">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2100.6538232326343!2d-5.05332387773946!3d33.99991062423146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd9f8a795d62dc0b%3A0x5399212de785bfd0!2sHay%20Massira%2C%20F%C3%A8s!5e0!3m2!1sfr!2sma!4v1681822544119!5m2!1sfr!2sma" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>	
								</div>
							</div>				
						</div>
					</div>
					<a href="#" id="streetView">Ugme View</a>
				</div>
			</div>
			
		</div>
	</div>
    <div align='right'>
        developper par <a class='text-dark'  href="https://mail.google.com/mail/?view=cm&to=elkhadraouiyassine@gmail.com" title="send message" data-tippy-placement="top">El-khadraoui yassine</a> && <a class='text-dark' href="https://mail.google.com/mail/?view=cm&to=Ismail20020129@gmail.com" data-tippy-placement="top" title="send message">Ismail Atif</a>
    </div>
</div>

@endsection
@section('footer')
@include('layouts.footer')
@endsection

