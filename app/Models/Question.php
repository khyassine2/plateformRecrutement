<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table='questions';
    protected $primarKey='id';
    public function choix()
    {
        return $this->hasMany(choix::class, 'questionId', 'id');
    }
    public function testcompetence()
    {
        return $this->belongsTo(TestCompetence::class, 'testId');
    }
}
