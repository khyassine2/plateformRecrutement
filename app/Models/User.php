<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Livewire\Admin\Testcompetence;
use App\Models\TestCompetence as ModelsTestCompetence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table='utilisateur';
    protected $primaryKey='idUtilisateur';
    const TYPE_ID = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomUtilisateur',
        'prenomUtilisateur',
        'email',
        'password',
        'telephone',
        'dateNaissance',
        'photo',
        'ville'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles()
    {
        return $this->belongsTo(Role::class,'Role_id');
    }
    public function donners()
    {
        return $this->hasOne(DonnesUtilisateur::class,'utilisateurId');
    }
    public function tests()
    {
        return $this->hasMany(ModelsTestCompetence::class,'UtilisateurId');
    }
    public function levelSite(){
        return $this->belongsTo(levelSite::class,'levelsite_id', 'idLevelSite');
    }
    public function demandeStages()
    {
        return $this->hasMany(demandestage::class, 'utilisateurId', 'idUtilisateur');
    }
    public function reponseCandidats()
    {
        return $this->hasMany(reponseCandidat::class, 'utilisateurId', 'idUtilisateur');
    }
    public function resultats()
    {
        return $this->hasMany(resultatTest::class, 'utilisateurId');
    }
    public function visiteComptes()
    {
        return $this->hasMany(VisiteCompte::class,'visitecompteid','idUtilisateur');
    }
    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'utilisateurId');
    }
    public function visitedVisits()
    {
        return $this->morphMany(VisiteCompte::class,'visitecompteid','type_visiteCompteId','visitecompteid');
    }
    public function visitorVisits()
    {
        return $this->morphMany(VisiteCompte::class,'connectecompteid');
    }
    // public function visitors()
    //  {
    //     return $this->visitedVisits()->with('visitor')->get()->pluck('visitor')->unique();
    //  }
    // public function visitors()
    // {
    //     return $this->visitedVisits()
    //         // ->where('type_visiteCompteId', self::TYPE_ID)
    //         // ->with('visitor')
    //         ->get();
    //         // ->pluck('visitor')
    //         // ->unique();
    // }
}
