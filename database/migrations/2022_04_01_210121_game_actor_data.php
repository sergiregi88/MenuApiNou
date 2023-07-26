<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GameActorData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_actor_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slot_game_id');
           // $table->json("Transform");
            $table->string("prefabPath");
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('slot_game_id')->references('id')->on('slot_game_data') ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_actor_data');
    }
}
