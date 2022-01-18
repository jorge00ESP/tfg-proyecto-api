<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    public function user_trabajador(){
        return $this->hasOne(User::class, 'id_trabajador', 'id');
    }

    public function user_cliente(){
        return $this->hasOne(User::class, 'id_cliente', 'id');
    }
}
