<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\sendEmailOffre;
use App\Models\Candidature;
use Illuminate\Support\Str;
use App\Models\Entreprise;
use App\Models\Entreprise_has_Secteur;
use App\Models\Offre;
use App\Models\SecteurActiviter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Offres extends Component
{
    public $offreId;
    use WithPagination;
    public $titre,$description,$competenceRequise,$RemunurationPropose,$datePublie,$dateCloture,$Valtypeoffre,$Valentreprise,$Valsecteuractiviter;
    public $idDelete,$titreDelete,$descriptionDelete,$competenceRequiseDelete,$RemunurationProposeDelete,$datePublieDelete,$dateClotureDelete,$ValtypeoffreDelete,$ValentrepriseDelete,$ValsecteuractiviterDelete;
    public $test;
    public $filterby;
    public $op="all";
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
            'competenceRequise'=>'required',
            'RemunurationPropose'=>'required',
            'datePublie'=>'required',
            'dateCloture'=>'required',
            'test'=>'required',

    ];
    protected $listeners=[
        'toBack'=>'toBack'
    ];
    public function toBack()
    {
        session()->put('opO','all');
    }
    public function mount(){
        if(session('opO')=='edit')
        {
            $this->edit(session('idO'));
        }elseif(session('opO')=='delete')
        {
            $this->change('delete',session('idO'));
        }
        $this->op;
    }
    public function updatedsearch(){
        $this->resetPage();
    }

    public function updatedValentreprise(){
        // pour afficher avant de ajoute les secteur si entreprise et il y'a un secteur
        if($this->Valentreprise!=='')
        $this->secteuractiviter=Entreprise::find($this->Valentreprise)->secteurs;



    }
    public function updatedValentrepriseDelete(){
        // pour afficher avant de modifier les secteur si entreprise et il y'a un secteur
        if($this->ValentrepriseDelete!=='')
        $this->secteuractiviter=Entreprise::find($this->ValentrepriseDelete)->secteurs;
        // dd($this->secteuractiviter);


    }


    public function render()
    {

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
        if($this->secteurs){
            $offres->where('hasSecteurId', $this->secteurs);
        }

        $offres = $offres->paginate(2);
        return view('livewire.admin.offres',["offres"=>$offres,"entreprise_has_secteurs"=>Entreprise_has_Secteur::All(),"entreprise"=>Entreprise::All(),"secteuractiviterr"=>SecteurActiviter::all(),"typeOffre"=>DB::table('offres')->distinct()->pluck('typeOffre')]);
    }

    public function change($op,$id=null){
        session()->put('opO',$op);
        if($op=='all'){
            $this->resetInput();
        }
        if($op=='edit'){
            session()->put('idO',$id);
            $this->ValentrepriseDelete=Entreprise::find($this->ValentrepriseDelete)->secteurs;
        }
        if(isset($id)){
            session()->put('idO',$id);
            $offre=Offre::find($id);
            $this->idDelete=$offre->idOffre;
            $this->titreDelete=$offre->titreOffre;
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


public function tocandidate($offreId)
{
    try {
        session()->put('idOffre',$offreId);
        //pour aller a historique candidature d'un offre
        $this->offreId=$offreId;
        session()->put('opO','historiquecandidatures');
    } catch (\Throwable $th) {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"error 😓😓"
        ]);
    }

}
    public function resetInput(){
        // vider les variable
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
        // ajoute Offre
        try {
            $this->validate();
            $offre=new Offre();
            $offre->titreOffre=$this->titre;
            $offre->descriptionOffre=$this->description;
            $offre->competenceRequise=$this->competenceRequise;
            $offre->RemunurationPropose=$this->RemunurationPropose;
            $offre->datePublie=$this->datePublie;
            $offre->dateCloture=$this->dateCloture;
            $offre->typeoffre=$this->Valtypeoffre;
            $offre->hasEntrepriseId=$this->Valentreprise;
            $offre->hasSecteurId=$this->Valsecteuractiviter;
            $offre->test=$this->test;
            $offre->save();
            $secteurId = $this->Valsecteuractiviter;
            $regex = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
            $candidatures = Offre::whereHas('entreprise_has_secteurs', function($query) use ($secteurId) {
                $query->where('secteurId', '=', $secteurId);
            })
            ->with('candidatures.users') // eager load the user relationship on candidatures
            ->get()
            ->pluck('candidatures.*.users') // extract the email attribute from all user relationships
            ->flatten()
            ->filter(function ($email) use ($regex) {
                return preg_match($regex, $email);
            });
            dispatch(new sendEmailOffre($candidatures,$offre->idOffre));
            session()->put('opO','all');
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"offre Ajouter avec success😉😉"
            ]);
            $this->resetInput();
        } catch (\Throwable $th) {
             $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error d'ajoute😓😓"
            ]);
        }


    }


    public function confirmationDelete($id){
        // confirmation de delete
        try {
            Offre::where('idOffre',$this->idDelete)->delete();
            $offre=Offre::find($id);
            $this->idDelete=$offre->idOffre;
            $this->titreDelete=$offre->titreOffre;
        } catch (\Throwable $th) {
             $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error 😓😓"
            ]);
        }
    }


    public function delete()
    {
        // la suppression
        try {
            Offre::where('idOffre',$this->idDelete)->delete();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"offre supprimer avec success!!"
            ]);
            session()->put('opO','all');
        } catch (\Throwable $th) {
             $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de suppression😓😓"
            ]);
        }

    }

    public function edit($id)
    {
        try {
            session()->put('opO','edit');
            session()->put('idO',$id);
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
            $this->secteuractiviter=Entreprise::find($this->ValentrepriseDelete)->secteurs;
        } catch (\Throwable $th) {
             $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error😓😓"
            ]);
        }
    }

    public function update()
    {
        // la modification de offre
        try {
            $offre=Offre::find(session('idO'));
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
            'message'=>"offre modifier avec success😉😉"
            ]);
            session()->put('opO','all');
        } catch (\Throwable $th) {
             $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de modification😓😓"
            ]);
        }
    }



}
