<?php

namespace App\Http\Livewire\Admin;

use App\Models\Candidature;
use App\Models\HistoriqueCandidature;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Livewire\Component;



class Candidatures extends Component
{
    public $op="all";

    public $prop1,$disabled,$contenueMessage;
    public $dateCandidatures,$competenceQualification,$numTele,$utilisateurval,$offreval;
    public $idDelete,$offreDelete,$dateCandidaturesDelete,$competenceQualificationDelete,$utilisateurvalDelete,$offrevalDelete,$nomUtilisateur,$histcondidat;
    protected $listeners = ['refreshComponent' => '$refresh'];
    public function render()
    {
        return view('livewire.admin.candidatures',["users"=>User::All(),"offres"=>Offre::All()]);

    }
    protected $rules=[
        'dateCandidatures'=>'required',
        'competenceQualification'=>'required'

];
    public function change($op,$id=null){
        session()->put('opC',$op);
        if(isset($id)){
            session()->put('idC',$id);
            $con=Candidature::find($id);
            $this->idDelete=$con->idCandidature;
            $this->offreDelete=$con->offres->titreOffre;
            $this->nomUtilisateur=$con->users->nomUtilisateur.' '.$con->users->prenomUtilisateur;
        }
    }
    public function toBack()
    {
        $this->emit('toBack');
    }

public function sendMessage($num)
{
    $message='';
    $numero = "+212".$num;
    $url = "https://api.whatsapp.com/send?text=".urlencode($message)."&phone=".urlencode($numero);
    return redirect()->away($url)->with(['target' => '_blank']);

}
public function downloadFile($filePath)
{
    $path = storage_path('app/public/' . $filePath);
    if (!File::exists($path)) {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"error de telechargement de cv😓😓"
        ]);
    }
    $this->dispatchBrowserEvent('alert',[
        'type'=>'success',
        'message'=>"telechargement de cv avec success😉😉"
    ]);
    return response()->download($path);
}

public function accepterCandidat($id){
// accepter un candidature
    try {
        $con=HistoriqueCandidature::where('candidatureId', $id)->get();
        if ($con->first()==null){
            // si n'accepter pas deja
        $hc=new HistoriqueCandidature();
        $hc->status="en discussion";
        $hc->dateSoumission=now()->toDateString();
        $hc->candidatureId=$id;
        $hc->save();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"demande accepter avec success😉😉"
        ]);
        session()->put('opC','all');
        $this->emit('refreshComponent');
        }else{
            // si deja accepter
            $this->dispatchBrowserEvent('alert',[
                'type'=>'info',
                'message'=>"deja accepter🙂🙂"
            ]);
        }
        }catch (\Throwable $th) {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"error d'accepter 😓😓"
        ]);
    }
}

public function mount($prop1)
{   
    $this->histcondidat=Candidature::where('offreId',session('idOffre')??$prop1)->with('historique_condidatures')->get();
    $this->prop1=$prop1;
    if(session('opC')=='delete')
    {
        $this->change('delete',session('idC'));
    }
}


public function confirmationDelete($id){
    try {
        session()->put('idC',$id);
        $con=Candidature::find($id);
        $this->idDelete=$con->idCandidature;
        $this->offreDelete=$con->offres->titreOffre;
    } catch (\Throwable $th) {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"error 😓😓"
        ]);
    }
}
public function delete()
{
    try {
        // dd(Candidature::find($this->idDelete));
        Candidature::find($this->idDelete)->delete();
        session()->put('opC','all');
        $this->emit('refreshComponent');
    } catch (\Throwable $th) {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"error de suppression 😓😓"
        ]);
    }
}
}
