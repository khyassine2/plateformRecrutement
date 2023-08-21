<?php

namespace App\Http\Livewire\Admin;

use App\Models\choix;
use App\Models\Entreprise;
use App\Models\Question;
use App\Models\resultatTest;
use App\Models\SecteurActiviter;
use App\Models\TestCompetence as ModelsTestCompetence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Testcompetence extends Component
{
    use WithPagination;
    public $paginationEnabled = true;
    public $op='all',$update=false;
    public $typeUpdate='test';
    public $question;
    public $titre,$description,$duree,$type,$idutilisateur,$identreprise,$idsecteur,$idtest,$titre2;
    public $choix1,$choix2,$choix3,$choix4,$questions,$choixtest,$iscorect;
    public $tb=[];
    public $choixreser=[],$choixorigin=[];
    public $select=[];
    public $resultatsTest=[];
    public $secteurEntreprise;
    protected $listeners = ["deleteQues" => '$refresh'];
    // tableau tb pour stocker les echange;
    protected $rules=[
        'tb.*.enonce' => 'required|max:255',
    ];
    public function render()
    {
        if(!Gate::allows('admin')){
            session()->pull('typee');
            abort(403,'n est pas autorizé');
        }
        $data='';
        if($this->identreprise!==null){
            if($this->op!='details' && $this->op!='all' && $this->op!='update'){
                $data=Entreprise::find($this->identreprise)->secteurs()->get();
            }
        }
        return view('livewire.admin.testcompetence',['test'=>ModelsTestCompetence::paginate(5),'question'=>Question::all(),'choix'=>choix::all(),'count'=>ModelsTestCompetence::select('idTest')->count(),'utilisateur'=>User::all(),'entreprise'=>Entreprise::all(),'secteur'=>$data,'testA'=>ModelsTestCompetence::all()]);
    }
    public function edit($id){
        $this->idtest=$id;
        $Select=ModelsTestCompetence::find($id)->questions;
        foreach ($Select as $key=>$item) {
            foreach($item->choix as $key1=>$item1)
            {
                if($item1->isCorrect==1)
                {
                    $res=$item1->id;
                }
            }
            $this->select[$key] =$res;
        }
        session()->put('idTestA',$id);
        session()->put('opTestA','update');
        $this->detailTest();
    }
    public function resetInput(){
        $this->choixorigin=[];
            $this->titre='';
            $this->description='';
            $this->duree='';
            $this->choixreser=[];
            $this->question=[];
            $this->tb=[];
            $this->choix1='';
            $this->iscorect='';
            $this->choix2='';
            $this->choix3='';
            $this->choix4='';
            $this->questions='';
            $this->choixtest='';
        $this->question='';
        $this->identreprise='';
        session()->put('opTestA','all');
    }
    public function mount()
    {
        if(session('opTestA')=='details')
        {
            $this->change('details',session('idTestA'));
        }elseif(session('opTestA')=='update')
        {
            $this->edit(session('idTestA'));
        }elseif(session('opTestA')=='resultatTest')
        {
            $this->afficherResultatTest(session('idTestA'));
        }elseif(session('opTestA')=='delete')
        {
            $this->change('delete',session('idTestA'));
        }
    }
    public function change($op,$id=null){
        session()->put('opTestA',$op);
        if(session('opTestA')=='all'){
            $this->resetInput();
        }
        if($op=='details'){
            session()->put('idTestA',$id);
            $this->detailTest();
        }
        if(isset($id) && session('opTestA')=='delete'){
            session()->put('idTestA',$id);
            $test=ModelsTestCompetence::find(session('idTestA'));
            $this->idtest=$test->idTest;
            $this->titre2=$test->titreTest;
        }
    }
     // supprimer question
     public function deleteQuestion($id){
        try{
            session()->put('idTestEn',$id);
            Question::find(session('idTestEn'))->delete();
            $this->typeUpdate=='test';
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Question Supprimer avec success😉😉"
            ]);
            $this->emit('deleteQues');
        }catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Error de supprimer la Question😓😓"
            ]);
        }
    }
    public function detailTest(){
        $test=ModelsTestCompetence::find(session('idTestA'));
        $this->idtest=$test->idTest;
        $this->titre=$test->titreTest;
        $this->description=$test->descriptionTest;
        $this->duree=$test->duree;
        $this->type=$test->type;
        if($test->hasEntrepriseId==null){
            $data=$test->user()->first();
            $this->idutilisateur=$data->nomUtilisateur.' '.$data->prenomUtilisateur;
        }else{
            $dataen=$test->entreprise()->first();
            $datase=$test->secteur()->first();
            $this->identreprise=$dataen->nomEntreprise;
            $this->idsecteur=$datase->nomSecteurActiviter;
        }
        $this->question=Question::where('testId',$test->idTest)->get();

    }
    public function ajouterTest(){
        try {
            $this->validate([
                'titre'=>'required',
                'description'=>'required',
                'type'=>'required',
                'duree'=>'required',
            ]);
            $test=new ModelsTestCompetence();
            $test->titreTest=$this->titre;
            $test->descriptionTest=$this->description;
            $test->duree=$this->duree;
            $test->type=$this->type;
            if($this->type=='admin'){
                $test->utilisateurId=Auth::user()->idUtilisateur;
            }elseif($this->type=='entreprise'){
                $test->hasSecteurId=$this->idsecteur;
                $test->hasEntrepriseId=$this->identreprise;
            }
            $test->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"test ajouter avec success😉😉"
            ]);
            session()->put('opTestA','all');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error d'ajoute 😓😓"
            ]);
        }
    }
    // supprimer test
    public function deleteTest(){
       try {
            ModelsTestCompetence::find($this->idtest)->delete();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"test supprimer avec success😉😉"
            ]);
            $this->idtest='';
            $this->titre2='';
            session()->put('opTestA','all');
            $this->op='all';
            $this->resetPage();
       } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de supprimer le test 😓😓"
            ]);
       }
    }
    public function ajouterQuestion(){
        // ajouter question
        try {
            DB::transaction(function(){
                $question=new Question();
                $question->enonce=$this->questions;
                $question->testId=$this->choixtest;
                $question->save();
                choix::insert([
                    ['enonce' => $this->choix1, 'isCorrect' => $this->iscorect=='choix1'?1:0,'questionId'=>$question->id],
                    ['enonce' => $this->choix2, 'isCorrect' => $this->iscorect=='choix2'?1:0,'questionId'=>$question->id],
                    ['enonce' => $this->choix3, 'isCorrect' => $this->iscorect=='choix3'?1:0,'questionId'=>$question->id],
                    ['enonce' => $this->choix4, 'isCorrect' => $this->iscorect=='choix4'?1:0,'questionId'=>$question->id],
                ]);
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"Question Ajouter avec success😉😉"
                ]);
                session()->put('opTestA','all');
            });
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Error d'ajouter la Question😓😓"
            ]);
        }

    }
    public function modifier(){
            // modification de test
            $test=ModelsTestCompetence::find($this->idtest);
            $test->titreTest=$this->titre;
            $test->descriptionTest=$this->description;
            $test->duree=$this->duree;
            $test->save();
            $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"$this->typeUpdate modifier avec success😉😉"
            ]);
            $this->titre='';
            $this->description='';
            $this->duree='';

    }
    public function updatedtypeUpdate()
    {
        if($this->typeUpdate=='question'){
            $this->tb=Question::where('testId',$this->idtest)->get();
            foreach ($this->tb as $key=>$item) {
                $this->choixreser[$key] = $item->choix()->get();
                $this->choixorigin[$key] = $item->choix()->get();
            }
        }
    }
    public function updatedidentreprise()
    {
        $this->secteurEntreprise=Entreprise::find($this->identreprise)->secteurs;
    }
    public function updateTb()
    {
        if($this->typeUpdate=='test'){
            //  si typeUpdate == test il modifier le test
            $this->modifier();
            $this->edit(session('idTestA'));
        }
        $etat=0;
        foreach($this->tb as $key=>$item){
            if($this->question[$key]->enonce!=$item->enonce){
                // pour modifier la question si il change
                $question=Question::find($item->id);
                $question->enonce=$item->enonce;
                $question->save();
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"question modifier avec success😉😉"
                ]);
            }
            foreach ($this->choixreser[$key] as $key1=>$item1){
                if($this->choixorigin[$key][$key1]['enonce']!=$item1['enonce']){
                    // pour changer le choix si il change
                    $choix=choix::find($item1['id']);
                    $choix->enonce=$item1['enonce'];
                    $choix->save();
                    $this->dispatchBrowserEvent('alert',[
                        'type'=>'success',
                        'message'=>"choix modifier avec success😉😉"
                    ]);
                }
                $choixVal=choix::find($this->select);
                if(count($choixVal)>=1)
                {
                    if(isset($this->choixorigin[$key]) && isset($this->choixorigin[$key][$key1]) &&$this->choixorigin[$key][$key1]['questionId']==$choixVal[$key]->questionId){
                        if( $this->choixorigin[$key][$key1]['id']!==$choixVal[$key]->id)
                            {
                                // pour changer la bonne reponse
                                if($this->select[$key]!==$choixVal[$key]->id)
                                {
                                    // recuperer le choix qui selectionnez
                                    $iscorect=choix::find($this->select[$key]);
                                    DB::transaction(function() use($iscorect,$item1)
                                    {
                                        //modifier tous les choix qui ont questionId par 0
                                        DB::table('choix')->where('questionId',$item1['questionId'])->update([
                                        'isCorrect'=>0
                                        ]);
                                        // update choix selectionnez par 1
                                        $iscorect->isCorrect=1;
                                        $iscorect->save();
                                        $this->dispatchBrowserEvent('alert',[
                                            'type'=>'success',
                                            'message'=>"choix correcte modifier avec success😉😉"
                                        ]);
                                        session()->put('opTestA','all');
                                    });
                                }

                            }
                    }
                }
            }
        }

                // dd($this->tb1[$key]->enonce==$item->enonce);
                    // }
        // if($etat==1){
        //     session()->flash('status','question modifier avec success');
        //     $this->choixorigin=[];
        //     $this->choixreser=[];
        //     $this->question=[];
        //     $this->tb=[];
        //     $this->op='all';
        //     $this->typeUpdate='test';
        // }
    }
    public function afficherResultatTest($id){
        session()->put('idTestA',$id);
        $this->resultatsTest=resultatTest::where('TestId',session('idTestA'))->get();
        if(!$this->resultatsTest->isEmpty()){
            session()->put('opTestA','resultatTest');
        }else{
            $this->dispatchBrowserEvent('Modal',[
                'type'=>'error',
                'message'=>"il n'est pas des resultats"
            ]);
        }
    }

}
