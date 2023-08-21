<?php

namespace App\Http\Livewire;

use App\Models\Entreprise;
use App\Models\SecteurActiviter;
use App\Models\ville;
use App\Models\VisiteCompte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AllEntreprise extends Component
{
    use WithPagination;
    public $paginationEnabled = true;
    public $op='all',$ville,$villeSearch,$secteur,$secteurSearch,$nomSearch,$SortSearch='random',$oneEntreprise,$EntrepriseRef;
    public function render()
    {
        $subquery = DB::table('entreprise_has_secteurs')
        ->select('entrepriseId')
        ->distinct();
        $data = Entreprise::query()
        ->when($this->villeSearch, function($query, $villeSearch) {
            return $query->where('villeEntreprise', $villeSearch);
        })
        ->when($this->nomSearch, function($query, $nomSearch) {
            // dd(Entreprise::where('nomEntreprise','like','%'.$nomSearch.'%')->get());
            return $query->where('nomEntreprise','like','%'.$nomSearch.'%');
        })
        ->when($this->secteurSearch, function ($query, $secteurSearch) use ($subquery) {
            return $query->whereIn('idEntreprise', $subquery->where('secteurId', '=', $secteurSearch));
        })
        ->when($this->SortSearch, function ($query, $SortSearch) {
            switch ($SortSearch) {
                case 'random':
                    return $query->orderByRaw('RAND()');
                    break;
                case 'asc':
                    return $query->orderBy('nomEntreprise','asc');
                    break;
                case 'desc':
                    return $query->orderBy('nomEntreprise','desc');
                    break;
                default:
                    return $query;
            }
        })
        ->whereIn('idEntreprise', $subquery)
        ->paginate(6);
        return view('livewire.all-entreprise',['entreprise'=>$data])->extends('layouts.app')->section('content');
    }
    public function mount()
    {
        if(session('opAllEntreprise')=='detailsEntreprise')
        {
            $this->change('detailsEntreprise',session('idAllEntreprise'));
        }
        $this->ville=ville::all();
        $this->secteur=SecteurActiviter::all();
        if(request('idD') && request('opp')=='detailsEntreprise'){
            // dd(request('idD'),request('opp'));
            $this->op=request('opp');
            $this->change(request('opp'),request('idD'));
        }
    }
    public function change($op,$id=null)
    {
        if($op=='detailsEntreprise')
        {
            session()->put('idAllEntreprise',$id);
            // recuperer entreprise apres id
            $entreprise=Entreprise::find(session('idAllEntreprise'));
            // tester pour recuperer id et visitor
            if(Auth::guard('web')->check()){
                $connecte=Auth::guard('web')->user();
                $visitor=$connecte->idUtilisateur;
            }elseif(Auth::guard('entreprise')->check())
            {
                $connecte=Auth::guard('entreprise')->user();
                $visitor=$connecte->idEntreprise;
            }
            // recuperer si il y'a deja visite ce compte
            $compteVisite = VisiteCompte::firstOrNew(['visiteCompteId' =>session('idAllEntreprise'),'connecteCompteId'=>$visitor]);
            if($visitor!==$compteVisite){
            if(!$compteVisite->exists){
                // si il n'exsist pas il ajouter
                $visit = new VisiteCompte();
                $visit->visitecompteid = $entreprise->idEntreprise;
                $visit->type_visiteCompteId = (int)get_class($entreprise)::TYPE_ID;
                $visit->connectecompteid = $visitor;
                $visit->type_connecteCompteId = (int)get_class($connecte)::TYPE_ID;
                $visit->save();
                }
            }
            // pour charger les infos Entreprise
            $this->oneEntreprise=Entreprise::find(session('idAllEntreprise'));
            // pour recuperer les entreprise qui ont la meme ville
            $this->EntrepriseRef = Entreprise::where(function ($query) {
                $query->whereHas('secteurs', function ($query) {
                    $query->whereIn('idSecteurActiviter', $this->oneEntreprise->secteurs->pluck('idSecteurActiviter')->toArray());
                });
            })
            ->where(function ($query) {
                $query->where('villeEntreprise', $this->oneEntreprise->villeEntreprise)
                    ->orWhere('villeEntreprise', '!=', $this->oneEntreprise->villeEntreprise);
            })
            ->where('idEntreprise', '!=', $this->oneEntreprise->idEntreprise)
            ->limit(4)
            ->get();
            session()->put('opAllEntreprise',$op);
        }elseif($op=='all')
        {
            session()->put('opAllEntreprise','all');
        }
    }
    public function updating($name){
        if($name==='formationSearch' || $name=='villeSearch' || $name='DateDebutStage'){
            $this->resetPage();
        }
    }
}
