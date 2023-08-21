<div class="{{$etat==1?'container margin-top-100':''}}" style="width: 97% !important">
            @if($nbQuestion!==0)
            
            <div class="progress margin-bottom-30" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success" style="width:{{ ($step/$nbQuestion)*100 }}%;" >{{ ($step/$nbQuestion)*100 }} %</div>
             </div>
            <div class="row">
            <div class="container ">
                            <form wire:submit.prevent="soumettre">
                                @csrf
                            @if($step!=0)
                                <div class='d-flex justify-content-end'>
                                    <h3>
                                        <i class="icon-line-awesome-hourglass-half"></i>
                                        {{ gmdate('i:s',$duration) }}
                                    </h3>
                                </div>
                                <div class="col-xl-12 col-md-4 margin-left-40">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h3>{{$questions[$step-1]->enonce}}</h3>
                                    </div>
                                    @forelse ($questions[$step-1]->choix as $item)
                                        <div class="radio margin-left-60">
                                            <input id="choix_{{ $item->id }}" name="radio" type="radio" value="{{ $item->id }}" wire:model="reponses.{{ $questions[$step-1]->id }}">
                                            <label for="choix_{{ $item->id }}"><span class="radio-label"></span> {{ $item->enonce }}</label>
                                        </div>
                                        <br>
                                    @empty
                                        <div class="radio">
                                            <mark>no choix</mark>
                                        </div>
                                    @endforelse
                                </div>
                            @elseif($step==0)
                            <div class="col-xl-12 col-md-4 margin-left-40">
                                <div class="section-headline margin-top-25 margin-bottom-12">
                                    <center>
                                        <h4>Bienvenue Sur Le Test <strong> {{ $nomTest }}</strong> la durée de Test c est {{ $duree }}Min</h4>
                                    </center>
                                </div>
                            </div>
                            @endif
                            <div>
                                <center>
                                    @if($step==0)
                                    <button type='button' wire:click="gotoTest()" class="button ripple-effect button-sliding-icon"><i class="icon-line-awesome-angle-left"></i>Annuller</button>
                                    <button type='button' wire:click='startTimer' class="button dark ripple-effect button-sliding-icon">Debut<i class="icon-line-awesome-angle-right"></i></button>
                                    @else
                                    <button type='button' wire:click='previousStep' class="button ripple-effect button-sliding-icon " style='cursor:{!! $step==0?"not-allowed":($step==1?"not-allowed":"default") !!}' {{ $step==1?'disabled':'' }}><i class="icon-line-awesome-angle-left"></i>previous</button>
                                    @if($step==$nbQuestion)
                                    <button type='submit' class="button dark ripple-effect button-sliding-icon" >submit<i class="icon-feather-check"></i></button>
                                    @else
                                    <button type='button' wire:click='nextStep' class="button dark ripple-effect button-sliding-icon" style='cursor:{!! $step==$nbQuestion?"not-allowed":"" !!}'>Suivant<i class="icon-line-awesome-angle-right"></i></button>
                                    @endif

                                </center>
                            </div>

                            @endif
                        </form>
                        </ul>
            </div>
            </div>
            @if($etat==1)
            <div class="clearfix"></div><div class="clearfix"></div>
            {{--  footer  --}}
            @include('livewire.layoutsLivewire.footerDashboard')
            @endif
            @else
                <center><h1><mark>no test complé</mark></h1></center>
                <center><a type='button' href='{{route("alloffres")}}' class="button ripple-effect button-sliding-icon margin-top-100"><i class="icon-line-awesome-angle-left"></i>Annuller</a></center>
            @endif
       
</div>


    <script>
        var timerId;
        window.addEventListener('starChrono', event => {
            timerId=setTimeout(function() {
                    @this.call('startTimer');
            },1000);
        })
        window.addEventListener('endChrono', event => {
            clearTimeout(timerId);
        })
        ;
    </script>
