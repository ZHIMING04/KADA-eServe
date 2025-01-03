<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('office_address');
            $table->string('office_city');
            $table->string('office_postcode');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('loan_applicant')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('offices');
    }
};