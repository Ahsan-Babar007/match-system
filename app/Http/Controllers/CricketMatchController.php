<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CricketMatch;

class CricketMatchController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'match_title' => 'required|string',
            'team1' => 'nullable|string',
            'team2' => 'nullable|string',
            'score' => 'nullable|string',
            'batters1' => 'nullable|array',
            'batters2' => 'nullable|array',
            'bowlers1' => 'nullable|array',
            'bowlers2' => 'nullable|array',
            'recent_overs' => 'nullable|string',
            'crr' => 'nullable|string',
            'rrr' => 'nullable|string',
            'match_status' => 'nullable|string',
        ]);

        // Convert array fields to JSON
        $validatedData['batters1'] = json_encode($request->batters1);
        $validatedData['batters2'] = json_encode($request->batters2);
        $validatedData['bowlers1'] = json_encode($request->bowlers1);
        $validatedData['bowlers2'] = json_encode($request->bowlers2);

        $match = CricketMatch::updateOrCreate(
            ['match_title' => $validatedData['match_title']],
            $validatedData
        );

        return response()->json(['message' => 'Match data stored successfully', 'match' => $match], 200);
    }

    public function getScoreboard()
{
    // Fetch the latest match data (replace 1 with the actual match ID or dynamic logic)
    $match = CricketMatch::orderBy('updated_at', 'desc')->first();

    if (!$match) {
        return response()->json(['error' => 'Match not found'], 404);
    }

    // Prepare the data for the response
    $data = [
        'team1' => $match->team1,
        'team2' => $match->team2,
        'score1' => $match->score, // Update this field if you have separate scores for team1 and team2
        'score2' => $match->score, // Update this field if you have separate scores for team1 and team2
        'overs' => $match->overs ?? '0', // Add this field to your database if missing
        'crr' => $match->crr,
        'rrr' => $match->rrr,
        'recent_overs' => $match->recent_overs,
        'batters1' => $match->batters1,
        'batters2' => $match->batters2,
        'bowlers1' => $match->bowlers1,
        'bowlers2' => $match->bowlers2,
    ];

    return response()->json($data);
}

}
