<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLoanManagementTable extends Migration
{
    public function up()
    {
        // Create loan_types first
        Schema::create('loan_types', function (Blueprint $table) {
            $table->id('loan_type_id');
            $table->string('loan_type', 100);
            $table->timestamps();
        });

        Schema::create('guarantors', function (Blueprint $table) {   
            $table->string('guarantor_id', 50)->primary();
            $table->string('no_pf');
            $table->string('name');
            $table->string('ic');
            $table->string('phone');
            $table->timestamps();
        });

        // Then banks
        Schema::create('banks', function (Blueprint $table) {
            $table->id('bank_id');
            $table->string('bank_name', 100);
            $table->string('bank_account', 20);
            $table->timestamps();
        });

        // Then loans
        Schema::create('loans', function (Blueprint $table) {
            $table->string('loan_id', 50)->primary();
            $table->string('no_anggota');
            $table->unsignedBigInteger('loan_type_id');
            $table->unsignedBigInteger('bank_id');
            $table->date('date_apply');
            $table->decimal('loan_amount', 10, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('monthly_repayment', 10, 2);
            $table->decimal('monthly_gross_salary', 10, 2);
            $table->decimal('monthly_net_salary', 10, 2);
            $table->integer('loan_period');
            $table->enum('status', ['pending', 'approved', 'rejected', ])->default('pending');
            $table->timestamps();
        });

        // Add all foreign keys in one place
        Schema::table('loans', function (Blueprint $table) {
            $table->foreign('no_anggota')
                  ->references('no_anggota')
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

        // Create guarantors table
}
    public function down()
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('banks');
        Schema::dropIfExists('loan_types');
        Schema::dropIfExists('member_register');
    }
}
    

