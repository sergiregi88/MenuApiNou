<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GameActorData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
               DB::table('game_actor_data')->insert([
            "prefabPath"=>"Prefabs\\ObjectsScene",
            "name"=>"Cube(Clone)",
            "slot_game_id"=>1,

        ]);
    }
}
