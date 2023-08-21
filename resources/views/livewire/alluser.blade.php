<div style='width: 96% !important'>
	<div class="row">
		<div class="col-xl-3 col-lg-4">
			<div class="sidebar-container margin-top-30 margin-left-15">
                <div class="sidebar-widget">
                    <h3>Ville</h3>
                    <div class="input-with-icon">
                        <div id="autocomplete-container">
                            <select wire:model='villeSearch'>
                                <option value="">Choisissez la ville</option>
                                @forelse ($villes as $item)
                                    <option value="{{ $item->nomVille }}">{{ $item->nomVille }}</option>
                                @empty
                                    <option value="">No ville</option>
                                @endforelse
                            </select>
                        </div>
                        <i class="icon-material-outline-location-on"></i>
                    </div>
                </div>
				

				<!-- niveau Etude -->
				<div class="sidebar-widget">
                    <h3>Niveau Etudes</h3>
                    <select wire:model='niveauEtude'>
                        <option value="">Choisissez Niveau d'etude</option>'
                        <option value="Bac">Bac</option>
                        <option value="Bac+1">Bac+1</option>
                        <option value="Bac+2">Bac+2</option>
                        <option value="Bac+3">Bac+3</option>
                        <option value="Bac+4">Bac+4</option>
                        <option value="Bac+5">Bac+5</option>
                        <option value="Plus de Bac+5">Plus de Bac+5</option>
                        <option value="Niveau Bac">Niveau Bac</option>
                        <option value="CQP">CQP</option>
                    </select>
                </div>
				<div class="clearfix"></div>

			</div>
		</div>
		<div class="col-xl-9 col-lg-8 content-left-offset padding-top-35 ">

			<h3 class="page-title">Recherche Results</h3>
			<!-- Freelancers List Container -->
			<div class="freelancers-container freelancers-grid-layout margin-top-35">
				
				<!--Freelancer -->
                @forelse ($users as $key=>$item)
                <div class="freelancer">

					<!-- Overview -->
					<div class="freelancer-overview">
						<div class="freelancer-overview-inner">
							<!-- Avatar -->
							<div class="freelancer-avatar">
								<a href="single-freelancer-profile.html"><img src={{asset('/storage/'.$item->photo)}} alt="" width='100px' height='100px'></a>
							</div>

							<!-- Name -->
							<div class="freelancer-name">
								<h4><a>{{ $item->nomUtilisateur.' '.$item->prenomUtilisateur }} </a></h4>
								<span>{{ $item->donners->niveauEtude }}</span>
								<!-- Rating -->
								<div class="freelancer-rating" >
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($item->nomLevelSite >= $i)
                                                <i class="icon-line-awesome-star" style="color: #febe42 !important;font-size: 22px !important"></i>
                                            @elseif($item->nomLevelSite >= $i - 0.5)
                                                <i class="icon-line-awesome-star-half-o" style="color: #febe42 !important;font-size: 22px !important"></i>
                                            @else
                                                <i class="icon-line-awesome-star-o" style="color: #febe42 !important;font-size: 22px !important"></i>
                                            @endif
                                        @endfor
                                    </div>
								</div>
							</div>
						</div>
					</div>
					<!-- Details -->
					<div class="freelancer-details">
						<div class="freelancer-details-list">
							<ul>
								<center>
                                    <li>Location<strong><i class="icon-material-outline-location-on"></i> {{ $item->ville }}</strong></li>
                                    <li></li>
                                    <li></li>
                                    <li>Age<strong>{{ $ages[$key] }}Ans</strong></li>
                                </center>
                                
							</ul>
						</div>
						<a href="{{ route('ProfileUser',$item->idUtilisateur) }}" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
					</div>
                    
				</div>
                @empty
                     <center class='d-flex justify-content-center col-12'>
                            <div class="freelancer">
                                <mark class='color'>No Candidats</mark>
                            </div>
                        </center>
                @endforelse
				<!-- Freelancer / End -->

	
			</div>
			<!-- Tasks Container / End -->


			<!-- Pagination -->
			<div class="clearfix"></div>
            {{$users->links('livewire.layoutsLivewire.pagination')}}
			<!-- Pagination / End -->

		  <!-- Footer -->
            @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->
		</div>
	</div>
	  
</div>
