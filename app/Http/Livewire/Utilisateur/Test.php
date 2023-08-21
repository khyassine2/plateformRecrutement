<?php

namespace App\Http\Livewire\Utilisateur;

use App\Models\Candidature;
use App\Models\Offre;
use App\Models\resultatTest;
use App\Models\TestCompetence;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Test extends Component
{
    public $op='all',$idTest,$verfyPasserTest=false;
    protected $listeners = ['testTermine'];
    public function render()
    {
        $test=TestCompetence::whereNotNull('utilisateurId')->get();
        $candidatures=Candidature::where('utilisateurId',Auth::guard('web')->user()->idUtilisateur)->get();
        // dd($candidatures);
        // dd($candidatures->first()->offres->TestEntrepriseOffre($candidatures->first()->offres->hasSecteurId,$candidatures->first()->offres->hasEntrepriseId));
        return view('livewire.utilisateur.test',['test'=>$test,'candidatures'=>$candidatures])->extends('layouts.app')->section('content');
    }

    public function change($op,$id=null)
    {
        $this->op=$op;
        $this->idTest=$id;
    }
    public function testTermine(){
        $this->op='all';
    }
    public function afficherResultatTest($id){
        $resultatTest=resultatTest::where('TestId',$id)->where('utilisateurId',Auth::guard('web')->user()->idUtilisateur)->get();
        if(!$resultatTest->isEmpty()){
            // affichage de resultat de test
            $resultat=$resultatTest->first()->scoreTest;
            $nbquestion=count($resultatTest->first()->tests->questions);
            $this->dispatchBrowserEvent('Modal',[
                'type'=>'success',
                'message'=>"Votre score c'est $resultat / $nbquestion"
            ]);
        }else{
            $this->dispatchBrowserEvent('Modal',[
                'type'=>'error',
                'message'=>"Vous avez pas passer ce test"
            ]);
        }
    }
}
