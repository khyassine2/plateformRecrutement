<?php

namespace App\Http\Livewire\Layoutslivewire\Dashboard;

use App\Models\Candidature;
use App\Models\demande;
use App\Models\Entreprise;
use App\Models\resultatTest;
use App\Models\Role;
use App\Models\SecteurActiviter;
use App\Models\TestCompetence;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboardsidebar extends Component
{
    public $type;
    public function render()
    {
        if(Auth::guard('web')->check())
        {
            if(Auth::guard('web')->user()->roles->nomRole=='admin')
            {
                $countTest=TestCompetence::all()->count();
            }elseif(Auth::guard('web')->user()->roles->nomRole=='user')
            {
                $countDemande=demande::where('utilisateurId',Auth::guard('web')->user()->idUtilisateur)->count();
                $countCandidatures=Candidature::where('utilisateurId',Auth::guard('web')->user()->idUtilisateur)->count();
            }
        }elseif(Auth::guard('entreprise')->check())
        {
            $countTest=TestCompetence::where('hasEntrepriseId',Auth::guard('entreprise')->user()->idEntreprise)->count();
        }
        return view('livewire.layoutsLivewire.dashboard.dashboardsidebar',['count'=>User::select('idUtilisateur')->count(),'countRole'=>Role::select('idRole')->count(),'countEn'=>Entreprise::select('idEntreprise')->count(),'countSe'=>SecteurActiviter::select('idSecteurActiviter')->count(),'countDemande'=>$countDemande??0,'countCandidatures'=>$countCandidatures??0,'countTest'=>$countTest??0]);
    }
    public function changeType($type,$op=null,$role=null){
        $this->emit('type',$type,$op);
        $this->type=$type;
        // $this->emit('op',$op);
        // $this->emit('role',$role);
    }
}
