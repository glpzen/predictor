<?php

namespace App\Http\Services;

use App\LeagueTable;
use Illuminate\Support\Facades\DB;

class PlayWeekMatches{

    private static $weeks = [];

    public static function setWeeks(){
        self::$weeks = [
            1 => [
                'group_a' => [
                    [
                        'id' => 1,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 2,
                        'gf' =>  rand(0, 5),
                    ]
                ],
                'group_b' => [
                    [
                        'id' => 3,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 4,
                        'gf' =>  rand(0, 5),
                    ]
                ],
            ],
            2 => [
                'group_a' => [
                    [
                        'id' => 1,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 3,
                        'gf' =>  rand(0, 5),
                    ]
                ],
                'group_b' => [
                    [
                        'id' => 2,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 4,
                        'gf' =>  rand(0, 5),
                    ]
                ],
            ],
            3 => [
                'group_a' => [
                    [
                        'id' => 1,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 4,
                        'gf' =>  rand(0, 5),
                    ]
                ],
                'group_b' => [
                    [
                        'id' => 2,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 3,
                        'gf' =>  rand(0, 5),
                    ]
                ],
            ],
            4 => [
                'group_a' => [
                    [
                        'id' => 1,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 2,
                        'gf' =>  rand(0, 5),
                    ]
                ],
                'group_b' => [
                    [
                        'id' => 3,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 4,
                        'gf' =>  rand(0, 5),
                    ]
                ],
            ],
            5 => [
                'group_a' => [
                    [
                        'id' => 1,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 3,
                        'gf' =>  rand(0, 5),
                    ]
                ],
                'group_b' => [
                    [
                        'id' => 2,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 4,
                        'gf' =>  rand(0, 5),
                    ]
                ],
            ],
            6 => [
                'group_a' => [
                    [
                        'id' => 1,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 4,
                        'gf' =>  rand(0, 5),
                    ]
                ],
                'group_b' => [
                    [
                        'id' => 2,
                        'gf' =>  rand(0, 5),
                    ],
                    [
                        'id' => 3,
                        'gf' =>  rand(0, 5),
                    ]
                ],
            ]
        ];

    }

    public static function play($week)
    {

        self::setWeeks($week);

        $weekData = self::$weeks[$week] ?? [];
        foreach ($weekData as $team){

            $teamX = $team[0];
            $teamY = $team[1];

            $pointsY = 0;
            $pointsX = 0;
            $wonY = 0;
            $wonX = 0;
            $drawnY = 0;
            $drawnX = 0;
            $lostY = 0;
            $lostX = 0;
            $goalsDifferenceY = 0;
            $goalsDifferenceX = 0;
            if($teamX['gf'] > $teamY['gf']){
                $pointsX = 3;
                $wonX = 1;
                $goalsDifferenceX = $teamX['gf'] - $teamY['gf'];
                $lostY = 1;
            }else if($teamX['gf'] == $teamY['gf']){
                $pointsX = 1;
                $pointsY = 1;
                $drawnX = 1;
                $drawnY = 1;
            }else{
                $lostX = 1;
                $pointsY = 3;
                $wonY = 1;
                $goalsDifferenceY = $teamY['gf'] - $teamX['gf'];
            }

            if($week > 1){
                $lastWeekX = DB::table('league_tables')->where([
                    ['week', ($week - 1)],
                    ['team_id', $teamX['id']]
                ])->first();

                $lastWeekY = DB::table('league_tables')->where([
                    ['week', ($week - 1)],
                    ['team_id', $teamY['id']]
                ])->first();

                $pointsX += $lastWeekX->points ?? 0;
                $pointsY += $lastWeekY->points ?? 0;
                $wonX += $lastWeekX->won ?? 0;
                $wonY += $lastWeekY->won ?? 0;
                $drawnX += $lastWeekX->drawn ?? 0;
                $drawnY += $lastWeekY->drawn ?? 0;
                $lostX += $lastWeekX->lost ?? 0;
                $lostY += $lastWeekY->lost ?? 0;
                $goalsDifferenceX += $lastWeekX->goals_difference ?? 0;
                $goalsDifferenceY += $lastWeekY->goals_difference ?? 0;
            }

            LeagueTable::updateOrCreate([
                'team_id' => $teamX['id'],
                'week' => $week
            ], [
                'team_id' => $teamX['id'],
                'week' => $week,
                'points' => $pointsX,
                'played' => $week,
                'won' => $wonX,
                'drawn' => $drawnX,
                'lost' => $lostX,
                'goals_difference' => $goalsDifferenceX,
                'opposing_team' => $teamY['id']
            ]);

            LeagueTable::updateOrCreate([
                'team_id' => $teamY['id'],
                'week' => $week
            ], [
                'team_id' => $teamY['id'],
                'week' => $week,
                'points' => $pointsY,
                'played' => $week,
                'won' => $wonY,
                'drawn' => $drawnY,
                'lost' => $lostY,
                'goals_difference' => $goalsDifferenceY,
                'opposing_team' => $teamX['id']
            ]);
        }

    }
}