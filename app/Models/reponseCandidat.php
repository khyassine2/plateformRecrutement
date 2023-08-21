<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reponseCandidat extends Model
{
    use HasFactory;
    protected $table='reponse_candidats';
    protected $primaryKey='idReponseCandidat';

    protected $fillable = [
        'reponseCandidat',
        'choixId',
        'utilisateurId'
    ];
    public function utilisateurs()
    {
        return $this->belongsTo(User::class, 'utilisateurId', 'idUtilisateur');
    }
    public function choix()
    {
        return $this->belongsTo(Choix::class, 'choixId', 'id');
    }
}
