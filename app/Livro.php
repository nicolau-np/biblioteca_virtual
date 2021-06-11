<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $table = "livros";

    protected $fillable = [
        'id_autor',
        'id_editora',
        'id_categoria_livro',
        'titulo',
        'foto_capa',
        'data_lancamento',
        'estado',
    ];

    public function autor(){
        return $this->belongsTo(Autor::class, 'id_autor', 'id');
    }

    public function editora(){
        return $this->belongsTo(Editora::class, 'id_editora', 'id');
    }

    public function categoria_livro(){
        return $this->belongsTo(CategoriaLivro::class, 'id_categoria_livro', 'id');
    }
}