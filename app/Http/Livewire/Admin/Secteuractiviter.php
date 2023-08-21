<?php

namespace App\Http\Livewire\Admin;

use App\Models\SecteurActiviter as ModelsSecteurActiviter;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Secteuractiviter extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $paginationEnabled = true;
    public $op;
    public $search;
    public $nomsecteur,$nomsecteur2,$photosecteur,$photosecteur2,$idsecteur;
    protected $rules=[
        'nomsecteur'=>'required',
    ];
    protected $queryString=[
        'search' => ['except' => ''],
    ];
    public function render()
    {
        if(!Gate::allows('admin')){
            session()->pull('typee');
            abort(403,'n est pas autorizé');
        }
        return view('livewire.admin.secteuractiviter',['secteurActiviter'=>ModelsSecteurActiviter::where('nomSecteurActiviter','like','%'.$this->search.'%')->paginate(5)]);
    }
    public function mount()
    {
        if(session('opS')=='update')
        {
            $this->editSecteur(session('idS'));
        }elseif(session('opS')=='delete')
        {
            $this->change('delete',session('idS'));
        }
    }
    public function change($op,$id=null){
        session()->put('opS',$op);
        if(isset($id)){
            // pour remplire les variable de suppression
            session()->put('idS',$id);
            $secteur=ModelsSecteurActiviter::find($id);
            $this->idsecteur=$secteur->idSecteurActiviter;
            $this->nomsecteur=$secteur->nomSecteurActiviter;
        }
    }
    public function ajouterSecteur(){
        try {
            $this->validate();
            $secteur=new ModelsSecteurActiviter();
            $secteur->nomSecteurActiviter=$this->nomsecteur;
            $secteur->photo=$this->photosecteur->store('photos','public');
            $secteur->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Secteur ajouter avec success😉😉"
            ]);
            $this->nomsecteur='';
            $this->photosecteur='';
            session()->put('opS','all');
            } catch (Exception) {
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'error',
                    'message'=>"error d'ajoute le Secteur😓😓"
                ]);
            }
    }
    public function deleteSecteur()
    {
        try {
            ModelsSecteurActiviter::where('idSecteurActiviter',session('idS'))->delete();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Secteur Supprimer avec success😉😉"
            ]);
            session()->put('opS','all');
            } catch (Exception) {
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'error',
                    'message'=>"error de suppression 😓😓"
                ]);
            }
    }
    public function editSecteur($id)
    {
        try {
            session()->put('idS',$id);
            $secteur=ModelsSecteurActiviter::find($id);
            $this->idsecteur=$secteur->idSecteurActiviter;
            $this->nomsecteur2=$secteur->nomSecteurActiviter;
            $this->photosecteur=$secteur->photo;
            $this->photosecteur2=$secteur->photo;
            session()->put('opS','update');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error 😓😓"
            ]);
        }
    }
    public function updateSecteur()
    {
        try {
            $secteur=ModelsSecteurActiviter::find($this->idsecteur);
            $secteur->nomSecteurActiviter=$this->nomsecteur2;
            if($this->photosecteur instanceOf \Illuminate\Http\UploadedFile){
                Storage::delete('public/photos/'.$this->photosecteur2);
                $secteur->photo=$this->photosecteur->store('photos','public');
            }else{
                dd('nn');
                $secteur->photo=$this->photosecteur;
            }
            $secteur->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"secteur modifier avec success😉😉"
            ]);
            session()->put('opS','all');
        } catch (Exception) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error de modification 😓😓"
            ]);
        }

    }
}
