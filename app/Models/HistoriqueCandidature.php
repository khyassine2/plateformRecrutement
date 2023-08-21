<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueCandidature extends Model
{
    use HasFactory;
    protected $table='historique_candidatures';
    protected $primaryKey='idHistorique';
    public function candidatures()
    {
        return $this->belongsTo(Candidature::class,'candidatureId');
    }
    
}
