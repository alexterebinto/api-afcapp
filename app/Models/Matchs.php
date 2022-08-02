<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matchs extends Model
{
    use HasFactory;

    protected $table = 'nx510_bl_match';

    protected $fillable = [
        'match_descr',
        'm_id',
        'team1_id',
        'team2_id',
        'score1',
        'score2',
        'published',
        'is_extra',
        'm_played',
        'm_date',
        'm_time',
        'm_location'
    ];

    public function events()
    {
        return $this->hasMany(MatchEvent::class, 'match_id', 'id');
    }

    public function matchday()
    {
        return $this->hasOne(Matchday::class, 'id', 'm_id');
    }
}
