<?php

namespace App\Http\Livewire\Admin;

use App\Models\Candidature;
use App\Models\HistoriqueCandidature;
use Livewire\Component;



class Historiquecandidatures extends Component
{
    public $op="all";



    public $idDelete,$offreDelete;
    public function render()
    {
        return view('livewire.admin.historiquecandidatures',["historique"=>HistoriqueCandidature::all()]);

    }
    public function change($op,$id=null){
        $this->op=$op;
        if(isset($id)){

            $con=HistoriqueCandidature::find($id);
            $this->idDelete=$con->idHistorique;
            $this->offreDelete=$con->candidatures->users->nomUtilisateur;

        }
    }



public function mount()
{
    $this->op;
}


public function confirmationDelete($id){
    $con=HistoriqueCandidature::find($id);
    $this->idDelete=$con->idHistorique;
    $this->offreDelete=$con->candidatures->users->nomUtilisateur;

}
public function delete()
    {
        HistoriqueCandidature::find($this->idDelete)->delete();

        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"historique offre suprimer avec success!!"
        ]);
        $this->op='all';

    }

























}
