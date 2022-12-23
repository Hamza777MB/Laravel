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
        Schema::create('experts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            //$table->binary('photo')->nullable();
            $table->string('photo')->nullable();
            $table->text('details')->nullable();
            $table->biginteger('number')->nullable();
            $table->string('address')->nullable();
            $table->string('start_hour')->nullable();
            $table->string('end_hour')->nullable();
            $table->text('token')->nullable();
            $table->float('rating')->nullable();
            $table->integer('rate_num')->nullable();
            $table->integer('wallet');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('experts');
    }
};
