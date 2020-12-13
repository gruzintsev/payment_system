<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('country', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('currency_iso')->default('USD');
            $table->unsignedFloat('balance')->nullable()->default(0);
            $table->string('password');
            $table->timestamps();

            $table->index('currency_iso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
