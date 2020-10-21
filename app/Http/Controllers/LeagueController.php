<?php

namespace App\Http\Controllers;

use App\Http\Services\PlayWeekMatches;
use App\LeagueTable;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index(int $week)
    {

        $rows = LeagueTable::where('week', $week)->with(['team', 'opposingTeam'])->get();

        return response()->json([
            'message'=> 'ok',
            'rows' => $rows
        ]);
    }

    public function play(Request $request)
    {
        $week = $request->input('week');

        PlayWeekMatches::play($week);

        $rows = LeagueTable::where('week', $week)->with(['team', 'opposingTeam'])->get();

        return response()->json([
            'message'=> 'ok',
            'rows' => $rows
        ]);

    }
}
