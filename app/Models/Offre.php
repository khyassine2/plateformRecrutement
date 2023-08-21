<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;
    protected $primaryKey='idOffre';
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'hasEntrepriseId');
    }
    public function TestEntrepriseOffre($id,$id1){
        // retourner les test de entreprise
        return TestCompetence::where('hasSecteurId',$id)->where('hasEntrepriseId',$id1)->get();
    }
    public function secteur()
    {
        return $this->belongsTo(SecteurActiviter::class, 'hasSecteurId');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class,'offreId','idOffre');
    }
    public function entreprise_has_secteurs()
    {
        return $this->belongsTo(Entreprise_has_Secteur::class,'hasEntrepriseId');
    }

}


