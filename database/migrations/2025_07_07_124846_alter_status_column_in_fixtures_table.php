<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->enum('status', ['scheduled', 'finished', 'canceled'])->change();
        });
    }

    public function down()
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->enum('status', ['scheduled, finished, canceled'])->change();
        });
    }
};
