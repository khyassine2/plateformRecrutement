<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecteurActiviter extends Model
{
    use HasFactory;
    protected $primaryKey='idSecteurActiviter';
    public function entreprises()
    {
        return $this->belongsToMany(Entreprise::class, 'entreprise_has_secteurs','secteurId', 'entrepriseId');
    }
    public function tests()
    {
        return $this->hasMany(TestCompetence::class,'hasSecteurId');
    }
     public function demandeStages()
    {
        return $this->hasMany(DemandeStage::class, 'typeFormation ', 'idSecteurActiviter');
    }
    public function offres()
    {
        return $this->hasMany(Offre::class, 'hasSecteurId');
    }
}
