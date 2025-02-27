<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cricket_matches', function (Blueprint $table) {
            $table->id();
            $table->string('match_title')->index();
            $table->string('team1')->nullable()->index();
            $table->string('team2')->nullable()->index();
            $table->string('score')->nullable()->index();
            $table->string('batters1', 1000)->nullable()->index(); // Use VARCHAR with a specified length
            $table->string('batters2', 1000)->nullable()->index(); // Use VARCHAR with a specified length
            $table->string('bowlers1', 1000)->nullable()->index(); // Use VARCHAR with a specified length
            $table->string('bowlers2', 1000)->nullable()->index(); // Use VARCHAR with a specified length 
            $table->string('recent_overs')->nullable()->index();
            $table->string('crr')->nullable()->index();
            $table->string('rrr')->nullable()->index();
            $table->string('match_status')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
