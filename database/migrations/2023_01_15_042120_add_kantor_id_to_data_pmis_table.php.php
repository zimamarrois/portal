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
            $table->unsignedBigInteger('kantor_id')
            ->nullable();
            $table->foreign('kantor_id')
            ->references('id')
            ->on('kantors')
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
