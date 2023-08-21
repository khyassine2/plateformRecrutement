<?php

namespace App\Http\Livewire\Entreprise;

use App\Models\Entreprise;
use App\Models\Entreprise_has_Secteur;
use App\Models\Offre;
use App\Models\SecteurActiviter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Entrepriseoffre extends Component
{
    public $op='all';
    protected $paginationTheme = 'bootstrap';
    public $offreId;

    public $titre,$description,$competenceRequise,$RemunurationPropose,$datePublie,$dateCloture,$Valtypeoffre,$Valentreprise,$Valsecteuractiviter;
    public $idDelete,$titreDelete,$descriptionDelete,$competenceRequiseDelete,$RemunurationProposeDelete,$datePublieDelete,$dateClotureDelete,$ValtypeoffreDelete,$ValentrepriseDelete,$ValsecteuractiviterDelete;
    public $filterby;


    public $test;
    public $dateFilter1;
    public $dateFilter2;

    public $type;
    public $entreprises;
    public $secteurs;

    public $minPrice = 0;
    public $maxPrice =10000;
    public $secteuractiviter;



    protected $queryString = ['filterby'];
    protected $rules=[
            'titre'=>'required',
            'description'=>'required',
            'competenceRequise'=>'required',
            'RemunurationPropose'=>'required',
            'datePublie'=>'required',
            'dateCloture'=>'required'

    ];
    public function render()
    {
        return view('livewire.entreprise.entrepriseoffre',["offres"=>Offre::where('hasEntrepriseId',Auth::guard('entreprise')->user()->idEntreprise)->get(),"entreprise_has_secteurs"=>Entreprise_has_Secteur::All(),"entreprise"=>Entreprise::All(),"secteuractiviter"=>SecteurActiviter::All(),"typeOffre"=>DB::table('offres')->distinct()->pluck('typeOffre')]);
    }
    public function updatedValentrepriseDelete(){

        if($this->ValentrepriseDelete!=='')
        $this->secteuractiviter=Entreprise::find($this->ValentrepriseDelete)->secteurs;
    }
    public function change($op,$id=null){
        $this->op=$op;
        if($op=='all'){
            $this->resetInput();
        }
        if($op=='edit'){
            $this->ValentrepriseDelete=Entreprise::find($this->ValentrepriseDelete)->secteurs;
        }
        if(isset($id)){

            $offre=Offre::find($id);

            $this->idDelete=$offre->idOffre;
            $this->titreDelete=$offre->titreOffre;

        }
    }
    public function mount()
{
    $this->op;

}
public function tocandidate($offreId)
{
    $this->offreId=$offreId;
    $this->op="historiquecandidatures";

}


    public function resetInput(){
        $this->titre='';
        $this->description='';
        $this->competenceRequise='';
        $this->RemunurationPropose='';
        $this->datePublie='';
        $this->dateCloture='';
        $this->Valtypeoffre='';
        $this->Valentreprise='';
        $this->Valsecteuractiviter='';
    }
    public function ajouterOffres(){
        $this->validate();
        $offre=new Offre();
        $offre->titreOffre=$this->titre;
        $offre->descriptionOffre=$this->description;
        $offre->competenceRequise=$this->competenceRequise;
        $offre->RemunurationPropose=$this->RemunurationPropose;
        $offre->datePublie=$this->datePublie;
        $offre->dateCloture=$this->dateCloture;
        $offre->typeoffre=$this->Valtypeoffre;
        $offre->hasEntrepriseId=Auth::guard('entreprise')->user()->idEntreprise;
        $offre->hasSecteurId=$this->Valsecteuractiviter;
        $offre->test=$this->test;
        $this->resetInput();
        $offre->save();

        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"offre Ajouter avec success!!"
        ]);
        $this->op='all';


    }


    public function confirmationDelete($id){
        $offre=Offre::find($id);
        $this->idDelete=$offre->idOffre;
        $this->titreDelete=$offre->titreOffre;

    }


    public function delete()
    {
        Offre::where('idOffre',$this->idDelete)->delete();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"offre suprimer avec success!!"
        ]);
        $this->op='all';

    }

    public function edit($id)
    {

        $this->op='edit';
        $offre=Offre::find($id);
        $this->idDelete=$offre->idOffre;
        $this->titreDelete=$offre->titreOffre;
        $this->descriptionDelete=$offre->descriptionOffre;
        $this->competenceRequiseDelete=$offre->competenceRequise;
        $this->RemunurationProposeDelete=$offre->RemunurationPropose;
        $this->datePublieDelete=$offre->datePublie;
        $this->dateClotureDelete=$offre->dateCloture;
        $this->ValtypeoffreDelete=$offre->typeOffre;
        $this->ValentrepriseDelete=$offre->hasEntrepriseId;
        $this->ValsecteuractiviterDelete=$offre->hasSecteurId;
        $this->test=$offre->test;


    }

    public function update()
    {

       try {
            $offre=Offre::find($this->idDelete);
            $offre->titreOffre=$this->titreDelete;
            $offre->descriptionOffre=$this->descriptionDelete;
            $offre->competenceRequise=$this->competenceRequiseDelete;
            $offre->RemunurationPropose=$this->RemunurationProposeDelete;
            $offre->datePublie=$this->datePublieDelete;
            $offre->dateCloture=$this->dateClotureDelete;
            $offre->typeOffre=$this->ValtypeoffreDelete;
            $offre->hasEntrepriseId=$this->ValentrepriseDelete;
            $offre->hasSecteurId=$this->ValsecteuractiviterDelete;
            $offre->test=$this->test;
            $offre->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"offre moudifier avec success!!"
            ]);
            $this->op='all';
       } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de modifier l'offre..!!"
            ]);
       }
    }
}
