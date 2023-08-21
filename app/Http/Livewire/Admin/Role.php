<?php

namespace App\Http\Livewire\Admin;

use App\Models\Role as ModelsRole;
use Exception;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Role extends Component
{
    public $op='all';
    public $nomRole;
    public $idRole;
    protected $rules=[
        'nomRole'=>'required'
    ];
    public function render()
    {
        if(!Gate::allows('admin')){
            session()->pull('typee');
            abort(403,'n est pas autorizé');
        }
        return view('livewire.admin.role',['role'=>ModelsRole::all()]);
    }
    public function mount()
    {
        if(session('opR')=='update')
        {
            $this->editRole(session('idR'));
        }elseif(session('opR')=='delete')
        {
            $this->change('delete',session('idR'));
        }
    }
    public function change($op,$id=null){
        session()->put('opR',$op);
        if($op=='delete' && isset($id)){
            // pour remplire les variable de suppression
            session()->put('idR',$id);
            $role=ModelsRole::find($id);
            $this->idRole=$role->idRole;
            $this->nomRole=$role->nomRole;
        }
    }
    public function ajouterRole(){
        try {
            $this->validate();
            $role=new ModelsRole();
            $role->nomRole=$this->nomRole;
            $role->save();
             $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"role ajouter avec success😉😉"
            ]);
            $this->nomRole='';
            session()->put('opR','all');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error d'ajoute😓😓"
            ]);
        }
    }
    public function editRole($id){
        try {
            session()->put('opR','update');
            session()->put('idR',$id);
            $role=ModelsRole::find($id);
            $this->idRole=$role->idRole;
            $this->nomRole=$role->nomRole;
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error!!!!"
            ]);
        }
    }
    public function updateRole()
    {
        try {
            $this->validate([
                'nomRole'=>'required'
            ]);
            $role=ModelsRole::find(session('idR'));
            $role->nomRole=$this->nomRole;
            $role->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"role Modifier avec success😉😉"
            ]);
            $this->nomRole='';
            $this->idRole='';
            session()->put('opR','all');
        } catch (Exception) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de modification😓😓"
            ]);
        }
    }
    public function deleteRole(){
       try {
        ModelsRole::find(session('idR'))->delete();
        $this->nomRole='';
        $this->idRole='';
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"role supprimer avec success😉😉"
        ]);
        session()->put('opR','all');
       } catch (\Throwable $th) {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"role supprimer avec success😓😓"
        ]);
       }
    }
}
