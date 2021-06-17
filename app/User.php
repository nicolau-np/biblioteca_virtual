<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "usuarios";

    protected $fillable = [
        'id_pessoa',
        'email',
        'password',
        'acesso',
        'estado',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts=[
        'email_verified_at'=>'datetime'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id');
    }
}