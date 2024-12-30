<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loan_applicant', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ic');
            $table->date('dob');
            $table->string('gender');
            $table->string('agama');
            $table->string('bangsa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_applicants');
    }
};

