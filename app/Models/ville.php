<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ville extends Model
{
    use HasFactory;
    protected $table='ville';
    public function demandeStages()
    {
        return $this->hasMany(DemandeStage::class, 'villeId', 'id');
    }
}
