<?php

namespace App\Http\Livewire;

use App\Models\Candidature;
use App\Models\Entreprise;
use App\Models\Entreprise_has_Secteur;
use App\Models\Offre;
use App\Models\reponseCandidat;
use App\Models\resultatTest;
use App\Models\SecteurActiviter;
use App\Models\ville;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Alloffres extends Component
{
    use WithPagination;
    public $paginationEnabled = true;
    public $filterby;
    public $dateFilter1;
    public $dateFilter2;
    public $type;
    public $ville;
    public $id2;
    public $entreprises;
    public $secteurs;
    public $secteursRef;
    public $minPrice = 0;
    public $maxPrice =10000;
    public $offresumilaire;
    public $selectedDiv = 'all';
    public $idoff;
    public $offre;
    // public $id;


    protected $queryString = ['filterby'];
    public function render()
    {
        if (request('op')=="secteur") {

            $this->secteurs=request('id2');
            }
        elseif(request('op')=="ville"){

            $this->ville=request('id2');

            }
        elseif(request('op')=="offre"){

            $this->changediv('info',request('id2'));

            }
        $offres = Offre::query();

        $offres = Offre::whereBetween('RemunurationPropose', [$this->minPrice, $this->maxPrice]);


        if ($this->dateFilter1) {
            $offres->whereDate('datePublie', $this->dateFilter1);
            }
        if ($this->dateFilter2) {
            $offres->whereDate('dateCloture', $this->dateFilter2);
            }
        if ($this->filterby) {
        $offres->where('titreOffre', 'like', '%'.$this->filterby.'%');
        }


        if ($this->type) {
            $offres->where('typeOffre', $this->type);
        }
        if($this->entreprises){
            $offres->where('hasEntrepriseId', $this->entreprises);
        }
        if($this->ville){

            $offres->join('entreprises', 'offres.hasEntrepriseId', '=', 'entreprises.idEntreprise')->where('villeEntreprise', $this->ville);

        }
        if($this->secteurs){
            $offres->where('hasSecteurId', $this->secteurs);
        }
        return view('livewire.alloffres',["offres"=>$offres->paginate(4),"entreprise_has_secteurs"=>Entreprise_has_Secteur::All(),"entreprise"=>Entreprise::All(),"secteuractiviter"=>SecteurActiviter::All(),"typeOffre"=>DB::table('offres')->distinct()->pluck('typeOffre'),"villes"=>ville::all()])->extends('layouts.app')->section('content');

    }
    public function mount()
    {
        if(session('opAllOffre')=='info')
        {
            $this->changediv('info',session('idAllOffre'));
        }
        if(request('etat')=='success')
        {
            session()->pull('id2');
        }
        if(request('op')!==null && request('id2')!==null)
        {
            if(request('op')=='ville')
            {
                $this->ville=request('id2');
            }elseif(request('op')=='offre6')
            {
                $this->changediv('info',request('id2'));
            }
        }else{

            if(request('select')!==null || request('myinput')!==null){
            $this->filterby=request('myinput')??'';
            $this->secteurs=request('select')??'';
            }
        }
    }
    public function updatedsearch(){
        $this->resetPage();
    }
    public function changediv($info,$id){
        session()->put('opAllOffre',$info);
        // if($info=='all')
        // {
        //     $this->selectedDiv=$info;
        // }
        if($info=='info')
        {
            session()->put('idAllOffre',$id);
            $this->selectedDiv=$info;
            $this->offre = Offre::with('candidatures')->find(session('idAllOffre'));
            $this->secteursRef=Offre::where('hasSecteurId',$this->offre->hasSecteurId)->get();
            $this->offresumilaire = Offre::where('hasSecteurId',$this->offre->hasSecteurId)->where('idOffre','!=',$this->offre->idOffre)->take(2)->get();
            if ($this->offresumilaire->isEmpty()) {
                // si offresumilaire est empty il retourner un 2 offre
                $this->offresumilaire = Offre::take(2)
                ->get();
            }
            return $this->offre;
        }

    }


    public function filterByTypeOffre($type)
    {
        $this->type = $type;
    }

    public function filterByEnreprise($entreprises)
    {
        $this->entreprises = $entreprises;
    }
    public function filterBySecteurs($secteurs)
    {
        $this->secteurs = $secteurs;
    }
    public function filterByville($ville)
    {
        $this->ville = $ville;
    }
       public function tocandidate($id){
        $con=Candidature::where('offreId', $id)->where('utilisateurId', Auth::guard('web')->user()->idUtilisateur)->get();
        $offre=Offre::find($id);
        if($offre->test=='oui'){
            $test=$offre->TestEntrepriseOffre($offre->hasSecteurId,$offre->hasEntrepriseId);
            // dd($test,$offre->hasSecteurId,$offre->hasEntrepriseId,$offre->);
            $testId=$test->first()->idTest;
            $resultatTest=resultatTest::where('TestId',$testId)->where('utilisateurId',Auth::guard('web')->user()->idUtilisateur)->count();
            // dd($con,$resultatTest);
            if($con->first()==null && $resultatTest==0)
            {
                session()->put('id2',$id);
                $this->redirect("/passerTest/".$testId);
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'error',
                    'message'=>"l'offre il'est oblogatoire de passer un test"
                ]);
            }else{
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'warning',
                    'message'=>"vous avez deja postuler a cette offre"
                ]);
            }
        }
        elseif ($con->first()==null){
            $hc=new Candidature();
            $hc->competenceQualification=Auth::guard('web')->user()->donners->competences;
            $hc->dateCandidatures=now()->toDateString();
            $hc->utilisateurId=Auth::guard('web')->user()->idUtilisateur;
            $hc->offreId=$id;
            $hc->save();
            $this->changediv('all',null);
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"vous avez postuler avec success"
            ]);
    }
    else{
        $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"vous avez deja postuler a cette offre"
        ]);
        $this->selectedDiv='all';

    }

}
}
