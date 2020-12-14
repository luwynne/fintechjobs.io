<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('start_date');
            $table->string('end_date');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country_id');
            $table->double('fee')->nullable();
            $table->string('url')->nullable();
            $table->string('file_name')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
}
