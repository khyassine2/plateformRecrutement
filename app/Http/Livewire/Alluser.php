<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\ville;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Alluser extends Component
{
    use WithPagination;
    public $ages=[],$villeSearch,$niveauEtude;
    public function render()
    {
        $users = User::query()
        ->when($this->villeSearch, function($query, $villeSearch) {
            return $query->where('ville', $villeSearch);
        })
        ->when($this->niveauEtude, function($query, $niveauEtude) {
            return $query->where('niveauEtude', $niveauEtude);
        })
        ->join('level_sites', 'utilisateur.levelsite_id', '=', 'level_sites.idLevelSite')
        ->join('donnes_utilisateurs', 'utilisateur.idUtilisateur', '=', 'donnes_utilisateurs.utilisateurId')
        ->join('roles', 'utilisateur.Role_id', '=', 'roles.idRole')
        ->where('roles.nomRole', '=', 'user')
        ->orderByDesc('level_sites.nomLevelSite')
        ->orderByRaw('RAND()')
        ->paginate(5);
        foreach ($users as $key=>$user) {
            $dateOfBirth = Carbon::parse($user->dateNaissance);
            $this->ages[$key] = $dateOfBirth->diffInYears(Carbon::now());
        }
        return view('livewire.alluser',['users'=>$users,'villes'=>ville::all()])->extends('layouts.app')->section('content');
    }
    public function updating($name,$value){
        if($name==='niveauEtude' || $name=='villeSearch' ){
            $this->resetPage();
        }
    }
}
