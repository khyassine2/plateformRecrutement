<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise_has_Secteur extends Model
{
    use HasFactory;
    protected $table='entreprise_has_secteurs';
    // protected $primaryKey=['entrepriseId','secteurId'];
    public $incrementing = false;
    protected $fillable = ['entrepriseId', 'secteurId'];
    // public function entreprise()
    // {
    //     return $this->belongsTo(Entreprise::class);
    // }



    // public function secteur()
    // {
    //     return $this->belongsTo(SecteurActiviter::class);
    // }
    protected $primaryKey='entrepriseId';
    protected $Key='secteurId';

    // protected $table="entreprise_has_secteurs";


    public function offres()
    {
        return $this->hasMany(Offre::class,);
    }
    public function entreprises()
    {
        return $this->belongsTo(Entreprise::class,'entrepriseId');
    }
    public function secteur_activiters()
    {
        return $this->belongsTo(SecteurActiviter::class,'secteurId');
    }
}
