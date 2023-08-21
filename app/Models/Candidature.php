<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;
    protected $primaryKey='idCandidature';
    protected $table='candidatures';
    public function historique_condidatures()
    {
        return $this->hasMany(HistoriqueCandidature::class, 'candidatureId');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'idUtilisateur', 'utilisateurId');
    }
    public function offres()
    {

        return $this->belongsTo(Offre::class, 'offreId','idOffre');
    }
}
