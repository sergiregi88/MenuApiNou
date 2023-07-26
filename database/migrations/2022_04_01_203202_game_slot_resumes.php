<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GameSlotResumes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_slot_resumes', function (Blueprint $table) {
            $table->id();
            $table->string("currentLevelPlay")->default("")->nullable();
            $table->string("title")->default("")->nullable();
            $table->string("screenshot")->default("");
            $table->unsignedTinyInteger("gameDificulty");
            $table->unsignedTinyInteger("typeSaveSlot");
            $table->datetime("dateTimeSaved");
            $table->unsignedBigInteger("timePlayed");
            $table->timestamps();
            $table->unsignedBigInteger('game_data_id');
            $table->softDeletes();
            $table->foreign('game_data_id')->references('id')->on('game_data') ->onUpdate('cascade')
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
        Schema::dropIfExists('game_slot_resumes');
    }
}
