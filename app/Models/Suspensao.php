<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspensao extends Model
{
    use HasFactory;


    protected $table = 'nx_510_bl_suspensao';

    protected $fillable = [
        'player_id',
    ];
}
