<?php

namespace App\Http\Livewire\Admin;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\DonnesUtilisateur;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class Utilisateur extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $fichier;
    public $search,$searchRole,$select='nomUtilisateur';
    public $nom,$prenom,$email,$password,$telephone,$dateNaissance,$photo,$photo1,$Valrole;
    public $nomRole;
    public $op='all';
    protected $rules=[
            'nom'=>'required',
            'prenom'=>'required',
            'email'=>'required',
            'password'=>'required',
            'telephone'=>'required',
            'dateNaissance'=>'required',
            'photo'=>'required',
    ];
    protected $queryString=[
        'search' => ['except' => ''],
        'searchRole' => ['except' => ''],
    ];
    protected $listeners=[
        'op'=>'recevoirop',
    ];
    public function recevoirop($op){
        // pour recuperer op a partire de dashboard-sidebar
        $this->op=$op;
    }
    public function mount(){
        if(session('opU')=='edit')
        {
            $this->edit(session('idU'));
        }
        elseif(session('opU')=='delete')
        {
            $this->change('delete',session('idU'));
        }
    }
    public function render()
    {
        if(!Gate::allows('admin')){
            session()->pull('typee');
            abort(403,'n est pas autorizé');
        }
        $val=$this->select=='Role_id'?$this->searchRole:$this->search;
        return view('livewire.admin.utilisateur',['utilisateur'=>User::where($this->select,'like','%'.$val.'%')->paginate(3),'role'=>Role::all(),'DonnesUtilisateur'=>DonnesUtilisateur::all(),'count'=>User::all()->count()]);
    }
    public function updatedsearch(){
        $this->resetPage();
    }
    public function resetInput(){
        $this->nom='';
        $this->prenom='';
        $this->email='';
        $this->password='';
        $this->telephone='';
        $this->dateNaissance='';
        $this->photo='';
        $this->photo1='';
        $this->Valrole='';
    }
    public function change($op,$id=null){
        // changer la valuer de op pour destinct entre les bloque
        session()->put('opU',$op);
        if(isset($id)){
            session()->put('idU',$id);
            $user=User::find($id);
            $this->id=$user->idUtilisateur;
            $this->nom=$user->nomUtilisateur;
        }
    }
    public function ajouterUtilisateur()
    {
        // ajouter un utilisateur
        try {
            $this->validate();
            $user=new User();
            $user->nomUtilisateur=$this->nom;
            $user->prenomUtilisateur=$this->prenom;
            $user->email=$this->email;
            $user->password=Hash::make($this->password);
            $user->telephone=$this->telephone;
            $user->dateNaissance=$this->dateNaissance;
            $user->photo=$this->photo->store('photos','public');
            $user->Role_id=$this->Valrole;
            $user->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Utilisateur ajouter avec success 😉😉"
            ]);
            session()->put('opU','all');
            $this->resetInput();
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error d'ajouter Utilisater😓😓"
            ]);
        }
    }

    public function delete()
    {
        // supprimer un utilisateur
        try {
            User::where('idUtilisateur',session('idU'))->delete();
            session()->put('opU','all');
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Utilisateur supprimer avec success😉😉"
            ]);
        } catch (Exception) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Error de supprimer Utilisateur😓😓"
            ]);
        }

    }
    public function edit($id)
    {
        // charger les donners
        try {
            session()->put('idU',$id);
            session()->put('opU','edit');
            $user=User::find($id);
            $this->id=$user->idUtilisateur;
            $this->nom=$user->nomUtilisateur;
            $this->prenom=$user->prenomUtilisateur;
            $this->email=$user->email;
            $this->telephone=$user->telephone;
            $this->dateNaissance=$user->dateNaissance;
            $this->photo=$user->photo;
            $this->photo1=$user->photo;
            $this->Valrole=$user->Role_id;
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Error !! 😓😓"
            ]);
        }

    }
    public function update()
    {
        // modifier utilisateur
        try {
            $user=User::find(session('idU'));
            $user->nomUtilisateur=$this->nom;
            $user->prenomUtilisateur=$this->prenom;
            $user->email=$this->email;
            $user->telephone=$this->telephone;
            $user->dateNaissance=$this->dateNaissance;
            if($this->photo instanceOf \Illuminate\Http\UploadedFile){
                Storage::delete('public/photos/'.$this->photo1);
                $user->photo=$this->photo->store('photos','public');
            }else{
                $user->photo=$this->photo;
            }
            $user->Role_id=$this->Valrole;
            $user->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Utilisateur modification avec success😉😉"
            ]);
            session()->put('opU','all');
            $this->resetInput();
        } catch (Exception) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Error  de modifier Utilisateur😓😓"
            ]);
        }

    }
    public function updating($name,$value){
        // pour vider les champs de filtrage si il change
        if($name==='select'){
            $this->resetPage();
            $this->reset(['search']);
            if($value!=='Role_id'){
                $this->resetPage();
            }

        }
    }
    public function exporter()
    {
        return Excel::download(new UsersExport, Carbon::now().'utilisateur.html');
    }
    public function import()
    {
        // importation fichier excel pour inserer dans basse de donner
        if($this->fichier=='')
        {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'info',
                'message'=>"choissisez d'abbord le fichier😕😕"
            ]);
        }elseif($this->fichier!==null)
        {
           try {
            Excel::import(new UsersImport,$this->fichier);
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"les user ajouter avec success 😉😉"
            ]);
            $this->fichier=='';
           } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'erro',
                'message'=>"error de importer le fichier😓😓"
            ]);
           }
        }
    }
    public function downloadFile($id)
    {
        // download cv
        $user=User::find($id);
        if($user->donners!==null)
        {
            $path = storage_path('app/public/'.$user->donners->cv);
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
        }elseif($user->donners==null)
        {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"cv introuvable😓😓"
            ]);
        }
    }
}
