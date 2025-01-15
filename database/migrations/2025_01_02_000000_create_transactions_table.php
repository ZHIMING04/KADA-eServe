<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->enum('type', ['savings', 'loan']);
            
            // For savings transactions
            $table->string('savings_type')->nullable(); // Which type of savings (share_capital, welfare_fund, etc.)
            
            // Changed to string to match loans table
            $table->string('loan_id', 50)->nullable(); // Which specific loan is being paid
            
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            
            $table->foreign('member_id')->references('id')->on('member_register');
            $table->foreign('loan_id')->references('loan_id')->on('loans');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}; 