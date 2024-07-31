<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    

    public function type()
    {
        // TYPE HA SOLO un PROJECT ASSOCIATO
        return $this->belongsTo(Type::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }
}
