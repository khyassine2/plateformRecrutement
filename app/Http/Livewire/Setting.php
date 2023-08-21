<?php

namespace App\Http\Livewire;

use App\Models\Entreprise;
use App\Models\SecteurActiviter;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ville;
use App\Models\VisiteCompte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Setting extends Component
{
    use WithFileUploads;
    public $type='utilisateur';
    // les variable pour utilisateur
    public $secteurEntreprise1;
    public $id1,$nom,$prenom,$email,$telephone,$dateNaissance,$photo,$nomRole,$siteWebEntreprise,$ville,$adresse,$cv,$experiances,$competences,$niveauEtude,$extension,$etatDeleteFile,$password,$passwordNew,$passwordNew_confirmation,$secteur=[],$secteurEntreprise=[],$erourePassword=false;
    // les variable pour Entreprise
    // public $idEntreprise,$nomEntreprise,$adresseEntreprise,$emailEntreprise,$siteWebEntreprise,$villeEntreprise,$telephoneEntreprise,$photoEntreprise;
    protected $rules=[
        'secteurEntreprise.*'=>'required',
    ];
    protected $listeners = ['selectChanged' => 'handleSelectChanged'];
    public function render()
    {
        // if(!Gate::allows('user') && !Gate::allows('admin') && !Gate::allows('entreprise')){
        //     session()->pull('typee');
        //     abort(403,'n est pas autorizé');
        // }
       try {
            if(Auth::guard('web')->check()){
                $visite=VisiteCompte::where('visiteCompteId',Auth::guard('web')->user()->idUtilisateur)->get();
        }else{
            $visite='';
        }

        if(Auth::guard('web')->check()){
            $data=Auth::guard('web')->user();
            $this->type='utilisateur';
        }elseif(Auth::guard('entreprise')->check()){
            $data=Auth::guard('entreprise')->user();
            $this->type='entreprise';
        }
       } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>Str::limit($th->getMessage(),30)
            ]);
       }
        return view('livewire.setting',['user'=>$data,'ville1'=>ville::all(),'visiteCompte'=>$visite])->extends('layouts.app')->section('content');
    }
    public function mount(){
        if(Auth::guard('web')->check()){
            $data=Auth::guard('web')->user();
            $this->type='utilisateur';
            $this->id=$data->idUtilisateur;
            $this->nom=$data->nomUtilisateur;
            $this->prenom=$data->prenomUtilisateur;
            $this->email=$data->email;
            $this->telephone=$data->telephone;
            $this->dateNaissance=$data->dateNaissance;
            $this->photo=$data->photo;
            $this->nomRole=$data->roles()->first()->nomRole;
            $this->cv=$data->donners->cv??'';
            $this->ville=$data->ville;
            $ex=explode('.',$this->cv);
            if(isset($ex[1])){
                $this->extension=strtoupper($ex[1]);
            }
            $this->competences=$data->donners->competences??'';
            $this->experiances=$data->donners->experiances??'';
            $this->niveauEtude=$data->donners->niveauEtude??'';
        }elseif(Auth::guard('entreprise')->check()){
            $data=Auth::guard('entreprise')->user();
            $this->type='entreprise';
            $this->nom=$data->nomEntreprise;
            $this->adresse=$data->adresseEntreprise;
            $this->email=$data->emailEntreprise;
            $this->siteWebEntreprise=$data->siteWebEntreprise;
            $this->ville=$data->villeEntreprise;
            $this->telephone=$data->telephone;
            $this->photo=$data->photo;
            $this->secteurEntreprise=$data->secteurs()->get()->toArray();
            $this->secteur=SecteurActiviter::all();
            // dd($data->secteurs()->pluck('nomSecteurActiviter', 'idSecteurActiviter')->first());

        }
    }
    public function handleSelectChanged($value)
    {
        $nouvelleSelection = collect($value)->map(function ($id) {
            return SecteurActiviter::find($id);
        });
        $this->secteurEntreprise=$nouvelleSelection;
    }
    public function telechargerCv(){
        try {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"CV telecharger avec success."
            ]);
            return Storage::disk('public')->download($this->cv,$this->nom.'_'.$this->prenom.'_cv');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de telecharger le cv."
            ]);
        }
    }
    public function removecv(){
        try {
            $data=Auth::guard('web')->user();
            $a=Storage::delete($this->cv);
            $data->donners->cv=null;
            $data->save();
            $data->donners->save();
            $this->etatDeleteFile=$a;
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"CV supprimer avec success😉😉"
            ]);
            $this->redirect('setting');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de supprimer le cv😓😓"
            ]);
        }
    }
    public function modifier(){
      try {
        if(Auth::guard('web')->check()){
            $data=Auth::guard('web')->user();
            $this->type='utilisateur';
            $data->nomUtilisateur=$this->nom;
            $data->prenomUtilisateur=$this->prenom;
            $data->email=$this->email;
            $data->telephone=$this->telephone;
            $data->ville=$this->ville;
            $data->dateNaissance=$this->dateNaissance;
           if(Auth::guard('web')->user()->roles->nomRole=='user')
           {
            $data->donners->competences=$this->competences;
            $data->donners->experiances=$this->experiances;
            $data->donners->niveauEtude=$this->niveauEtude;
            if(isset($this->cv[0]) && $this->cv[0] instanceOf \Illuminate\Http\UploadedFile){
                Storage::delete('public/photos/'.Auth::guard('web')->user()->donners->cv);
                $data->donners->cv=$this->cv[0]->store('attachement','public');
            }else{
                $data->donners->cv=$this->cv;
            }
           }
            if($this->photo instanceOf \Illuminate\Http\UploadedFile){
                $data->photo=$this->photo->store('photos','public');
            }else{
                $data->photo=$this->photo;
            }
           
            if(strlen($this->password)>=1){
                $this->validate([
                    'password'=>'required',
                    'passwordNew'=>'required|min:8|confirmed',
                ]);
                if (!Hash::check($this->password, $data->password)) {
                    $this->erourePassword=true;
                }elseif(Hash::check($this->password, $data->password)){
                $data->password = Hash::make($this->passwordNew);
                $this->erourePassword=false;
                }
            }
            if($this->erourePassword==false){
                
           if(Auth::guard('web')->user()->roles->nomRole=='user')
           {
                $data->donners->save();
           }
                $data->save();
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"Utilisateur modifier avec success😉😉"
                ]);
                return redirect('setting');
            }

        }elseif(Auth::guard('entreprise')->check()){
            $data=Auth::guard('entreprise')->user();
            $this->type='entreprise';
            $data->nomEntreprise=$this->nom;
            $data->adresseEntreprise=$this->adresse;
            $data->emailEntreprise=$this->email;
            $data->siteWebEntreprise=$this->siteWebEntreprise;
            $data->villeEntreprise=$this->ville;
            $data->telephone=$this->telephone;
            if($this->photo instanceOf \Illuminate\Http\UploadedFile){
                Storage::delete('public/photos/'.Auth::guard('entreprise')->user()->photo);
                $data->photo=$this->photo->store('photos','public');
            }else{
                $data->photo=$this->photo;
            }
            $data->secteurs()->detach();
            foreach($this->secteurEntreprise as $secteur) {
                $secteur = SecteurActiviter::find($secteur['idSecteurActiviter']);
                if($secteur) {
                    $data->secteurs()->attach($secteur);
                }
            }
            if(strlen($this->password)>=1){
                $this->validate([
                    'password'=>'required',
                    'passwordNew'=>'required|min:8|confirmed',
                ]);
                if (!Hash::check($this->password, $data->password)) {
                    $this->erourePassword=true;
                    // dd('cc');
                }elseif(Hash::check($this->password, $data->password)){
                $data->password = Hash::make($this->passwordNew);
                $this->erourePassword=false;
                }
            }
            if($this->erourePassword==false){
                $data->save();
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"Entreprise modifier avec success😉😉"
                ]);
                return redirect('setting');
            }
        }
      } catch (\Throwable $th) {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"error😓😓"
        ]);
      }
       }
    
}
