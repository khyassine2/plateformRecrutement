<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCompetence extends Model
{
    use HasFactory;
    protected $table='test_competences';
    protected $primaryKey='idTest';
    public function user()
    {
        return $this->belongsTo(User::class,'utilisateurId');
    }
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'hasEntrepriseId');
    }

    public function secteur()
    {
        return $this->belongsTo(SecteurActiviter::class, 'hasSecteurId');
    }
    public function questions()
    {
        return $this->hasMany(Question::class, 'testId');
    }
    public function resultats()
    {
        return $this->hasMany(ResultatTest::class, 'TestId');
    }
}
