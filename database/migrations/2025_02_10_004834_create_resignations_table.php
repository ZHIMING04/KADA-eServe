<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResignationsTable extends Migration
{
    public function up()
    {
        Schema::create('resignations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('member_register')->onDelete('cascade');
            $table->string('reason1');
            $table->string('reason2');
            $table->string('reason3')->nullable();
            $table->string('reason4')->nullable();
            $table->string('reason5')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resignations');
    }
}