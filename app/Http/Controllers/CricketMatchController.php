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
}
