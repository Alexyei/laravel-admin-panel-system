<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifyCabinetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verify_cabinets', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('new_login', 20)->nullable();
            $table->string('new_email')->nullable();
            $table->string('new_password', 60)->nullable();
            $table->boolean('confirm_email')->default(false);
            $table->boolean('confirm_new_email');
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
        Schema::dropIfExists('verify_cabinets');
    }
}
