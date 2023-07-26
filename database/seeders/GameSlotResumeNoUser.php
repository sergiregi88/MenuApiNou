<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GameSlotResumeNoUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('game_slot_resumes')->insert([
    
            "currentLevelPlay"=>"Game",
            "title"=>"sefgu",
            "screenshot"=>"",
            "gameDificulty"=>0,
            "typeSaveSlot"=>0,
            "timePlayed"=>0,
            "dateTimeSaved"=>now(),
            "game_data_id"=>1,

        ]);
    }
}
