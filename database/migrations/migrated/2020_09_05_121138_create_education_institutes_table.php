<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_institutes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('country_id');
            $table->integer('company_id')->nullable();
            $table->text('url');
            $table->string('contact_email');
            $table->string('logo_name');
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('coutries')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('education_institutes');
    }
}
