<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = "pessoas";

    protected $fillable = [
        'nome',
        'genero',
        'bi',
        'foto',
        'estado',
    ];

    public function usuario(){
        return $this->hasMany(User::class, 'id_pessoa', 'id');
    }

    public function leitor(){
        return $this->hasMany(Leitor::class, 'id_pessoa', 'id');
    }
}