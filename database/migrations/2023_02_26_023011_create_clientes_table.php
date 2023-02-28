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
    Schema::create('clientes', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('domain');
        $table->json('permissions');
        $table->string('database_name');
        $table->string('db_host');
        $table->string('db_port');
        $table->string('db_database');
        $table->string('db_username');
        $table->string('db_password');
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
        Schema::dropIfExists('clientes');
    }
};
