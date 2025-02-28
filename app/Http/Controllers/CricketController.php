<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CricketMatch;

class CricketController extends Controller
{
    /**
     * Display the cricket scoreboard for match ID 1.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // Fetch the match data for ID 1
        $match = CricketMatch::orderBy('updated_at', 'desc')->first();


        if (!$match) {
            // If match not found, return an error message
            return view('cricket-scoreboard', ['error' => 'Match not found']);
        }

        // Prepare the data for the view
        $data = [
            'match_title' => $match->match_title,
            'team1' => $match->team1,
            'team2' => $match->team2,
            'score' => $match->score,
            'batters1' => $match->batters1,
            'batters2' => $match->batters2,
            'bowlers1' => $match->bowlers1,
            'bowlers2' => $match->bowlers2,
            'recent_overs' => $match->recent_overs,
            'crr' => $match->crr,
            'rrr' => $match->rrr,
            'match_status' => $match->match_status,
        ];

        // Pass the data to the view
        return view('cricket-scoreboard', ['data' => $data]);
    }

    /**
     * Fetch live match data for match ID 1 via API (for AJAX polling).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLiveMatchData()
    {
        $match = CricketMatch::orderBy('updated_at', 'desc')->first();

        if (!$match) {
            return response()->json(['error' => 'Match not found'], 404);
        }

        // Prepare the data for the response
        $data = [
            'match_title' => $match->match_title,
            'team1' => $match->team1,
            'team2' => $match->team2,
            'score' => $match->score,
            'batters1' => $match->batters1,
            'batters2' => $match->batters2,
            'bowlers1' => $match->bowlers1,
            'bowlers2' => $match->bowlers2,
            'recent_overs' => $match->recent_overs,
            'crr' => $match->crr,
            'rrr' => $match->rrr,
            'match_status' => $match->match_status,
        ];

        return response()->json(['data' => $data]);
    }
}
