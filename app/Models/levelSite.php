<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class levelSite extends Model
{
    use HasFactory;
    protected $table = 'level_sites';

    public function utilisateurs()
    {
        return $this->hasMany(User::class,'levelsite_id', 'idLevelSite');
    }
}
