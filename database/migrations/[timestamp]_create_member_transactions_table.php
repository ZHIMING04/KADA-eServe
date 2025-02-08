<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('member_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->foreignId('member_id')->references('id')->on('member_register')->onDelete('cascade');
            $table->enum('type', ['savings', 'loan']);
            $table->enum('savings_type', ['share_capital', 'subscription_capital', 'member_deposit', 'welfare_fund', 'fixed_savings'])->nullable();
            $table->string('loan_id', 50)->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['online', 'cash']);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // Foreign key for loan_id
            $table->foreign('loan_id')
                  ->references('loan_id')
                  ->on('loans')
                  ->onDelete('cascade');

            // Foreign key for approved_by
            $table->foreign('approved_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_transactions');
    }
}; 