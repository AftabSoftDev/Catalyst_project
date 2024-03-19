<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_records', function (Blueprint $table) {
            $table->id();
            $table->string(
                'company_id'
            )->nullable();
            $table->string(
                'name'
            )->nullable();
            $table->longText(
                'domain'
            )->nullable();
            $table->string(
                'year_of_foudation'
            )->nullable();
            $table->string(
                'industry'
            )->nullable();
            $table->string(
                'size_range'
            )->nullable();
            $table->longText(
                'locality'
            )->nullable();
            $table->string(
                'country'
            )->nullable();
            $table->longText(
                'linkedin_url'
            )->nullable();
            $table->string(
                'curr_emp'
            )->nullable();
            $table->string('estim_emp')->nullable();
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
        Schema::dropIfExists('file_records');
    }
};
