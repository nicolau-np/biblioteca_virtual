<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leitor extends Model
{
    protected $table = "leitors";

    protected $fillable = [
        'id_pessoa',
        'telefone',
        'bairro',
    ];

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id');
    }

    public function pedido(){
        return $this->hasMany(Pedido::class, 'id_leitor', 'id');
    }
}