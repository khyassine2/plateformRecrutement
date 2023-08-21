<?php

namespace App\Http\Livewire;

use App\Events\SendEmail;
use App\Models\demande;
use App\Models\demandestage;
use App\Models\SecteurActiviter;
use App\Models\ville;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;
use Psy\VersionUpdater\Downloader;

class AlldemandeStage extends Component
{
    use WithPagination;
    public $paginationEnabled = true;
    public $ages=[],$villes=[],$typeFormation,$op='allDemande',$demandedata,$iddemande,$age,$cv,$demandeSugestion,$dateDiff,$dateDebut,$dateFin,$email,$dateDebutStage,$dureeStage,$niveauEtude;
    public $villeSearch,$select,$formationSearch,$typeStageSearch;
    public $affemail=false,$afftele=false,$eroure='';
    public $showAlert = false;
    public $showEmail = false;
    public $test = false;
    public $object,$message,$typeDemandeSearch;
    protected $listeners = ["send" => '$refresh'];
    public function render()
    {
        $data = demande::query()
        ->when($this->villeSearch, function($query, $villeSearch) {
            return $query->where('villeId', $villeSearch);
        })
        ->when($this->formationSearch, function($query, $formationSearch) {
            return $query->where('typeFormation', $formationSearch);
        })
        ->when($this->typeStageSearch, function($query, $typeStageSearch) {
            return $query->where('typeStage', $typeStageSearch);
        })
        ->when($this->dateDebutStage, function($query, $dateDebutStage) {
            return $query->where('DateDebutStage','>=', $dateDebutStage);
        })
        ->when($this->dureeStage, function($query, $dureeStage) {
            return $query->where('dureeStage', '=', $dureeStage);
        })
        ->when($this->niveauEtude, function($query, $niveauEtude) {
            return $query->where('niveauEtude', '=', $niveauEtude);
        })
        ->when($this->typeDemandeSearch, function($query, $typeDemandeSearch) {
            return $query->where('typeDemande', '=', $typeDemandeSearch);
        })->where('typeFormation','!=',0)
        ->join('utilisateur', 'demande.utilisateurId', '=', 'utilisateur.idUtilisateur')
        ->join('level_sites', 'utilisateur.levelsite_id', '=', 'level_sites.idLevelSite')
        ->inRandomOrder()
        ->orderByDesc('level_sites.nomLevelSite')
        ->orderByRaw('RAND()')
        ->paginate(10);
        foreach ($data as $key=>$user) {
            $dateOfBirth = Carbon::parse($user->dateNaissance);
            $this->ages[$key] = $dateOfBirth->diffInYears(Carbon::now());
        }
        return view('livewire.alldemande-stage',['demande'=>$data])->extends('layouts.app')->section('content');
    }
    public function mount(){
        $this->villes=ville::all();
        $this->typeFormation=SecteurActiviter::all();
        if(request('idD') && request('opp')=='detailsDemande'){
            session()->put('opAlldemande',request('opp'));
            session()->put('idAlldemande',request('idD'));
            $this->detailsDemande(session('idAlldemande'));
        }
        if(session('opAlldemande')=='detailsDemande')
        {
            $this->change('detailsDemande',session('idAlldemande'));
        }
    }
    public function updating($name){
        if($name==='formationSearch' || $name=='villeSearch' || $name='DateDebutStage'){
            $this->resetPage();
        }
    }
    public function change($op,$id=null)
    {
        session()->put('opAlldemande',$op);
        if($op=='allDemande'){
            $this->resetPage();
            $this->showEmail=false;
            session()->put('showEmail',false);
        }elseif($op=='detailsDemande'){
            session()->put('idAlldemande',$id);
            $this->detailsDemande(session('idAlldemande'));
        }elseif($op=='showEmail'){
            
            session()->put('opAlldemande','detailsDemande');
            $this->showEmail=true;
            session()->put('showEmail',true);
        }
    }
    public function detailsDemande($id)
    {
        $this->iddemande=$id;
        $this->demandedata=demande::find($this->iddemande);
        if($this->demandedata->typeDemande=='stage')
        {
            $dateOfBirth = Carbon::parse($this->demandedata->utilisateurs->dateNaissance);
            $this->age = $dateOfBirth->diffInYears(Carbon::now());
            $dateD = Carbon::createFromFormat('Y-m-d',$this->demandedata->DateDebutStage)??'';
            $dateF = Carbon::createFromFormat('Y-m-d',$this->demandedata->DateFinStage)??'';
            $this->dateDebut = $dateD->format('m-Y')??'';
            $this->dateFin = $dateF->format('m-Y')??'';
            $this->email=$this->demandedata->utilisateurs->email;
            $this->cv='/storage/'.$this->demandedata->utilisateurs->donners->cv;
        }elseif($this->demandedata->typeDemande=='emploi')
        {
            $dateOfBirth = Carbon::parse($this->demandedata->utilisateurs->dateNaissance);
            $this->age = $dateOfBirth->diffInYears(Carbon::now());
            $this->email=$this->demandedata->utilisateurs->email;
            $this->cv='/storage/'.$this->demandedata->utilisateurs->donners->cv;
        }

        // autre Sugestion Demande
        $this->demandeSugestion = demande::where(function($query) {
            $query->where('typeFormation', $this->demandedata->typeFormation)
                ->orWhere('typeFormation', '!=', $this->demandedata->typeFormation);
        })->where('typeFormation','!=',0)
        ->where('idDemande', '!=', $this->iddemande)
        ->get();
        // pour recuperer la difference entre date now et date publie
        foreach ($this->demandeSugestion as $key=>$item) {
            $diff = $item->created_at->diff(Carbon::now());
            if ($diff->y > 0) {
                $this->dateDiff[$key] = "il y a " . $diff->y . " an" . ($diff->y > 1 ? "s" : "");
            } elseif ($diff->m > 0) {
                $this->dateDiff[$key] = "il y a " . $diff->m . " mois";
            } elseif ($diff->d > 0) {
                $this->dateDiff[$key] = "il y a " . $diff->d . " jour" . ($diff->d > 1 ? "s" : "");
            } elseif ($diff->h > 0) {
                $this->dateDiff[$key] = "il y a " . $diff->h . " heure" . ($diff->h > 1 ? "s" : "");
            } elseif($diff->i >0) {
                $this->dateDiff[$key] = "il y a " . $diff->i . " minute" . ($diff->i > 1 ? "s" : "");
            }else{
                $this->dateDiff[$key] = "il y a " . $diff->s . " seconde" . ($diff->s > 1 ? "s" : "");
            }
        }

    }
    public function verify($type,$user=null)
    {
        if(Auth::guard('entreprise')->check() || Auth::guard('web')->user()->roles->nomRole=='admin' )
        {
            if($type=='telephone'){
                $this->afftele=true;
            }elseif($type=='email'){
                $this->affemail=true;
            }elseif($type=='cv'){
                try {
                    $this->dispatchBrowserEvent('alert',[
                        'type'=>'success',
                        'message'=>"cv telecharger avec success."
                    ]);
                    return Storage::disk('public')->download($user['donners']['cv'],$user['nomUtilisateur'].'_'.$user['prenomUtilisateur'].'_cv');

                } catch (\Throwable $th) {
                    $this->dispatchBrowserEvent('alert',[
                        'type'=>'error',
                        'message'=>"error de telecharger le cv."
                    ]);
                }
            }
        }elseif(Auth::guard('web')->user()->idUtilisateur==$user['idUtilisateur']){
            if($type=='telephone'){
                $this->afftele=true;
            }elseif($type=='email'){
                $this->affemail=true;
            }elseif($type=='cv'){
                try {
                    $this->dispatchBrowserEvent('alert',[
                        'type'=>'success',
                        'message'=>"cv telecharger avec success."
                    ]);
                    return Storage::disk('public')->download($user['donners']['cv'],$user['nomUtilisateur'].'_'.$user['prenomUtilisateur'].'_cv');

                } catch (\Throwable $th) {
                    $this->dispatchBrowserEvent('alert',[
                        'type'=>'error',
                        'message'=>"error de telecharger le cv."
                    ]);
                }
            }
        }else
        {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Vous devez être connecté <br> en tant  que recruteur pour accéder <br> aux $type de cet étudiant."
            ]);
        }

    }
    public function sendemail($data=null)
    {

        try {
            event(new SendEmail($data,$this->object,$this->message,'a'));
            $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Mail envoyer avec success!!"
            ]);
            session()->put('showEmail',false);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error d'envoyer email!!"
                ]);
        }

    }
}
