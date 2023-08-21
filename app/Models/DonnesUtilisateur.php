<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonnesUtilisateur extends Model
{
    use HasFactory;
    protected $primaryKey='idDonnes';
    protected $fillable = [
        'cv',
        'experiances',
        'competences',
        'niveauEtude',
        'utilisateurId',
    ];
    public function users()
    {

        return $this->belongsTo(User::class,'utilisateurId');
    }
}
