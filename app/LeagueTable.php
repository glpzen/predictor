<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueTable extends Model
{
    protected $fillable = [
        'team_id', 'week',
        'points',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_difference',
        'opposing_team',
    ];

    public function team()
    {
        return $this->belongsTo('App\Team', 'team_id');
    }

    public function opposingTeam()
    {
        return $this->belongsTo('App\Team', 'opposing_team');
    }


}
