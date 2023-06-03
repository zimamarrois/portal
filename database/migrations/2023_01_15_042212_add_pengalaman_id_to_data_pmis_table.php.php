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
        Schema::table('data_pmis', function (Blueprint $table) {
            $table->unsignedBigInteger('pengalaman_id')
            ->nullable();
            $table->foreign('pengalaman_id')
            ->references('id')
            ->on('pengalamen')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_pmis', function (Blueprint $table) {
            //
        });
    }
};
