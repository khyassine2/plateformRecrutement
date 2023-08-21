<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiteCompte extends Model
{
    use HasFactory;
    protected $fillable = [
        'connecteCompteId',
        'visiteCompteId',
    ];
    public function visiteComptes($type,$id)
    {
        if($type==1)
        {
            // user
            $data=User::find($id);
        }elseif($type==2)
        {
            // entreprise
            $data=Entreprise::find($id);
        }
        return $data;
    }

    // public function visitor()
    // {
    //     return $this->morphTo('visitecompte', 'type_visiteCompteId', 'visitecompteid');
    // }
    // public function visited()
    // {
    //     return $this->morphTo('connectecompte', 'type_connecteCompteId', 'connectecompteid');
    // }

}
