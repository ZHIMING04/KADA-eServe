<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('bank');
            $table->string('bank_no');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('loan_applicant')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('banks');
    }
};