<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CricketController extends Controller
{
    public function index()
    {
        $apiUrl = 'http://system.greek-system.com/api/getMatchDetails?id=4';

        try {
            $response = Http::get($apiUrl);
            if ($response->failed()) {
                throw new \Exception('Failed to fetch match details.');
            }

            $data = $response->json();
            return view('cricket-scoreboard', compact('data'));

        } catch (\Exception $e) {
            return view('cricket-scoreboard')->with('error', $e->getMessage());
        }
    }
}
