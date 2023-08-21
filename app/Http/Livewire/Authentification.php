<?php

namespace App\Http\Livewire;

use App\Models\DonnesUtilisateur;
use App\Models\Entreprise;
use App\Models\SecteurActiviter;
use App\Models\User;
use App\Models\ville;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;


class Authentification extends Component
{
    use WithFileUploads;
    public $password,$password_confirmation,$email,$nom,$prenom,$telephone,$dateNaissance,$photo,$cv,$experiances,$competences,$niveauEtude,$ville;
    public $nomentreprise,$emailentreprise,$passwordentreprise,$passwordentreprise_confirmation,$telephoneEntreprise,$sitewebEntreprise,$villeEntreprise,$photoEntreprise,$adresseEntreprise,$secteurEntreprise;
    public $type='utilisateur';
    public $registerForm = true;
    public $step=1;
    public function render()
    {
        return view('livewire.authentification',['villeC'=>ville::all(),'secteurActiviter'=>SecteurActiviter::all()])->extends('layouts.app')->section('content');
    }
    public function mount()
    {
        if(request('op')=='login')
        {
            $this->registerForm=true;
            session()->put('registerForm',false);
        }elseif(request('op')=='register')
        {
            $this->registerForm=false;
            session()->put('registerForm',true);

        }
    }
    public function nextStep(){
        if($this->type=='utilisateur')
        {
            if($this->step==1){
                $this->validate([
                    'email' => 'required|email',
                    'password' => 'required|min:8|confirmed',
                ]);
                $this->step++;
            }elseif($this->step==2){
                $this->validate([
                    'nom'=>'required',
                    'prenom'=>'required',
                    'ville'=>'required',
                    'telephone'=>'required|regex:/^\+212\d{9}$/',
                    'dateNaissance'=>'required|date',
                    'photo'=>'nullable|image|max:2048'
                ]);
                $this->step++;
            }
        }elseif($this->type=='entreprise')
        {
            if($this->step==1){
                $this->validate([
                    'emailentreprise' => 'required|email',
                    'passwordentreprise' => 'required|min:8|confirmed',
                ]);
                
                $this->step++;
            }elseif($this->step==2){
                $this->validate([
                    'nomentreprise' => 'required',
                    'sitewebEntreprise' => 'required',
                    'telephoneEntreprise'=>'required|regex:/^\+212\d{9}$/',
                    'adresseEntreprise' => 'required',
                    'villeEntreprise' => 'required',
                    'photoEntreprise' => 'required',

                ]);
                $this->step++;
            }
        }


    }

    public function previousStep(){
        $this->step--;
    }
    public function login(){
        if (Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->password],true)) {
            // l'utilisateur existe dans la table `users`
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Votre inscription réussie😉😉"
            ]);
            session()->put('registerForm',!session('registerForm'));
            $this->resetInputFields();
            return redirect()->to('/');
        } elseif (Auth::guard('entreprise')->attempt(['emailEntreprise' => $this->email, 'password' => $this->password])) {
            
            // l'utilisateur existe dans la table `entreprise`
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Votre inscription réussie😉😉"
            ]);
            session()->put('registerForm',!session('registerForm'));
            $this->resetInputFields();
            return redirect()->to('/');
        } else {
            // l'utilisateur n'existe pas dans les deux tables
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"login or password invalid😓😓"
            ]);
        }

    }
    public function register()
    {
        $this->registerForm = !$this->registerForm;
        session()->put('registerForm',$this->registerForm);
    }
    private function resetInputFields(){
        $this->nom = '';
        $this->prenom = '';
        $this->email = '';
        $this->password = '';
    }
    public function registerCreate(){
        if($this->type=='utilisateur'){
            $this->validate([
                'cv'=>'required',
                'experiances'=>'required',
                'competences'=>'required',
                'niveauEtude'=>'required',
            ]);
            $this->validate([
                'cv' => 'required|max:1024',
            ]);
            DB::transaction(function () {
                $user=User::create(['nomUtilisateur' => $this->nom,'prenomUtilisateur'=>$this->prenom, 'email' => $this->email,'password' => Hash::make($this->password),'telephone'=>$this->telephone,'dateNaissance'=>$this->dateNaissance,'photo'=>$this->photo->store('photos','public'),'dateNaissance'=>$this->dateNaissance,'ville'=>$this->ville]);
                $donner=DonnesUtilisateur::create(['cv'=>$this->cv->store('attachement','public'),'experiances'=>$this->experiances,'competences'=>$this->competences,'niveauEtude'=>$this->niveauEtude,'utilisateurId'=>$user->idUtilisateur]);
        if($user && $donner)
            {
                if (Auth::attempt(['email' => $this->email, 'password' => $this->password],true)) {
                        // l'utilisateur existe dans la table `users`
                        $this->dispatchBrowserEvent('alert',[
                            'type'=>'success',
                            'message'=>"Votre inscription réussie😉😉"
                        ]);
                        session()->put('registerForm',!session('registerForm'));
                        $this->resetInputFields();
                        return redirect()->to('/');
                    }else{
                        // l'utilisateur n'existe pas dans les deux tables
                        $this->dispatchBrowserEvent('alert',[
                            'type'=>'error',
                            'message'=>"error de connexion😓😓"
                        ]);
                    }

                }
            });
        }elseif($this->type=='entreprise'){
            $this->validate([
                'secteurEntreprise' => 'required',
            ]);
            DB::transaction(function(){
                $entreprise=Entreprise::create(['nomEntreprise' => $this->nomentreprise, 'emailEntreprise' => $this->emailentreprise,'password' => Hash::make($this->passwordentreprise),'adresseEntreprise'=>$this->adresseEntreprise,'siteWebEntreprise'=>$this->sitewebEntreprise,'villeEntreprise'=>$this->villeEntreprise,'telephone'=>$this->telephoneEntreprise,'photo'=>$this->photoEntreprise->store('photo','public')]);
                foreach($this->secteurEntreprise as $secteur) {
                    $entreprise->secteurs()->attach($secteur);
                }
                if($entreprise){
                    if (Auth::guard('entreprise')->attempt(['emailEntreprise' => $this->emailentreprise, 'password' => $this->passwordentreprise],true)) {
                        // l'utilisateur existe dans la table `users`
                        $this->dispatchBrowserEvent('alert',[
                            'type'=>'success',
                            'message'=>"Votre inscription réussie😉😉"
                        ]);
                        session()->put('registerForm',!session('registerForm'));
                        $this->resetInputFields();
                        return redirect()->to('/');
                    }else{
                        // l'utilisateur n'existe pas dans les deux tables
                        $this->dispatchBrowserEvent('alert',[
                            'type'=>'error',
                            'message'=>"error de connexion😓😓"
                        ]);

                    }

                }
            });


        }

    }
}
