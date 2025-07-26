<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->foreignId("league_id")->constrained();
            $table->foreignId("home_team_id")->references("id")->on("teams");
            $table->foreignId("away_team_id")->references("id")->on("teams");
            $table->dateTime("match_date");
            $table->string("location");
            $table->integer("home_score");
            $table->integer("away_score");
            $table->enum("status",['scheduled, finished, canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
