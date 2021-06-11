<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaLivro extends Model
{
    protected $table = "categoria_livros";

    protected $fillable = [
        'categoria',
        'estado',
    ];

    public function livro(){
        return $this->hasMany(Livro::class, 'id_categoria_livro', 'id');
    }
}
