<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateMemberManagementTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('member_register', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->string('no_anggota');
        $table->string('name');
        $table->string('email');
        $table->string('ic');
        $table->string('phone');
        $table->string('address');
        $table->string('city');
        $table->string('postcode'); // Make sure column name matches
        $table->string('state');
        $table->string('gender');
        $table->date('DOB');
        $table->string('agama');
        $table->string('bangsa');
        $table->string('no_pf');
        $table->string('salary');
        $table->string('office_address');
        $table->string('office_city');
        $table->string('office_postcode');
        $table->string('office_state');
        $table->unsignedBigInteger('guest_id');
        $table->foreign('guest_id')->references('id')->on('users')->onDelete('cascade');
        $table->enum('payment_method', ['cash', 'online'])->default('cash');
        $table->string('payment_proof')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected', 'resigned', 'deceased'])
              ->default('pending');
    });

    Schema::create('working_info', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->string('jawatan');
        $table->string('gred');
        $table->string('no_pf');
        $table->string('salary');
        $table->unsignedBigInteger('no_anggota'); // Add this column
        $table->foreign('no_anggota')->references('id')->on('member_register')->onDelete('cascade');
    });

    Schema::create('family', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->string('relationship');
        $table->string('name');
        $table->string('ic');
        $table->unsignedBigInteger('no_anggota'); // Add this column
        $table->foreign('no_anggota')->references('id')->on('member_register')->onDelete('cascade');
    });

    Schema::create('savings', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->decimal('entrance_fee', 10, 2);
        $table->decimal('share_capital', 10, 2);
        $table->decimal('subscription_capital', 10, 2);
        $table->decimal('member_deposit', 10, 2);
        $table->decimal('welfare_fund', 10, 2);
        $table->decimal('fixed_savings', 10, 2);
        $table->decimal('total_amount', 10, 2);
        $table->unsignedBigInteger('no_anggota');
        $table->foreign('no_anggota')->references('id')->on('member_register')->onDelete('cascade');
    });
}
};

