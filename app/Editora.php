<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{
    protected $table = "editoras";

    protected $fillable = [
        'editora',
        'estado',
    ];

    public function livro(){
        return $this->hasMany(Livro::class, 'id_editora', 'id');
    }
}