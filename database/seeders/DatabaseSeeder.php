<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GameDataNoUser::class,
            GameSlotResumeNoUser::class,
            SlotGameData::class,
            GameActorData::class,
            TransformComponentDataSeeder::class
        ]);
    }
}
