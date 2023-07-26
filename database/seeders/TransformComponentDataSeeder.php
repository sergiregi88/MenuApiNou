<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TransformComponentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transform_component_data')->insert([
            "isStatic"=>false,
            "isActive"=>true,
            "tag"=>"Untagged",
            "layerMask"=>0,
            "staticFlag"=>0,
            "slot_actor_id"=>1,
            "position"=>json_encode("{'x' 0.0,'y': 0.0,'z': 0.0,'magnitude': 0.0,'sqrMagnitude': 0.0}"),
            "rotation"=>json_encode("{'x': 0.0,'y': 0.0,'z': 0.0,'w': 1.0,'eulerAngles':{'x': 0.0,'y': 0.0,'z': 0.0,'magnitude': 0.0,'sqrMagnitude': 0.0}}"),
            "scale"=>json_encode("{'x': 1.0,'y': 1.0,'z': 1.0,'normalized':{'x': 0.577350259,'y': 0.577350259,'z': 0.577350259,'magnitude': 1.0,'sqrMagnitude': 0.99999994},'magnitude': 1.73205078,'sqrMagnitude': 3.0}"),

        ]);
            
    }
}
