<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demande extends Model
{
    protected $table='demande';
    protected $primaryKey='idDemande';
    use HasFactory;
    protected $fillable = [
        'typeStage',
        'dureeStage',
        'DateDebutStage',
        'DateFinStage',
        'villeId',
        'utilisateurId',
        'status',
        'datePublie',
        'titreDemande',
        'typeFormation',
        'niveauEtude',
        'typeDemande'
    ];
    public function secteurActiviter()
    {
        return $this->belongsTo(SecteurActiviter::class, 'typeFormation', 'idSecteurActiviter');
    }
    public function utilisateurs()
    {
        return $this->belongsTo(User::class, 'utilisateurId', 'idUtilisateur');
    }
    public function villes()
    {
        return $this->belongsTo(Ville::class, 'villeId', 'id');
    }
}
