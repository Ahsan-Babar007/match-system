<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Match; // Import your Match model

class LiveScoreController extends Controller
{
    public function getLiveMatchData()
    {
        $match = DB::table('cricket_matches')
            ->select(
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
            )
            ->orderBy('updated_at', 'desc') // Order by the most recent updated_at
            ->first();
    
        if (!$match) {
            return response()->json(['error' => 'No live match found'], 404);
        }
    
            return response()->json([
                'data' => [
                    'match_title' => $match->match_title,
                    'team1' => $match->team1,
                    'team2' => $match->team2,
                    'score' => $match->score,
                    'batters1' => json_decode($match->batters1, true),
                    'batters2' => json_decode($match->batters2, true),
                    'bowlers1' => json_decode($match->bowlers1, true),
                    'bowlers2' => json_decode($match->bowlers2, true),
                    'recent_overs' => json_decode($match->recent_overs, true), // No need to decode it

                    'crr' => $match->crr,
                    'rrr' => $match->rrr,
                    'match_status' => $match->match_status
                ]
            ]);
    }
}
