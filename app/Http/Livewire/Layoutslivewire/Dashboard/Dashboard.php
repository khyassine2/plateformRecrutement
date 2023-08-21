<?php

namespace App\Http\Livewire\Layoutslivewire\Dashboard;

use App\Models\Candidature;
use App\Models\demande;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\resultatTest;
use App\Models\TestCompetence;
use App\Models\User;
use App\Models\VisiteCompte;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cookie;
class Dashboard extends Component
{
    use WithPagination;
    public $typee='all';
    protected $listeners=[
        'type'=>'recevoirtype',
    ];
    public function render()
    {
        // if(!Gate::allows('admin')){
        //     abort(403,'ne authorizé');
        //     session()->pull('typee');
        // }
        // if(!Gate::allows('entreprise')){
        //     abort(403,"ne authorizé");
        //     session()->pull('typee');
        // }
    if(Auth::guard('web')->check()){
        $id=Auth::guard('web')->user()->idUtilisateur;
        if(Auth::guard('web')->user()->roles->nomRole=='user')
        {
            // recuperer les visite de compte 
            $visite=VisiteCompte::where('visitecompteid',Auth::guard('web')->user()->idUtilisateur)->get();
            // dd($visite);
            // recuperer le count des postulation d'utilisateur connecter
            $countOffre=Candidature::where('utilisateurId',Auth::guard('web')->user()->idUtilisateur)->count();
            // recuperer le count de demande d'utilisateur connecter
            $countDemande=demande::where('utilisateurId',Auth::guard('web')->user()->idUtilisateur)->count();
            // recuperer le nombre de visite par mois
            $moisDebut = Carbon::now()->startOfMonth();
            $moinFin = Carbon::now()->endOfMonth();
            $viewParMois = DB::table('visite_comptes')
                            ->whereBetween('created_at', [$moisDebut, $moinFin])
                            ->where('visitecompteid',Auth::guard('web')->user()->idUtilisateur)
                            ->count();
            // recuperer le count de test passer
            $countTest=resultatTest::where('utilisateurId',$id)->get()->count()??0; 
        }elseif(Auth::guard('web')->user()->roles->nomRole=='admin')
        {
            // recuperer le count des test
            $countTest=TestCompetence::all()->count()??0;
             // recuperer le count de offre publie
            $countOffre=Offre::all()->count(); 
        }
    }elseif(Auth::guard('entreprise')->check()){
        $id='';
        // recuperer les visite de compte 
        $visite=VisiteCompte::where('visitecompteid',Auth::guard('entreprise')->user()->idEntreprise)->get();
        // recuperer le nombre de visite par mois
        $moisDebut = Carbon::now()->startOfMonth();
        $moinFin = Carbon::now()->endOfMonth();
        $viewParMois = DB::table('visite_comptes')
                            ->whereBetween('created_at', [$moisDebut, $moinFin])
                            ->where('visitecompteid',Auth::guard('entreprise')->user()->idEntreprise)
                            ->count();
        // recuperer le count de test publie
        $countTest=TestCompetence::where('hasEntrepriseId',Auth::guard('entreprise')->user()->idEntreprise)->count(); 
        // recuperer le count de offre publie
        $countOffre=Offre::where('hasEntrepriseId',Auth::guard('entreprise')->user()->idEntreprise)->count();
    }
        return view('livewire.layoutsLivewire.dashboard.dashboard',['count'=>User::all()->count()??0,'countEntreprise'=>Entreprise::all()->count()??0,'countTest'=>$countTest??0,'visiteCompte'=>$visite??0,'countOffre'=>$countOffre??0,'countDemande'=>$countDemande??0,'viewParMois'=>$viewParMois??0])->extends('layouts.app')->section('content');
    }
    public function recevoirtype($type,$op){
        session()->put('typee',$type);
        $this->typee=$type;
    }
    public function mount()
    {
        // Cookie::queue('owt-cookie', 'Setting Cookie from Online Web Tutor', 120);
    }

}

