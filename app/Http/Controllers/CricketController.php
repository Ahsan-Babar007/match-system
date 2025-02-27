<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CricketMatch; // Import the model

class CricketController extends Controller
{
    public function index($id = 1) // Default to ID 1 if no ID is provided
    {
        // Fetch match details by a specific ID
        $match = CricketMatch::find($id);

        if (!$match) {
            return view('cricket-scoreboard')->with('error', 'Match not found.');
        }

        // Decode JSON fields before passing to the view
        $match->batters1 = json_decode($match->batters1, true) ?? [];
        $match->batters2 = json_decode($match->batters2, true) ?? [];
        $match->bowlers1 = json_decode($match->bowlers1, true) ?? [];
        $match->bowlers2 = json_decode($match->bowlers2, true) ?? [];
        $match->recent_overs = json_decode($match->recent_overs, true) ?? [];

        return view('cricket-scoreboard', compact('match'));
    }
}
