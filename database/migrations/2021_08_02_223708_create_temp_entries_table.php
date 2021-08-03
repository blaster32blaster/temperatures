<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('world_countries');
            $table->foreignId('city_id')->nullable()->constrained('world_cities');
            $table->dateTime('date');
            $table->integer('temperature');
            $table->string('standard');
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
        Schema::dropIfExists('temp_entries');
    }
}
