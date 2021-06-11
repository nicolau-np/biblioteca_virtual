<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = "autors";

    protected $fillable = [
        'autor',
        'estado',
    ];

    public function livro(){
        return $this->hasMany(Livro::class, 'id_autor', 'id');
    }
}