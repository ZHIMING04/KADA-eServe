<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('financings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('jenis_pembiayaan');
            $table->string('amaun_dipohon');
            $table->string('tempoh_pembiayaan');
            $table->string('ansuran_bulanan');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('loan_applicant')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
        });
    }

    public function down(){
       Schema::dropIfExists('financings');
    }
};
