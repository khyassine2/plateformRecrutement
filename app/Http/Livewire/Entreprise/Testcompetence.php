<?php

namespace App\Http\Livewire\Entreprise;

use App\Models\choix;
use App\Models\Entreprise;
use App\Models\Question;
use App\Models\resultatTest;
use App\Models\TestCompetence as ModelsTestCompetence;
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
    public $select;
    public $resultatsTest=[];
    protected $listeners = ["deleteQues" => '$refresh'];
    // tableau tb pour stocker les echange;
    protected $rules=[
        // 'titre'=>'required',
        // 'description'=>'required',
        // 'type'=>'required',
        'tb.*.enonce' => 'required|max:255',
    ];
    public function render()
    {
        $data='';
        // dd($this->choixreser[0][0]['idChoix']);
        if(Auth::guard('entreprise')->user()->idEntreprise){
            if($this->op!='details' && $this->op!='all' && $this->op!='update'){
                $data=Auth::guard('entreprise')->user()->secteurs;
            }
        }
        // Auth::guard('entreprise')->user()->tests()->first()->questions->first()->choix
        // dd(Auth::guard('entreprise')->user()->tests()->first()->questions->first()->choix);
        return view('livewire.entreprise.testcompetence',['test'=>ModelsTestCompetence::where('hasEntrepriseId',Auth::guard('entreprise')->user()->idEntreprise)->paginate(5)])->extends('layouts.app')->section('content');
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
        if(session('opTestEn')=='details')
        {
            $this->change('details',session('idTestEn'));
        }elseif(session('opTestEn')=='update')
        {
            $this->edit(session('idTestEn'));
        }elseif(session('opTestEn')=='resultatTest')
        {
            $this->afficherResultatTest(session('idTestEn'));
        }elseif(session('opTestEn')=='delete')
        {
            $this->change('delete',session('idTestEn'));
        }
    }
    public function change($op,$id=null){
        session()->put('opTestEn',$op);
        if(session('opTestEn')=='all'){
          $this->resetInput();
        }
        if(session('opTestEn')=='details'){
            session()->put('idTestEn',$id);
            $this->detailTest();
        }
        if(isset($id) && session('opTestEn')=='delete'){
            session()->put('idTestEn',$id);
            $test=ModelsTestCompetence::find(session('idTestEn'));
            $this->idtest=$test->idTest;
            $this->titre2=$test->titreTest;
        }
    }
    public function detailTest(){
        $test=ModelsTestCompetence::find(session('idTestEn'));
        $this->idtest=$test->idTest;
        $this->titre=$test->titreTest;
        $this->description=$test->descriptionTest;
        $this->duree=$test->duree;
        $this->type=$test->type;
        if($test->hasEntrepriseId!==null){
            $dataen=$test->entreprise()->first();
            $datase=$test->secteur()->first();
            $this->identreprise=$dataen->nomEntreprise;
            $this->idsecteur=$datase->nomSecteurActiviter;
        }
        $this->question=Question::where('testId',session('idTestEn'))->get();
    }
    public function ajouterTest(){
        try {
            $this->validate([
                'titre'=>'required',
                'description'=>'required',
                'duree'=>'required',
            ]);
            $checkTest=ModelsTestCompetence::where('hasEntrepriseId',Auth::guard('entreprise')->user()->idEntreprise)->where('hasSecteurId',$this->idsecteur)->get();
            if($checkTest->isEmpty())
            {
                $test=new ModelsTestCompetence();
                $test->titreTest=$this->titre;
                $test->descriptionTest=$this->description;
                $test->duree=$this->duree;
                $test->type='entreprise';
                $test->hasSecteurId=$this->idsecteur;
                $test->hasEntrepriseId=Auth::guard('entreprise')->user()->idEntreprise;
                $test->save();
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"test ajouter avec success😉😉"
                ]);
                session()->put('opTestEn','all');
            }else
            {
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'error',
                    'message'=>"deja publie un test dans cette secteur😓😓"
                ]);
            }

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error d'ajoute 😓😓"
            ]);
        }
    }
    // supprimer question
    public function deleteQuestion($id){
        try {
            session()->put('idTestEn',$id);
            Question::find(session('idTestEn'))->delete();
            $this->typeUpdate=='test';
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Question Supprimer avec success😉😉"
            ]);
            $this->emit('deleteQues');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Error de supprimer la Question😓😓"
            ]);
        }
    }
    // supprimer test
    public function deleteTest(){
       try {
            ModelsTestCompetence::find(session('idTestEn'))->delete();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"test supprimer avec success😉😉"
            ]);
            $this->idtest='';
            $this->titre2='';
            session()->put('opTestEn','all');
            $this->resetPage();
       } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de supprimer le test 😓😓"
            ]);
       }
    }
       public function ajouterQuestion(){
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
                session()->put('opTestEn','all');
            });
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Error d'ajouter la Question😓😓"
            ]);
        }

    }
    public function edit($id){
        try {
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
            session()->put('idTestEn',$id);
            session()->put('opTestEn','update');
            $this->detailTest();
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Error Question😓😓"
            ]);
        }
    }
    public function updateTb()
    {
        if($this->typeUpdate=='test'){
            //  si typeUpdate == test il modifier le test
            $this->modifier();
            $this->edit(session('idTestEn'));
        }
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
                    $choixVal=[];
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
                                        session()->put('opTestEn','all');
                                    });
                                }

                            }
                    }
                }
                }

        }
    }
    public function updatedtypeUpdate()
    {
        if($this->typeUpdate=='question'){
            $this->tb=Question::where('testId',$this->idtest)->get();
            foreach ($this->tb as $key=>$item) {
                $this->choixreser[$key] = $item->choix()->get();
                $this->choixorigin[$key] = $item->choix()->get();
            }

            // dd($this->choixreser);
            // dd($this->tb->first()->choix()->get());
            // $this->choix1=$this->tb[1]->enonce??'';
            // $this->choix2=$this->tb[2]->enonce??'';
            // $this->choix3=$this->tb[3]->enonce??'';
            // $this->choix4=$this->tb[4]->enonce??'';
            // dd($this->choix1);
            // dd('oui');
            // dd($this->tb->first()->enonce);
        }
    }
    public function modifier(){
        if($this->typeUpdate=='test'){
            // modification de test
            // dd($this->idtest);
            $test=ModelsTestCompetence::find($this->idtest);
            $test->titreTest=$this->titre;
            $test->descriptionTest=$this->description;
            $test->duree=$this->duree;
            $test->save();
            session()->flash('status',"$this->typeUpdate modifier avec success");
            $this->titre='';
            $this->description='';
            $this->duree='';
            $this->op='all';

        }elseif($this->typeUpdate=='question'){

        }
    }
    public function afficherResultatTest($id){
        
        session()->put('idTestEn',$id);
        $this->resultatsTest=resultatTest::where('TestId',session('idTestEn'))->get();
        if(!$this->resultatsTest->isEmpty()){
            session()->put('opTestEn','resultatTest');
        }else{
            $this->dispatchBrowserEvent('Modal',[
                'type'=>'error',
                'message'=>"il n'est pas des resultats"
            ]);
        }
    }
}
