<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class showScore extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'cricket_matches';

    // Define fillable fields (optional, but recommended for mass assignment)
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
        'match_status',
    ];

    // Cast JSON fields to arrays
    protected $casts = [
        'batters1' => 'array',
        'batters2' => 'array',
        'bowlers1' => 'array',
        'bowlers2' => 'array',
        'recent_overs' => 'array',
    ];
}