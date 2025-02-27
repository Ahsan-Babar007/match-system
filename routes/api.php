<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\CricketMatch;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('cricdata', function(Request $request) {
    $data = $request->all();

    // Log incoming request for debugging
    Log::info('Received Data:', ['data' => $data]);

    // Extract nested data correctly
    $matchData = $data['data'] ?? [];

    // Ensure 'teams' structure exists before accessing keys
    $teams = $matchData['teams'] ?? ['team1' => null, 'team2' => null];

    // Check if match already exists based on title
    $match = CricketMatch::where('match_title', Arr::get($matchData, 'title'))->first();

    // If no existing match, create a new one
    if (!$match) {
        $match = new CricketMatch();
    }

    // Update match details
    $match->match_title = Arr::get($matchData, 'title', 'Unknown Title');
    $match->team1 = $teams['team1'] ?? null;
    $match->team2 = $teams['team2'] ?? null;
    $match->score = $matchData['score'] ?? null;

    // Handle JSON encoding safely
    $match->batters1 = !empty($matchData['batters'][0]) ? json_encode($matchData['batters'][0]) : '[]';
    $match->batters2 = !empty($matchData['batters'][1]) ? json_encode($matchData['batters'][1]) : '[]';
    $match->bowlers1 = !empty($matchData['bowlers'][0]) ? json_encode($matchData['bowlers'][0]) : '[]';
    $match->bowlers2 = !empty($matchData['bowlers'][1]) ? json_encode($matchData['bowlers'][1]) : '[]';

    $match->recent_overs = json_encode($matchData['recentOvers'] ?? []);
    $match->crr = $matchData['runRates']['crr'] ?? null;
    $match->rrr = $matchData['runRates']['rrr'] ?? null;
    $match->match_status = $matchData['matchStatus'] ?? null;

    try {
        $match->save();

        return response()->json([
            'message' => $match->wasRecentlyCreated ? 'Match data inserted successfully' : 'Match data updated successfully',
            'match_id' => $match->id
        ], 200);
    } catch (\Exception $e) {
        Log::error('Database Insert Error', ['error' => $e->getMessage(), 'data' => $matchData]);
        return response()->json(['error' => 'Failed to insert/update match data'], 500);
    }
});

Route::get('getMatchDetails', function (Request $request) {
    $match = CricketMatch::where('id', $request->id)
        ->select('match_title', 'team1', 'team2', 'score', 'batters1', 'batters2', 'bowlers1', 'bowlers2', 'recent_overs', 'crr', 'rrr', 'match_status')
        ->first();

    if (!$match) {
        return response()->json("Match Not Found", 404);
    } else {
        return response()->json($match, 200);
    }
});
