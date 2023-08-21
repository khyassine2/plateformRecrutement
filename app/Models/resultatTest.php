<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resultatTest extends Model
{
    use HasFactory;
    protected $table='resultat_tests';
    protected $primaryKey='idResultatTest';
    protected $fillable = [
        'scoreTest',
        'dateTest',
        'hasEntrepriseId',
        'utilisateurId',
        'hasSecteurId',
        'adminId',
        'TestId',
    ];
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateurId');
    }
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'hasEntrepriseId');
    }
    public function tests()
    {
        return $this->belongsTo(TestCompetence::class,'TestId');
    }
}
