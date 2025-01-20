<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        // Insert default values
        DB::table('settings')->insert([
            ['key' => 'dividend_rate', 'value' => '5.00'],
            ['key' => 'interest_rate', 'value' => '5.00'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}; 