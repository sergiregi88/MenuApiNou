<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SlotGameData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_game_data', function (Blueprint $table) {
            $table->id();
            $table->float("health");
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('game_slot_resume_id');
            $table->foreign('game_slot_resume_id')->references('id')->on('game_slot_resumes') ->onUpdate('cascade')
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
        Schema::dropIfExists('slot_game_data');
    }
}
