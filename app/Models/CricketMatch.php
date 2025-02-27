<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CricketMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_title',
        'team1',
        'team2',
        'score',
        'batters1',
        'batters2',
        'bowlers1',
        'bowlers2',
        'recent_overs',
        'crr',
        'rrr',
        'match_status'
    ];
}
