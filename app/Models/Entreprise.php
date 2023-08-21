<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Entreprise extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey='idEntreprise';
    protected $table='entreprises';
    const TYPE_ID = 2;
    public function secteurs()
    {
        return $this->belongsToMany(SecteurActiviter::class, 'entreprise_has_secteurs', 'entrepriseId', 'secteurId');
    }
    public function offres()
{
    return $this->hasMany(Offre::class,'hasEntrepriseId');
}
    public function tests()
    {
        return $this->hasMany(TestCompetence::class,'hasEntrepriseId');
    }
    public function resultats()
    {
        return $this->hasMany(resultatTest::class, 'hasEntrepriseId');
    }
    public function villes()
    {
        return $this->belongsTo(ville::class, 'villeEntreprise', 'id');
    }
    public function visitedVisits()
    {
        return $this->morphMany(VisiteCompte::class,'visitecompteid');
    }
    public function visitorVisits()
    {
        return $this->morphMany(VisiteCompte::class,'connectecompteid');
    }
    protected $fillable = [
        'nomEntreprise',
        'emailEntreprise',
        'password',
        'adresseEntreprise',
        'siteWebEntreprise',
        'villeEntreprise',
        'telephone',
        'photo',
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
}
