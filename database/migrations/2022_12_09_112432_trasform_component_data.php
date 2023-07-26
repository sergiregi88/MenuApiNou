<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrasformComponentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('transform_component_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slot_actor_id');
            $table->foreign('slot_actor_id')->references('id')->on('game_actor_data') ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->json("position");
            $table->json("rotation");
            $table->json("scale");
            $table->boolean("isActive");
            $table->integer("layerMask");
            $table->string("tag");
            $table->boolean("isStatic");
            $table->integer("staticFlag");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transform_component_data');
    }
}
