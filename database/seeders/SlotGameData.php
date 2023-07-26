<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SlotGameData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slot_game_data')->insert([
    
            "health"=>0.5,
            "game_slot_resume_id"=>1,

        ]);
    }
}
