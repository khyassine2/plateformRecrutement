<?php

namespace App\Http\Controllers;

use App\Events\lanceSchedule;
use App\Events\SendEmail;
use App\Http\Livewire\Admin\Utilisateur;
use App\Http\Livewire\Utilisateur\DemandeStage;
use App\Jobs\sendEmailOffre;
use App\Models\demande;
use App\Models\demandestage as ModelsDemandestage;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\SecteurActiviter;
use App\Models\User;
use App\Models\ville;
use App\Models\VisiteCompte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
    // forget session
        session()->forget(['opTestA', 'opE','idE','idTestA','opAlldemande','idAlldemande','opAllEntreprise','idAllEntreprise','opAllOffre','idAllOffre','opC','idC','opE','idE','idO','opO','opR','idR','opS','idS','opTestA','idTestA','opU','idU','opTestEn','idTestEn','showEmail']);
    // recuperer le count des offre par ville
        $offreCountByVille = DB::table('offres')
        ->join('entreprises', 'offres.hasEntrepriseId', '=', 'entreprises.idEntreprise')
        ->select('entreprises.villeEntreprise', DB::raw('count(*) as total'))
        ->groupBy('entreprises.villeEntreprise')
        ->get();

        foreach ($offreCountByVille as $key=>$result) {
            $count = $result->total;
            $countOffresParVille[$key]=$count;
        }
        // recuperer count des offre par secteur
        $resultatsOffre=Offre::with('secteur')->limit(8)->get();
        $countOffresParSecteur = [];
        foreach ($resultatsOffre as $offre) {
            $secteur = $offre->secteur->nomSecteurActiviter;
            if (!isset($countOffresParSecteur[$secteur])) {
                $countOffresParSecteur[$secteur] = 1;
            } else {
                $countOffresParSecteur[$secteur]++;
            }
        }
        // recuperer les secteur qui ont un offres
        $secteursAvecOffres=DB::table('secteur_activiters')
        ->distinct()
        ->join('entreprise_has_secteurs', 'secteur_activiters.idSecteurActiviter', '=', 'entreprise_has_secteurs.secteurId')
        ->join('offres', 'offres.hasSecteurId', '=', 'entreprise_has_secteurs.secteurId')
        ->where('offres.dateCloture', '>=', now())
        ->select('secteur_activiters.*')
        ->limit(6)
        ->get();

        // recuperer le  dernieres Offres et recuperer le delais de publication
        $offres=Offre::latest('created_at')->take(5)->where('dateCloture','>',now())->get();


        foreach ($offres as $key=>$item) {
            $diff = $item->created_at->diff(Carbon::now());
            if ($diff->y > 0) {
                $datePublieOffre[$key] = "il y a " . $diff->y . " an" . ($diff->y > 1 ? "s" : "");
            } elseif ($diff->m > 0) {
                $datePublieOffre[$key] = "il y a " . $diff->m . " mois";
            } elseif ($diff->d > 0) {
                $datePublieOffre[$key] = "il y a " . $diff->d . " jour" . ($diff->d > 1 ? "s" : "");
            } elseif ($diff->h > 0) {
                $datePublieOffre[$key] = "il y a " . $diff->h . " heure" . ($diff->h > 1 ? "s" : "");
            } elseif($diff->i > 0) {
                $datePublieOffre[$key] = "il y a " . $diff->i . " minute" . ($diff->i > 1 ? "s" : "");
            }else{
                $datePublieOffre[$key] = "il y a " . $diff->s . " seconde" . ($diff->s > 1 ? "s" : "");
            }
        }
        session()->pull('typee');
        // on recuperer les users qui ont le role user:
        if(Auth::guard('web')->check())
        {
            $users = User::join('roles', 'utilisateur.Role_id', '=', 'roles.idRole')
                    ->join('level_sites', 'utilisateur.levelsite_id', '=', 'level_sites.idLevelSite')
                    ->join('donnes_utilisateurs', 'utilisateur.idUtilisateur', '=', 'donnes_utilisateurs.utilisateurId')
                    ->where('roles.nomRole', '=', 'user')
                    ->where('utilisateur.idUtilisateur','!=',Auth::guard('web')->user()->idUtilisateur)
                    ->select('utilisateur.nomUtilisateur','utilisateur.idUtilisateur','utilisateur.prenomUtilisateur','utilisateur.photo','utilisateur.ville','level_sites.nomLevelSite','donnes_utilisateurs.niveauEtude')
                    ->limit(10)
                    ->inRandomOrder()
                    ->get();
        }else
        {
            $users = User::join('roles', 'utilisateur.Role_id', '=', 'roles.idRole')
                    ->join('level_sites', 'utilisateur.levelsite_id', '=', 'level_sites.idLevelSite')
                    ->join('donnes_utilisateurs', 'utilisateur.idUtilisateur', '=', 'donnes_utilisateurs.utilisateurId')
                    ->where('roles.nomRole', '=', 'user')
                    ->select('utilisateur.nomUtilisateur','utilisateur.idUtilisateur','utilisateur.prenomUtilisateur','utilisateur.photo','utilisateur.ville','level_sites.nomLevelSite','donnes_utilisateurs.niveauEtude')
                    ->limit(10)
                    ->inRandomOrder()
                    ->get();
        }
        // recuperer Entreprisse
        $entreprise=Entreprise::whereHas('secteurs')->take(6)->get();

        // recuperer les 5 recente demande
        $demande=demande::where('typeFormation','!=',0)->latest('created_at')->take(5)->get();

        // recuperer la diffirence entre now et date publie
        foreach ($demande as $key=>$item) {
            $diff = $item->created_at->diff(Carbon::now());
            // dd($diff);
            if ($diff->y > 0) {
                $datePublie[$key] = "il y a " . $diff->y . " an" . ($diff->y > 1 ? "s" : "");
            } elseif ($diff->m > 0) {
                $datePublie[$key] = "il y a " . $diff->m . " mois";
            } elseif ($diff->d > 0) {
                $datePublie[$key] = "il y a " . $diff->d . " jour" . ($diff->d > 1 ? "s" : "");
            } elseif ($diff->h > 0) {
                $datePublie[$key] = "il y a " . $diff->h . " heure" . ($diff->h > 1 ? "s" : "");
            } elseif($diff->i >0) {
                $datePublie[$key] = "il y a " . $diff->i . " minute" . ($diff->i > 1 ? "s" : "");
            }else{
                $datePublie[$key] = "il y a " . $diff->s . " seconde" . ($diff->s > 1 ? "s" : "");
            }
        }
        return view('layouts.home',['secteur'=>$secteursAvecOffres??'','Allsecteur'=>SecteurActiviter::all()??'','countUtilisateur'=>User::count()??'','utilisateur'=>$users??'','DemandeStage'=>$demande??'','datePublie'=>$datePublie??'','datePublieOffre'=>$datePublieOffre??'','offres'=>$offres,'entreprise'=>$entreprise,'Ville'=>Entreprise::distinct('villeEntreprise')->limit(4)->select('villeEntreprise')->whereNotNull('villeEntreprise')->get()??'','CountOffres'=>Offre::count()??'','countSecteur'=>SecteurActiviter::count()??'','countEntreprise'=>Entreprise::count()??'','countOffresParVille'=>$countOffresParVille??'','countOffresParSecteur'=>$countOffresParVille??'']);
    }
    public function show($id){
        $user=User::find($id);
        if(Auth::guard('web')->check()){
            $connecte=Auth::guard('web')->user();
            $visitor=$connecte->idUtilisateur;
        }elseif(Auth::guard('entreprise')->check())
        {
            $connecte=Auth::guard('entreprise')->user();
            $visitor=$connecte->idEntreprise;
        }
        // recuperer si il y'a deja visite ce compte
        $compteVisite = VisiteCompte::firstOrNew(['visiteCompteId' =>$id,'connecteCompteId'=>$visitor]);
        if($visitor!==$compteVisite){
        if(!$compteVisite->exists){
            // si il n'exsist pas il ajouter
            $visit = new VisiteCompte();
            $visit->visitecompteid = $user->idUtilisateur;
            // recuperer type Id
            $visit->type_visiteCompteId = (int)get_class($user)::TYPE_ID;
            $visit->connectecompteid = $visitor;
            $visit->type_connecteCompteId = (int)get_class($connecte)::TYPE_ID;
            $visit->save();
            }
        }
       $utilisateur = User::join('roles', 'utilisateur.Role_id', '=', 'roles.idRole')
        ->join('level_sites', 'utilisateur.levelsite_id', '=', 'level_sites.idLevelSite')
        ->join('donnes_utilisateurs', 'utilisateur.idUtilisateur', '=', 'donnes_utilisateurs.utilisateurId')
        ->where('roles.nomRole', '=', 'user')
        ->orderByRaw("CASE WHEN ville LIKE '$user->ville%' THEN 0 ELSE 1 END, ville")
        ->inRandomOrder()
        // le where pour afficher les level premiere
        // ->where('level_sites.nomLevelSite','>','5')
        ->select('utilisateur.nomUtilisateur','utilisateur.idUtilisateur','utilisateur.prenomUtilisateur','utilisateur.photo','utilisateur.ville','level_sites.nomLevelSite','donnes_utilisateurs.niveauEtude')
        ->limit(6)
        ->get();
            $dateOfBirth = Carbon::parse($user->dateNaissance);
            $ages = $dateOfBirth->diffInYears(Carbon::now());
        return view('layouts.detailsUser',['user'=>$user,'utilisateur'=>$utilisateur,'age'=>$ages]);
    }
    public function hello()
    {
        try {
            $offre=Offre::find('24');
            // dd($offre);
            // $data =  User::whereNotNull('email')
            // ->whereRaw('email REGEXP "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"')
            // ->get();
            $secteurId=2;
            $candidatures = Offre::whereHas('entreprise_has_secteurs', function($query) use ($secteurId) {
                $query->where('secteurId', '=', $secteurId);
            })
            ->with('candidatures.users') // eager load the user relationship on candidatures
            ->get()
            ->pluck('candidatures.*.users') // extract the email attribute from all user relationships
            ->flatten();
            dispatch(new sendEmailOffre($candidatures,$offre->idOffre));
            // dd(Artisan::call('schedule:run'));
            // sendEmailOffre::dispatch($data)->onQueue('emails');
            return 'ccsend';
        } catch (\Exception $e) {
            Log::error('Error sending email: '.$e->getMessage());
            return 'Error sending email: '.$e->getMessage();
        }
    }
    public function sendEmail(Request $request)
    {
        try {
            $data=User::find($request->input('id'));
            // dd($data);
            event(new SendEmail($data,$request->input('object'),$request->input('msg'),'utilisateur'));
            Event::dispatch('alert', [
                'type'=>'success',
                'message'=>"Mail envoyer avec success!!"
            ]);
            // dd('ccc');
            session()->flash('success', 'Mail envoyé avec succès!!');
            // $this->dispatchBrowserEvent('alert',);
            return redirect()->to("/details/{$request->input('id')}");
        } catch (\Throwable $th) {
            session()->flash('error', 'Erreur lors de l\'envoi du mail!!');
        //     dd('ccc11');
            // Event::dispatch('alert', [
            //     'type'=>'eror',
            //     'message'=>"Mffffffffcess!!"
            // ]);
        }
    }
}
