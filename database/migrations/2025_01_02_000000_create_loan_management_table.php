<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLoanManagementTable extends Migration
{
    public function up()
    {

        // Create LoanTypes Table
        Schema::create('loan_types', function (Blueprint $table) {
            $table->unsignedBigInteger('loan_type_id')->primary();
            $table->string('loan_type', 100);
            $table->timestamps();
        });

        // Create Banks Table
        Schema::create('banks', function (Blueprint $table) {
            $table->id('bank_id');
            $table->string('bank_name', 100);
            $table->string('bank_account', 20);
            $table->timestamps();
        });

        // Create Loans Table
        Schema::create('loans', function (Blueprint $table) {
            $table->string('loan_id', 50)->primary();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('loan_type_id');
            $table->unsignedBigInteger('bank_id');
            $table->date('date_apply');
            $table->double('loan_amount', 10, 2);
            $table->double('loan_total_repayment', 10, 2);
            $table->double('loan_balance', 10, 2);
            $table->double('interest_rate', 5, 2);
            $table->double('monthly_repayment', 10, 2);
            $table->double('monthly_gross_salary', 10, 2);
            $table->double('monthly_net_salary', 10, 2);
            $table->integer('loan_period');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->text('rejection_reason')->nullable();
            

            // Foreign Key Constraints
            $table->foreign('member_id')
                  ->references('id')
                  ->on('member_register')
                  ->onDelete('cascade');
            $table->foreign('loan_type_id')
                  ->references('loan_type_id')
                  ->on('loan_types')
                  ->onDelete('cascade');
            $table->foreign('bank_id')
                  ->references('bank_id')
                  ->on('banks')
                  ->onDelete('cascade');
        });

        // Create Guarantors Table
        Schema::create('guarantors', function (Blueprint $table) {
            $table->id('guarantor_id');
            $table->string('loan_id', 50);
            $table->string('name');
            $table->string('no_pf', 20);
            $table->string('ic', 12);
            $table->string('phone',15);
            $table->string('no_anggota', 20);
            $table->integer('guarantor_order'); // 1 for first guarantor, 2 for second guarantor
            $table->timestamps();

            $table->foreign('loan_id')
                  ->references('loan_id')
                  ->on('loans')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Drop tables in correct order (reverse of creation)
        Schema::dropIfExists('member_transactions');  // Drop this first as it references loans
        Schema::dropIfExists('guarantors');          // Then drop guarantors as it references loans
        Schema::dropIfExists('loans');               // Now we can safely drop loans
        Schema::dropIfExists('banks');
        Schema::dropIfExists('loan_types');
    }
}