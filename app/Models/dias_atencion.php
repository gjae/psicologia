<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dias_atencion extends Model
{
    use HasFactory;
    
    protected $table    = 'dias_atencion';
    protected $fillable = ['nombre'];
}
