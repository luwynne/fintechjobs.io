<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_organiser');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->string('city')->nullable();
            $table->string('country_id');
            $table->string('fee')->nullable();
            $table->text('url')->nullable();
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_events');
    }
}
