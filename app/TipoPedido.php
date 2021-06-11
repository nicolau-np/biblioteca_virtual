<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPedido extends Model
{
    protected $table = "tipo_pedidos";

    protected $fillable = [
        'tipo',
        'estado',
    ];

    public function pedido(){
        return $this->hasMany(Pedido::class, 'id_tipo_pedido', 'id');
    }
}