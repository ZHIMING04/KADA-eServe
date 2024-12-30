<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registered_members', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('ic');
            $table->string('address');
            $table->string('city');
            $table->string('poskod');
            $table->string('state');
            $table->enum('gender', ['Lelaki', 'Perempuan']);
            $table->string('gred');
            $table->string('salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registered_members');
    }
};
