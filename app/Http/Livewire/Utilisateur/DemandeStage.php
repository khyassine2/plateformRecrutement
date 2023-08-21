<?php

namespace App\Http\Livewire\Utilisateur;

use App\Models\demande;
use App\Models\demandestage as ModelsDemandestage;
use App\Models\SecteurActiviter;
use App\Models\ville;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DemandeStage extends Component
{
    use WithPagination;
    public $op='all',$date=[],$villeO,$typeFormationO,$typeDemande='stage';
    public $idDemande,$typeStage,$dureeStage,$DateDebutStage,$DateFinStage,$ville,$utilisateurId,$status,$datePublie,$titreDemande,$typeFormation,$niveauEtude;
    public $erour1=false;
    public function updatedDateFinStage(){
        $this->checkDuree();
    }
    public function updateddureeStage(){
        $this->checkDuree();
    }
    public function checkDuree()
    {
        $dureeEnMois = [
            '1 mois' => 1,
            '2 mois' => 2,
            '3 mois' => 3,
            '4 mois' => 3,
            '5 mois' => 3,
            '6 mois' => 6,
            'Plus de 6 mois' => 7,
        ];

        $dateDebutObj = Carbon::parse($this->DateDebutStage);
        $dateFinObj = Carbon::parse($this->DateFinStage);

        $differenceEnMois = $dateFinObj->diffInMonths($dateDebutObj);
        if ($this->dureeStage == 'Plus de 6 mois') {
            $differenceEnMois = $dateDebutObj->diffInMonths($dateFinObj);
            if ($differenceEnMois <6) {
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'error',
                    'message'=>"La durée de stage doit être de plus de 6 mois..!!"
                ]);
                $this->erour1=true;
            }else{
                $this->erour1=false;
            }
        } else {
            $differenceEnMois = $dateFinObj->diffInMonths($dateDebutObj);
            if ($differenceEnMois != $dureeEnMois[$this->dureeStage]) {
                if($this->DateFinStage!==''){
                    $this->dispatchBrowserEvent('alert',[
                        'type'=>'error',
                        'message'=>"La durée de stage ne correspond pas <br> à la différence entre les dates de début et de fin.!!"
                    ]);
                    $this->erour1=true;
                }

            } elseif ($dateDebutObj->addMonths($dureeEnMois[$this->dureeStage])->isBefore($dateFinObj)) {
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'error',
                    'message'=>"La date de fin ne correspond pas <br> à la durée de stage sélectionnée.!!"
                ]);
                $this->erour1=true;
            } elseif ($dateFinObj->diffInMonths($dateDebutObj) > $dureeEnMois[$this->dureeStage]) {
                // $this->addError('erour1', 'La durée de stage dépasse la durée sélectionnée.');
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'error',
                    'message'=>"demande de stage a supprimer avec success!!"
                ]);
                $this->erour1=true;
            }else{
                $this->erour1=false;
            }
        }

    }
    public function updatedtypeDemande()
    {
        if($this->typeDemande=='emploi')
        {
            $this->erour1=false;
        }
    }
    public function ajouterDemande(){
        try {
            if($this->typeDemande=='stage')
                {
                    $this->validate([
                    'typeStage'=>'required',
                    'dureeStage'=>'required',
                    'DateDebutStage'=>'required|date',
                    'DateFinStage'=>'required|date|after_or_equal:DateDebutStage',
                    'ville'=>'required',
                    'titreDemande'=>'required',
                    'typeFormation'=>'required',
                    'niveauEtude'=>'required',
                    'typeDemande'=>'required'
                    ]);
            }elseif($this->typeDemande=='emploi')
                {
                    $this->validate([
                        'ville'=>'required',
                        'titreDemande'=>'required',
                        'typeFormation'=>'required',
                        'niveauEtude'=>'required',
                        'typeDemande'=>'required'
                    ]);
                }
        // chercher a demande
        $data = demande::firstOrNew(['typeFormation' =>$this->typeFormation,'utilisateurId'=>Auth::guard('web')->user()->idUtilisateur,'typeDemande'=>$this->typeDemande]);
        if($data->exists){
            // si deja exsist;
            $type=SecteurActiviter::find($this->typeFormation);
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"deja vous avez fait une demande <br> dans le type de formation <br>$type->nomSecteurActiviter 😓😓"
            ]);
        }else{
            // ajouter un demande
            $demande=new demande();
            $demande->titreDemande=$this->titreDemande;
            $demande->typeStage=$this->typeDemande=='stage'?$this->typeStage:null;
            $demande->dureeStage=$this->typeDemande=='stage'?$this->dureeStage:null;
            $demande->DateDebutStage=$this->typeDemande=='stage'?$this->DateDebutStage:null;
            $demande->DateFinStage=$this->typeDemande=='stage'?$this->DateFinStage:null;
            $demande->villeId=$this->ville;
            $demande->niveauEtude=$this->niveauEtude;
            $demande->utilisateurId=Auth::guard('web')->user()->idUtilisateur;
            $demande->status='en attente';
            $demande->datePublie=Carbon::now()->toDateString();
            $demande->typeFormation=$this->typeFormation;
            $demande->typeDemande=$this->typeDemande;
            $demande->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Votre demande ajouter avec success😉😉"
            ]);
            session()->put('opDu','all');
        }
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error d'ajouter cette demande😓😓"
            ]);
        }

    }
    public function render()
    {
        $data=demande::where('utilisateurId',Auth::guard('web')->user()->idUtilisateur)->paginate(5);
        foreach ($data as $key=>$item){
            $date=\Carbon\Carbon::createFromFormat('Y-m-d', $item->datePublie)->locale('fr_FR')->isoFormat('DD MMMM YYYY');
            $this->date[$key]=$date;
        }
        return view('livewire.utilisateur.demande-stage',['demandeStage'=>$data])->extends('layouts.app')->section('content');
    }
    public function mount(){
        $this->villeO=ville::all();
        $this->typeFormationO=SecteurActiviter::all();
        if(session('opDu')=='edit')
        {
            $this->edit();
        }elseif(session('opDu')=='delete')
        {
            $this->change('delete',session('idD'));
        }elseif(session('opDu')=='details')
        {
            $this->change('details',session('idD'));
        }
    }
    public function change($op,$id=null)
    {
        session()->put('opDu',$op);
        if(session('opDu')=='details'){
            // $this->idDemande=$id;
            session()->put('idD',$id);
            $this->detailsDemande();
        }elseif(session('opDu')=='all'){
            $this->restore();
        }elseif(session('opDu')=='delete'){
            $demande=demande::find(session('idD'));
            $this->titreDemande=$demande->titreDemande;
            $this->typeDemande=$demande->typeDemande;
        }elseif(session('opDu')=='ajouter'){
            $this->restore();
        }elseif(session('opDu')=='edit'){
            $this->restore();
            // $this->idDemande=$id;
            session()->put('idD',$id);
            $this->edit();
        }
    }
    public function edit(){
        // pour charger les donners
        try {
            $demande=demande::find(session('idD'));
            $this->idDemande=$demande->idDemande;
            $this->titreDemande=$demande->titreDemande;
            $this->typeStage=$demande->typeStage;
            $this->dureeStage=$demande->dureeStage;
            $this->DateDebutStage=$demande->DateDebutStage;
            $this->DateFinStage=$demande->DateFinStage;
            $this->ville=$demande->villeId;
            $this->niveauEtude=$demande->niveauEtude;
            $this->typeDemande=$demande->typeDemande;
            $this->status=$demande->status='en attente';
            $this->typeFormation=$demande->typeFormation;
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error😓😓"
            ]);
        }
    }
    public function modifierDemande(){
       try {
        $demande=demande::find(session('idD'));
        // modifier la demande
        // recuperer si il y'a deja une demande dans le type de formation selecter
        $data = demande::find($this->idDemande);
        if($data->typeFormation!==$this->typeFormation){
            // si deja exsist;
            $type=SecteurActiviter::find($this->typeFormation);
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"deja vous avez fait une demande <br> dans le type de formation <br>$type->nomSecteurActiviter 😓😓"
            ]);
        }elseif($data->typeFormation==$this->typeFormation)
        {
            // si il n'exsist pas
            $demande->titreDemande=$this->titreDemande;
            $demande->typeStage=$this->typeStage;
            $demande->dureeStage=$this->dureeStage;
            $demande->DateDebutStage=$this->DateDebutStage;
            $demande->DateFinStage=$this->DateFinStage;
            $demande->villeId=$this->ville;
            $demande->status=$this->status;
            $demande->niveauEtude=$this->niveauEtude;
            $demande->typeFormation=$this->typeFormation;
            $demande->typeDemande=$this->typeDemande;
            $demande->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"demande de stage modifier avec success😉😉"
            ]);
            session()->put('opDu','all');
            $this->restore();
        }
       } catch (\Throwable $th) {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"error de modification😓😓"
        ]);
       }
    }
    public function restore(){
        $this->typeStage='';
        $this->dureeStage='';
        $this->DateDebutStage='';
        $this->DateFinStage='';
        $this->ville='';
        $this->status='';
        $this->datePublie='';
        $this->titreDemande='';
        $this->typeFormation='';
        $this->typeDemande='';
    }
    public function detailsDemande(){
        $Demande=demande::find(session('idD'));
        $this->typeStage=$Demande->typeStage;
        $this->dureeStage=$Demande->dureeStage;
        $this->DateDebutStage=$Demande->DateDebutStage;
        $this->DateFinStage=$Demande->DateFinStage;
        $this->ville=$Demande->villes->nomVille;
        $this->status=$Demande->status;
        $this->datePublie=$Demande->datePublie;
        $this->niveauEtude=$Demande->niveauEtude;
        $this->titreDemande=$Demande->titreDemande;
        $this->typeDemande=$Demande->typeDemande;
        $this->typeFormation=$Demande->secteurActiviter->nomSecteurActiviter;
    }
    public function deleteDemande(){
        try {
            demande::find(session('idD'))->delete();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"demande de stage a supprimer avec success😉😉"
            ]);
            session()->put('opDu','all');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de suppression de demande😓😓"
            ]);;
        }
    }
}
