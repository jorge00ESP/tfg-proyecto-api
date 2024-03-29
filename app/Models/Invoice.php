<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function empresa(){
        return $this->belongsTo(Provider::class, 'id_empresa', 'id');
    }

    public function lineas(){
        return $this->hasMany(Line::class, 'invoice_id');
    }
}
