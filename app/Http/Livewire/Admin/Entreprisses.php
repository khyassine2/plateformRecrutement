<?php

namespace App\Http\Livewire\Admin;
use Illuminate\Support\Str;
use App\Exports\EntrepriseExport;
use App\Imports\EntrepriseImport;
use App\Models\Entreprise;
use App\Models\Entreprise_has_Secteur;
use App\Models\SecteurActiviter;
use App\Models\ville;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Entreprisses extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $paginationEnabled = true;
    public $search,$select='nomEntreprise',$searchSecteur,$villeEntr;
    public $secteur=[];
    public $op='all';
    public $id2;
    public $nom,$adresse,$email,$password,$siteweb,$ville,$telephone,$photo,$photo21,$fichier;
    protected $rules=[
        'nom'=>'required',
            'adresse'=>'required',
            'email'=>'required',
            'password'=>'required',
            'telephone'=>'required',
            'siteweb'=>'required',
            'adresse'=>'required',
            'ville'=>'required',
            // 'photo'=>'required',
    ];
    protected $queryString=[
        'search' => ['except' => ''],
        'searchSecteur' => ['except' => null],
    ];
    protected $listeners = ['selectChanged' => 'handleSelectChanged'];
    public function render()
    {
        if(!Gate::allows('admin')){
            session()->pull('typee');
            abort(403,'n est pas autorizé');
        }
        $data=Entreprise::paginate(3);
        if(isset($this->searchSecteur)){
            if($this->searchSecteur!==null){
                $data=SecteurActiviter::find($this->searchSecteur)->entreprises()->paginate(3);
            }
        }elseif($this->select!=='secteurActiviter'){
            if($this->select=='villeEntreprise'){
                $this->search=$this->villeEntr;
            }
            $data=Entreprise::where($this->select,'like','%'.$this->search.'%')->paginate(3);
        }
        return view('livewire.admin.entreprisses',['Entreprises'=>$data,'secteurActiviter'=>SecteurActiviter::all(),'count'=>Entreprise::select('idEntreprise')->count(),'villeAll'=>ville::all()]);
    }
    public function mount()
    {
        if(session('opE')=='update')
        {
            $this->edit(session('idE'));
        }elseif(session('opE')=='delete')
        {
            $this->change('delete',session('idE'));
        }
    }
    public function updating($name,$value){
        // pour vider search on change de selectbox
        if($name==='select'){
            $this->reset(['search']);
            $this->resetPage();
            if($value!=='secteurActiviter'){

                $this->reset(['searchSecteur']);
                $this->resetPage();
            }

        }

    }
    public function updatedsearch(){
        $this->resetPage();
    }
    public function handleSelectChanged($value)
    {
        $nouvelleSelection = collect($value)->map(function ($id) {
            return SecteurActiviter::find($id);
        });
        $this->secteur=$nouvelleSelection;
    }
    public function resetInput(){
        // vider les variables
        $this->reset(['nom', 'adresse','email','password','telephone','siteweb','photo','ville','photo21','secteur']);
    }
    public function change($op,$id=null){
        session()->put('opE',$op);
        if($op=='all'){
            $this->resetInput();
        }
        if(isset($id)){
            session()->put('idE',$id);
            $entreprise=Entreprise::find($id);
            $this->id=$entreprise->idEntreprise;
            $this->nom=$entreprise->nomEntreprise;
        }
    }
    public function ajouterEntreprise(){
        try {
         DB::transaction(function () {
            $this->validate();
            $entreprise=new Entreprise();
            $entreprise->nomEntreprise=$this->nom;
            $entreprise->adresseEntreprise=$this->adresse;
            $entreprise->emailEntreprise=$this->email;
            $entreprise->password=Hash::make($this->password);
            $entreprise->siteWebEntreprise=$this->siteweb;
            $entreprise->villeEntreprise=$this->ville;
            $entreprise->telephone=$this->telephone;
            $entreprise->photo=$this->photo->store('photos','public');
            $entreprise->save();
            foreach($this->secteur as $secteur) {
                $entreprise->secteurs()->attach($secteur);
            }
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Entreprise Ajouter avec success😉😉"
            ]);
            $this->resetInput();
            session()->put('opE','all');
         });

        }catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"error d'ajouter Entreprise😓😓"
            ]);
        }
    }

    public function delete()
    {
        try {
            Entreprise::where('idEntreprise',session('idE'))->delete();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Entreprise supprimer avec success😉😉"
            ]);
            $this->resetPage();
            session()->put('opE','all');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>'error de suppression😓😓'
            ]);
        }
    }
    public function edit($id)
    {
        try {
            session()->put('opE','update');
            session()->put('idE',$id);
            $entreprise=Entreprise::find($id);
            $this->id2=$entreprise->idEntreprise;
            $this->nom=$entreprise->nomEntreprise;
            $this->adresse=$entreprise->adresseEntreprise;
            $this->email=$entreprise->emailEntreprise;
            $this->siteweb=$entreprise->siteWebEntreprise;
            $this->ville=$entreprise->villeEntreprise;
            $this->telephone=$entreprise->telephone;
            $this->photo=$entreprise->photo;
            $this->photo21=$entreprise->photo;
            $this->secteur=$entreprise->secteurs()->get()->toArray();
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>'Error de chargement de donner😓😓'
            ]);
        }
    }
    public function update()
    {
        try {
        $entreprise=Entreprise::find($this->id2);
        $entreprise->nomEntreprise=$this->nom;
        $entreprise->adresseEntreprise=$this->adresse;
        $entreprise->emailEntreprise=$this->email;
        $entreprise->siteWebEntreprise=$this->siteweb;
        $entreprise->telephone=$this->telephone;
        $entreprise->villeEntreprise=$this->ville;
        if($this->photo instanceOf \Illuminate\Http\UploadedFile){
            Storage::delete('public/photos/'.$this->photo21);
            $entreprise->photo=$this->photo->store('photos','public');
        }else{
            $entreprise->photo=$this->photo;
        }
        $entreprise->secteurs()->detach();
        foreach($this->secteur as $item) {
            $secteurs = SecteurActiviter::find($item['idSecteurActiviter']);
            if($secteurs) {
                    $entreprise->secteurs()->attach($secteurs);
                }
        }
        $entreprise->save();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Entreprise modifier avec success.!!"
        ]);
        $this->resetInput();
        session()->put('opE','all');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>'error de modifier 😓😓'
            ]);
        }
    }
    public function exporter()
    {
        return Excel::download(new EntrepriseExport, Carbon::now().'entreprise.csv');
    }
    public function import()
    {
        // $this->validate([
        //     'fichier'=>'file|mimetypes:csv'
        // ])
        if($this->fichier=='')
        {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'info',
                'message'=>"choissisez d'abbord le fichier.!!"
            ]);
        }elseif($this->fichier!==null)
        {
           try {
            Excel::import(new EntrepriseImport,$this->fichier);
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"les entreprise ajouter avec success.!!"
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
}
