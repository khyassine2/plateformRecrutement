<div class="dashboard-content-container" >
    <div class="dashboard-content-inner" >
        <!-- Dashboard Headline -->
        <div class="dashboard-headline">
            <h3>Manage les tests</h3>
        </div>

        @if(session('opTestEn')=='all' || session('opTestEn')=='')
            <a wire:click='change("ajouteTest")' class="button ripple-effect button-sliding-icon text-muted" align='right'>Ajouter un Test<i class="icon-feather-edit"></i></a>
            <a wire:click='change("ajouteQuestion")' class="button ripple-effect button-sliding-icon" align='right'>Ajouter les Questions<i class="icon-material-outline-question-answer"></i></a>
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="headline d-flex justify-content-between col-12">
                            <h3><i class="icon-material-outline-question-answer"></i> {{ count(Auth::guard('entreprise')->user()->tests) }} Test</h3>
                            {{--  <div class='d-flex justify-content-between'>
                                <select wire:model='select' class="with-border">
                                    <option value="nomEntreprise">Par Nom</option>
                                    <option value="adresseEntreprise">Par adresse</option>
                                    <option value="emailEntreprise">Par email</option>
                                    <option value="villeEntreprise">Par ville</option>
                                    <option value="secteurActiviter">Par Secteur</option>
                                </select>
                                @if($select!='secteurActiviter')
                                <input type="text" class="with-border" wire:model.debounce.100ms='search'>
                                @elseif($select=='secteurActiviter')
                                    <select wire:model='searchSecteur' class="with-border">
                                        {!! $searchSecteur==null?'<option value="">choisser le secteur</option>':'' !!}
                                        @foreach ($secteurActiviter as $item)
                                            <option value="{{ $item->idSecteurActiviter }}">{{ $item->nomSecteurActiviter }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>  --}}




                        </div>
                {{--  <a  class='button gray ripple-effect ico'  title="Ajouter Utilisateur" data-tippy-placement="top"><i class="icon-feather-user-plus" wire:click='change("ajoute")'></i></a>  --}}
                        <div class="content">
                            <ul class="dashboard-box-list">
                                <li>
                                    <!-- Overview -->
                                    @forelse ($test as $item)
                                    <div class="freelancer-overview manage-candidates">
                                        <div class="freelancer-overview-inner">
                                            {{--  {{ dd($test) }}  --}}
                                            <!-- Avatar -->
                                            {{--  <div class="freelancer-avatar ia">
                                                <a ><img src={{asset('/storage/'.$item->photo)}} alt="" height='76px' width='76px'></a>
                                            </div>  --}}

                                            <!-- Name -->
                                            <div class="freelancer-name">
                                                <h4><a href="#">{{ $item->titreTest}}</a></h4>
                                                <span class="freelancer-detail-item"><i class="icon-material-outline-description"></i>  {{$item->descriptionTest}}</span>
                                                <span class="freelancer-detail-item"><i class="icon-material-outline-access-time"></i>  {{$item->duree}} min</span>
                                                {{--  @if($item->type=='entreprise')  --}}
                                                    <span class="freelancer-detail-item"><i class="icon-material-outline-business"></i>  {{$item->entreprise()->first()->nomEntreprise}}</span>
                                                    <span class="freelancer-detail-item"><i class="icon-feather-activity"></i>  {{$item->secteur()->first()->nomSecteurActiviter}}</span>

                                                {{--  @endif  --}}
                                                <!-- Buttons -->
                                                <div class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
                                                    <button wire:click="change('details',{{$item->idTest}})" class="button gray ripple-effect ico"  title="details test" data-tippy-placement="top"><i class="icon-feather-eye"></i></button>
                                                    <button wire:click="edit({{$item->idTest}})" class="button gray ripple-effect ico" title="modifier test" data-tippy-placement="top"><i class="icon-feather-edit"></i></button>
                                                    <button wire:click="change('delete',{{$item->idTest}})" class="button gray ripple-effect ico"  title="supprimer test" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></button><br>
                                                    <button type='button' wire:click="afficherResultatTest({{ $item->idTest }})" class="button ripple-effect marginto margin-top-20"><i class="icon-feather-eye"></i>Afficher Resultat de test</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                        <center class='d-flex justify-content-center col-12'>
                                                <div class="freelancer">
                                                    <mark class='color'>No Entreprise</mark>
                                                </div>
                                        </center>
                                    @endforelse
                                </li>
                                {{ $test->links('livewire.layoutsLivewire.pagination') }}
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            @elseif(session('opTestEn')=='details')
            <div class="d-flex dd">
                <div class="col-xl-6">
                <div class="dashboard-box margin-top-0">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-feather-eye"></i> details test Competence</h3>
                </div>

                <div class="content padding-top-40 padding-bottom-10">
                    <div class="d-flex">
                        <div class="content">
                            <div class="col-xl-12">
                                    <div >
                                        <div class="row">
                                            <form method='post' wire:submit.prevent='ajouterTest'>
                                            <div class="col-xl-12">
                                                <div class="submit-field">
                                                    <h5>titre</h5>
                                                    <input type="text" class="with-border" wire:model='titre' disabled>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="submit-field">
                                                    <h5>Duree <span>(minute)</span></h5>
                                                    <input type="text" class="with-border" wire:model='duree' disabled>
                                                </div>
                                            </div>
                                                <div class="col-xl-12">
                                                    <div class="submit-field">
                                                        <h5>Entreprise</h5>
                                                        <input type="text" class="with-border" wire:model='identreprise' disabled>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="submit-field">
                                                        <h5>secteur
                                                    </h5>
                                                    <input type="text" class="with-border" wire:model='idsecteur' disabled>

                                                    </div>
                                                </div>
                                            <div class="col-xl-12">
                                                <div class="submit-field">
                                                    <h5>test Description</h5>
                                                    <textarea cols="30" rows="5" class="with-border" wire:model='description' disabled></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                            </div>
                        </div>


                    </div>
                </div>

            </div>
            </div>
            <div class="col-xl-6 dd1">
                <div class="dashboard-box margin-top-0">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-feather-eye"></i> details question de test</h3>
                    </div>

                    <div class="content with-padding padding-bottom-10">
                        <div class="d-flex">
                            <div class="content">
                                <div class="numbered color">
                                    <ol>
                                        @forelse ($question as $item)
                                            <li>{{ $item->enonce }}</li>
                                            @forelse ($item->choix()->get() as $item1)
                                                <ul class="numbered">
                                                    <li >{!! $item1->isCorrect==1?"<mark class='color'><i class='icon-material-outline-arrow-forward'></i>$item1->enonce</mark>":"<i class='icon-material-outline-arrow-forward'></i>$item1->enonce" !!}</li>
                                                </ul>
                                            @empty
                                                <ul class="numbered">
                                                    <li ><mark> no choix</mark></li>
                                                </ul>
                                            @endforelse
                                        @empty
                                            <li><mark>no question</mark></li>
                                        @endforelse
                                        {{--  <li>Praesent in libero vel pellentesque</li>
                                        <li>Proin fermentum eratin eget porttitor</li>
                                        <li>Maecenas quis consequat libero</li>
                                        <li>Nunc orci augue consequat</li>
                                        <li>Praesent in libero vel pellentesque</li>
                                        <li>Proin fermentum eratin eget porttitor</li>  --}}
                                    </ol>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
            </div>
            <center>
                <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4 margin-left-100">
                    <button type='button' wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                    {{--  <button wire:click.prevent='charger()' class='button dark ripple-effect button-sliding-icon'>modifier<i class='icon-feather-edit'></i></button>  --}}
                    </div>
            </center>
        @elseif(session('opTestEn')=='delete')
            <center>
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <div class="headline d-flex justify-content-between">
                            <h3><i class="icon-material-outline-question-answer"></i> supprimer Test</h3>
                        </div>
                           <center>
                            <div class="content margin-top-20">
                                Vous avez sur de supprimer le test <mark> {{ $titre2 }}</mark>  : <br>
                                    <button wire:click='change("all")' type="button" class="button ripple-effect button-sliding-icon margin-top-20 margin-bottom-20"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                    <button wire:click='deleteTest' class="button ripple-effect button-sliding-icon margin-top-20 margin-bottom-20">supprimer<i class="icon-feather-check"></i></button>

                                </div>
                           </center>
                    </div>
                    </div>
            </center>
        @elseif(session('opTestEn')=='ajouteTest')
            <div class="col-xl-12" >
                <div class="dashboard-box margin-top-0">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-feather-folder-plus"></i> Ajouter test Competence</h3>
                    </div>
                    <form action="post" wire:submit.prevent='ajouterTest'>
                    <div class="content with-padding padding-bottom-10">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>titre</h5>
                                    <input type="text" class="with-border" wire:model='titre' placeholder="entrez le titre de test">
                                    @error('titre')
                                    <span class="text-danger">{{$message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Duree <span>(minute)</span></h5>
                                    <input type="text" class="with-border" wire:model='duree' placeholder="entrez la duree de test">
                                    @error('duree')
                                    <span class="text-danger">{{$message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Secteur Activiter de test</h5>
                                    <select wire:model='idsecteur'>
                                        @forelse (Auth::guard('entreprise')->user()->secteurs as $item)
                                            <option value={{ $item->idSecteurActiviter }}>{{ $item->nomSecteurActiviter }}</option>
                                        @empty
                                            <option >no secteur</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Test Description</h5>
                                    <textarea cols="30" rows="5" class="with-border" wire:model='description' placeholder="Entrez la description de test"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{$message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <center>
                            <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4">
                                <button wire:click='change("all")' type='button' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                            @if(count(Auth::guard('entreprise')->user()->secteurs)>=1)
                            <button type='submit' class='button ripple-effect button-sliding-icon'>ajouter<i class='icon-feather-check'></i></button>
                            </div>
                            @endif
                        </center>
                    </form>
                    </div>

                </div>
        @elseif(session('opTestEn')=='ajouteQuestion')
            <div class="col-xl-12" >
            <div class="dashboard-box margin-top-0">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-feather-folder-plus"></i> Ajouter Question</h3>
                </div>
                <form action="post" wire:submit.prevent='ajouterQuestion'>
                    @csrf
                <div class="content with-padding padding-bottom-10">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>Test</h5>
                                <select wire:model='choixtest'>
                                    <option>Entrez votre choix</option>
                                    @forelse (Auth::guard('entreprise')->user()->tests as $item)
                                        <option value="{{ $item->idTest }}">{{ $item->titreTest }}</option>
                                    @empty
                                        <option>no test</option>
                                    @endforelse
                                </select>
                                @error('choixtest')
                                <span class="text-danger">{{$message }}</span>
                            @enderror
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>Question</h5>
                                <input type="text" class="with-border" wire:model='questions' placeholder="entrez le titre de test">
                            @error('questions')
                            <span class="text-danger">{{$message }}</span>
                                @enderror
                                </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>choix 1</h5>
                                <input type="text" class="with-border" wire:model='choix1' placeholder="entrez le choix 1">
                                @error('choix1')
                                <span class="text-danger">{{$message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>choix 2</h5>
                                <input type="text" class="with-border" wire:model='choix2' placeholder="entrez le choix 2">
                                @error('choix2')
                                <span class="text-danger">{{$message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>choix 3</h5>
                                <input type="text" class="with-border" wire:model='choix3' placeholder="entrez le choix 3">
                                @error('choix3')
                                <span class="text-danger">{{$message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>choix 4</h5>
                                <input type="text" class="with-border" wire:model='choix4' placeholder="entrez le choix 4">
                                @error('choix4')
                                <span class="text-danger">{{$message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>Choix correct</h5>
                                <select wire:model='iscorect'>
                                    <option value='choix1'>choix1</option>
                                    <option value='choix2'>choix2</option>
                                    <option value='choix3'>choix3</option>
                                    <option value='choix4'>choix4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <center>
                        <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4 margin-left-100">
                            <button type='button' wire:click='change("all")' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                           <button wire:click.prevent='ajouterQuestion' class='button ripple-effect button-sliding-icon'>ajouter<i class='icon-feather-check'></i></button>

                        </div>
                    </center>
                </form>
                </div>

            </div>
            @elseif(session('opTestEn')=='update')
            <div class="col-xl-12">
              <div class="dashboard-box margin-top-0">
                  <div class="headline d-flex justify-content-between">
                      <h3><i class="icon-feather-file-text"></i> modifier Test ou question </h3>
                  </div>
                <div class="d-flex justify-content-center margin-top-25">
                  <div class="account-type col-xl-5 offset-xl-3">
                      <div>
                          <input type="radio" name="account-type-radio" id="freelancer-radio" class="account-type-radio" wire:model='typeUpdate' value='test' {{ $typeUpdate=='test'?'checked':''}} />
                          <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> test</label>
                      </div>

                      <div>
                          <input type="radio" name="account-type-radio" id="employer-radio" class="account-type-radio" value='question' wire:model='typeUpdate' {{ $typeUpdate=='question'?'checked':'' }}/>
                          <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> question</label>
                      </div>
                  </div>
                </div>
                  @if($typeUpdate=='test')
                      <div class="content padding-top-40 padding-bottom-10">
                          <div class="d-flex">
                              <div class="content">
                                  <div class="col-xl-12">
                                          <div >
                                              <div class="row">
                                                  <div class="col-xl-12">
                                                      <div class="submit-field">
                                                          <h5>titre</h5>
                                                          <input type="text" class="with-border" wire:model='titre' >
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-12">
                                                      <div class="submit-field">
                                                          <h5>Duree <span>(minute)</span></h5>
                                                          <input type="text" class="with-border" wire:model='duree' >
                                                      </div>
                                                  </div>

                                                  <div class="col-xl-12">
                                                      <div class="submit-field">
                                                          <h5>test Description</h5>
                                                          <textarea cols="30" rows="5" class="with-border" wire:model='description' ></textarea>
                                                      </div>
                                                  </div>

                                              </div>
                                          </div>

                                  </div>
                              </div>
                          </div>
                          </div>
                  @elseif($typeUpdate=='question')
                  <div class="content with-padding padding-bottom-10">
                      <div class="d-flex">
                          <div class="content">
                              <div class="numbered color">
                                  <ol>
                                      @foreach($tb as $key=>$item)
                                      <div class="question">
                                            <h5 class="margin-bottom-15"><strong>Question {{ $key+1 }} :</strong></h5>
                                            <div class='d-flex'>
                                                <input type="text" wire:model="tb.{{ $key }}.enonce"><a wire:click="deleteQuestion({{ $item['id'] }})" class="button gray ripple-effect ico margin-left-20" style="height: 40px !important;width: 15px !important"  title="supprimer test" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                            </div>
                                        </li>


                                          @forelse ($choixreser[$key] as $key1=>$item1)
                                                  <ul class="numbered">
                                                  <h5 class="margin-bottom-15">choix {{ $key1+1 }} :</h5>
                                                  @if($item1['isCorrect']===1)
                                                      <input type="text" wire:model="choixreser.{{ $key }}.{{$key1}}.enonce" style="border:2px solid green">
                                                  @else
                                                      <input type="text" wire:model="choixreser.{{ $key }}.{{$key1}}.enonce">
                                                  @endif
                                                  </ul>
                                          @empty
                                              <ul class="numbered">
                                                  <li ><mark> no choix</mark></li>
                                              </ul>
                                          @endforelse
                                          @if(count($choixreser[$key])!=0)
                                          <ul class="numbered">
                                              <h5 class="margin-bottom-15 ">choix correct:</h5>
                                          <select wire:model="select.{{$key}}">
                                              @foreach ($choixreser[$key] as $key1=>$item1)
                                              <option value="{{ $item1['id'] }}"
                                              {{ isset($item1->id)&&$select[$key]==$item1->id?"selected":"" }}>choix{{$key1+1}}</option>
                                              @endforeach
                                          </select>
                                          </ul>
                                          @endif
                                      </div>
                                  @endforeach
                                  </ol>
                              </div>
                          </div>
                      </div>
                  </div>
                  @endif
                      <center>
                        <div align='center' class="centered-button margin-top-35 col-xl-4 col-md-4">
                            <button wire:click='change("all")' type='button' class="button ripple-effect button-sliding-icon"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                        <button wire:click='updateTb' class='button ripple-effect button-sliding-icon'>modifier<i class='icon-feather-check'></i></button>
                        </div>
                      </center>
                  </div
                  </div>
              </div>
              </div>
        @elseif(session('opTestEn')=='resultatTest')
              <div class="row">
                  <!-- Dashboard Box -->
                  <div class="col-xl-12">
                      <div class="dashboard-box margin-top-0">

                          <!-- Headline -->
                          <div class="headline d-flex justify-content-between col-12">
                              <h3><i class="icon-material-outline-supervisor-account"></i> {{ count($resultatsTest) }} Resultats</h3>
                          </div>
                          <div class="content">
                              <ul class="dashboard-box-list">
                                  <li>
                                      <!-- Overview -->
                                      @forelse ($resultatsTest as $key=>$item)
                                      <div class="freelancer-overview manage-candidates margin-top-20">
                                          <div class="freelancer-overview-inner">
                                              <br><br>
                                              <div class="freelancer-avatar ia">
                                                   <a ><img src={{asset('/storage/'.$item->utilisateur->photo) }} alt="" height='76px' width='76px'></a>
                                              </div>
                                              <!-- Name -->
                                              <div class="freelancer-name">
                                                  <h4>{{ $item->utilisateur->nomUtilisateur.' '.$item->utilisateur->prenomUtilisateur}}</h4>
                                                  <span class="freelancer-detail-item"><i class="icon-material-outline-description"></i> {{ $item->tests->titreTest }} ({{Str::limit($item->tests->descriptionTest,20)}})</span>
                                                  <br>
                                                  <h4 class="freelancer-detail-item">Score:{!! "<strong>$item->scoreTest </strong>/<strong>".count($item->tests->questions)."</strong>"  !!}</h4>

                                                  <!-- Buttons -->

                                              </div>
                                          </div>
                                      </div>
                                      @empty
                                          <center class='d-flex justify-content-center col-12'>
                                                <div class="freelancer">
                                                    <mark class='color'>No Test</mark>
                                                </div>
                                        </center>
                                      @endforelse
                                  </li>
                              </ul>
                              <div>
                                 <center>
                                  <button type='button' wire:click="change('all')" class="button ripple-effect button-sliding-icon margin-top-20 margin-bottom-20"><i class="icon-material-outline-arrow-back"></i>Annuler</button>
                                 </center>
                              </div>
                          </div>
                      </div>
                  </div>

              </div>
        @endif
        <!-- Footer -->
        @include('livewire.layoutsLivewire.footerDashboard')
        <!-- Footer / End -->
    </div>
</div>


