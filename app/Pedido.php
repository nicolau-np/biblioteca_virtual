<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = "pedidos";

    protected $fillable = [
        'id_leitor',
        'id_tipo_pedido',
        'estado',
    ];

    public function leitor(){
        return $this->belongsTo(Leitor::class, 'id_leitor', 'id');
    }

    public function tipo_pedido(){
        return $this->belongsTo(TipoPedido::class, 'id_tipo_pedido', 'id');
    }
}