<?php

namespace App\Http\Livewire\Utilisateur;

use App\Models\Candidature;
use App\Models\choix;
use App\Models\Question;
use App\Models\reponseCandidat;
use App\Models\resultatTest;
use App\Models\TestCompetence;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Passertest extends Component
{
    public $test,$nomTest,$duree,$questions,$reponses,$step=0,$nbQuestion;
    public $duration;
    public $idtest;
    public $start;
    public $tempsRestant;
    public $etat=0;
    public function render()
    {
        return view('livewire.utilisateur.passertest')->extends('layouts.app')->section('content');
    }
    public function mount($idtest)
    {
        if(request('idtest')!==null){
            // pour destinct entre passer des test dans dashboard et dans offres
            $this->etat=1;
        }
        $this->idtest=$idtest;
        // Récupérer le test de compétences à partir de l'ID
        $this->test = TestCompetence::findOrFail($this->idtest);
        $this->nomTest=$this->test->titreTest;
        $this->duree=$this->test->duree;
        // Récupérer la durée de test
        $this->duration=$this->test->duree * 60;
        // Récupérer les questions du test
        $this->questions = Question::where('testId', $this->idtest)->inRandomOrder()->get();
        // Initialiser les réponses du candidat
        $this->reponses = collect();
        foreach ($this->questions as $question) {
            $this->reponses[$question->id] = null;
        }
        $this->nbQuestion=count($this->questions);
    }

    public function startTimer()
    {
        $this->dispatchBrowserEvent('starChrono');
        if($this->duration > 0) {
            $this->duration -= 1;
            if($this->step==0){
                $this->step++;
            }
        }
        if($this->duration==1){
            $this->dispatchBrowserEvent('alert',[
                'type'=>'info',
                'message'=>"le temps à été fini.!!"
            ]);
        }elseif($this->duration==0){
            $this->soumettre();
            $this->dispatchBrowserEvent('endChrono');
        }elseif($this->duration<=10 && $this->duration>2){
            $this->dispatchBrowserEvent('alert',[
                'type'=>'warning',
                'message'=>"le temps à été presque à fini.!!"
            ]);
        }
    }

    public function nextStep(){
        $this->step++;
    }

    public function previousStep(){
        $this->step--;
    }
    public function mettreAJourScoreSite()
    {
        // pour mettre ajour le score de site
        $nbTests = resultatTest::where('utilisateurId', Auth::guard('web')->user()->idUtilisateur)->count();
        $multiplicite = floor($nbTests / 5);
        if ($multiplicite > 0) { // Vérifier si l'utilisateur a passé au moins 5 tests
            $user = User::find(Auth::guard('web')->user()->idUtilisateur);
            if ($user->scoreSite>11) { // Vérifier si le score à ajouter est supérieur au score actuel
                $user->levelsite_id = $user->levelsite_id+1;
                $user->save();
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'info',
                    'message'=>"Votre score et augmenter avec success😉😉"
                ]);
            }
        }
    }
    public function soumettre(){
        // Enregistrer les réponses du candidat dans la base de données
        foreach ($this->reponses as $questionId => $choixId) {
            if ($choixId !== null) {
                reponseCandidat::create([
                    'reponseCandidat' => $choixId,
                    'choixId' => $choixId,
                    'utilisateurId' => Auth::guard('web')->user()->idUtilisateur,
                ]);
            }
        }
        // Calculer le score du test
        $score = 0;
        foreach ($this->questions as $question) {
             $choixCorrect = choix::where('questionId', $question->id)->where('isCorrect', true)->first();
             if(isset($this->reponses[$question->id])){
             if ($this->reponses[$question->id] == $choixCorrect->id) {
                 $score++;
             }
            }
        }
        // Enregistrer le résultat du test dans la base de données
        $hasEntrepriseId=$this->test->type=='admin'?null:$this->test->hasEntrepriseId;
        $hasSecteurId=$this->test->type=='admin'?null:$this->test->hasSecteurId;
        $adminId=$this->test->type=='admin'?$this->test->utilisateurId:null;
        $test=$this->test->idTest;
        $resultatTest=resultatTest::create([
            'scoreTest' => $score,
            'dateTest' => now(),
            'hasEntrepriseId' =>$hasEntrepriseId ,
            'utilisateurId' => Auth::guard('web')->user()->idUtilisateur,
            'hasSecteurId' => $hasSecteurId,
            'adminId'=> $adminId,
            'TestId'=>$test
        ]);
        // augementer le score de site
        $this->mettreAJourScoreSite();
        // return to page test
        $this->emit('testTermine');
        // affichage de resultat de test
        $resultat=$resultatTest->scoreTest;
        $nbquestion=count($this->questions);

        $this->dispatchBrowserEvent('Modal',[
            'type'=>'success',
            'message'=>'test passer avec success..!!',
            'text'=>"Votre score c'est $resultat / $nbquestion"
        ]);
        if($this->etat==1)
        {
            // quand le test et terminer il redirect vers page d'offres qui pas le test
            $hc=new Candidature();
                $hc->competenceQualification=Auth::guard('web')->user()->donners->competences;
                $hc->dateCandidatures=now()->toDateString();
                $hc->utilisateurId=Auth::guard('web')->user()->idUtilisateur;
                $hc->offreId=session('id2');
                $hc->save();
            redirect()->route('alloffresid', ['op' => 'offre6', 'id2' => session('id2'),'etat'=>'success']);
        }
    }
    public function gotoTest(){
        $this->emit('testTermine');
    }
}
