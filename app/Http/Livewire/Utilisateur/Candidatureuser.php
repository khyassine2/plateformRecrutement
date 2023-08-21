<?php

namespace App\Http\Livewire\Utilisateur;

use App\Models\Candidature;
use App\Models\HistoriqueCandidature;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;


class Candidatureuser extends Component
{
    public $op='all';
    public $dateCandidatures,$competenceQualification,$utilisateurval,$offreval;
    public $idDelete,$offreDelete,$dateCandidaturesDelete,$competenceQualificationDelete,$utilisateurvalDelete,$offrevalDelete,$historiques;
    public function render()
    {
        return view('livewire.utilisateur.candidatureuser',['histcondidat'=>Candidature::where('utilisateurId', Auth::guard('web')->user()->idUtilisateur)->with('historique_condidatures')->get(),"users"=>User::All(),"offres"=>Offre::All()]);
    }
    protected $rules=[
        'dateCandidatures'=>'required',
        'competenceQualification'=>'required'
    
];
    public function change($op,$id=null){
        session()->put('opCu',$op);
        if($op=='delete'){
            session()->put('idCu',$id);
            $this->confirmationDelete($id);
        }
    }
    public function mount()
{
    if(session('opCu')=='delete')
    {
        $this->change('delete',session('idCu'));
    }
}
public function confirmationDelete($id){
    // pour confirmer suppression
    try {
        $con=Candidature::find(session('idCu'));
        $this->idDelete=$con->idCandidature;
        $this->offreDelete=$con->offres->titreOffre;
    } catch (\Throwable $th) {
    $this->dispatchBrowserEvent('alert',[
        'type'=>'error',
        'message'=>"error😓😓"
    ]);
    }
}
public function delete()
    {
        // suppression
        try {
            Candidature::where('idCandidature',$this->idDelete)->delete();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"vous avez suprimer votre condidature a l'offre : $this->offreDelete avec success"
            ]);
            session()->put('opCu','all');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de suppression😓😓"
            ]);
        }     
    }
}
