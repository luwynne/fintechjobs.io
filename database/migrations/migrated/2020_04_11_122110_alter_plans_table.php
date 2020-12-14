<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->text('description')->change();
            $table->boolean('social_media_allowed')->default(false);
            $table->boolean('video_allowed')->default(false);
            $table->integer('events_allowance')->nullable();
            $table->integer('adverts_allowance')->nullable();
            $table->integer('type_id')->default(1);
            $table->foreign('type_id')->references('id')->on('plan_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
