<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    
   public function projects()
   {
    // UN TYPE POTRà AVERE PIù PROJECTS ASSOCIATI PERCIò 'PROJECTS()'
     return $this->hasMany(Project::class);
   }
}
