<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLoanManagementTable extends Migration
{
    public function up()
    {
        // Create Members Table
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('state', 100)->nullable();
            $table->text('office_address')->nullable();
            $table->string('office_city', 100)->nullable();
            $table->string('office_postcode', 10)->nullable();
            $table->timestamps();
        });

        // Create LoanTypes Table
        Schema::create('loan_types', function (Blueprint $table) {
            $table->id('loan_type_id');
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
            $table->double('interest_rate', 5, 2);
            $table->double('monthly_repayment', 10, 2);
            $table->double('monthly_gross_salary', 10, 2);
            $table->double('monthly_net_salary', 10, 2);
            $table->integer('loan_period');
            $table->string('status')->default('pending');
            $table->timestamps();

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
            $table->string('ic', 20);
            $table->string('phone', 15);
            $table->text('address');
            $table->enum('relationship', ['parent', 'spouse', 'sibling', 'relative', 'friend']);
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
        // Drop tables in reverse order to handle foreign key constraints
        Schema::dropIfExists('loans');
        Schema::dropIfExists('banks');
        Schema::dropIfExists('loan_types');
        Schema::dropIfExists('members');
    }
}