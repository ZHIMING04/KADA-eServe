<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualReportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('annual_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->year('year');
            $table->string('thumbnail'); // For the photo
            $table->string('file_path'); // For the PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('annual_reports');
    }
}
