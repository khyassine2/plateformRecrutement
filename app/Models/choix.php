<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class choix extends Model
{
    use HasFactory;
    protected $table='choix';
    protected $primarKey='idChoix';
    public function question()
    {
        return $this->belongsTo(Question::class, 'questionId', 'id');
    }
    public function reponseCandidats()
    {
        return $this->hasMany(reponseCandidat::class, 'choixId', 'id');
    }
}
