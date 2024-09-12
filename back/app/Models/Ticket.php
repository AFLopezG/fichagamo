<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function tipo(){
        return $this->belongsTo(Tipo::class);
    }
}
