<?php

use Illuminate\Database\Seeder;

class TeemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $teams = [
            "Arsenal",
            "Chelsea",
            "Liverpool",
            "Manchester"
        ];



        foreach ($teams as $team){
            DB::table('teams')->insert([
                'name' => $team,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ]);
        }


    }
}
