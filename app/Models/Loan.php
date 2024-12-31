<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Loan extends Model
{
    protected $table = 'loan';
    
    protected $fillable = [
        'jenis_pembiayaan',
        'amaun_dipohon',
        'tempoh_pembiayaan',
        'ansuran_bulanan',
        'name',
        'ic',
        'dob',
        'gender',
        'agama',
        'bangsa',
        'address',
        'city',
        'postcode',
        'state',
        'member_no',
        'pf_no',
        'office_address',
        'office_city',
        'office_postcode',
        'bank',
        'bank_no',
    ];
}