<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanType;

class LoanTypeSeeder extends Seeder
{
    public function run()
    {
        LoanType::insert([
            ['loan_type_id' => 1, 'loan_type' => 'Al-Bai', 'created_at' => now()],
            ['loan_type_id' => 2, 'loan_type' => 'Al-Inah', 'created_at' => now()],
            ['loan_type_id' => 3, 'loan_type' => 'Skim Khas', 'created_at' => now()],
            ['loan_type_id' => 4, 'loan_type' => 'Karnival Muslim Istimewa', 'created_at' => now()],
            ['loan_type_id' => 5, 'loan_type' => 'Baik Pulih Kenderaan', 'created_at' => now()],
            ['loan_type_id' => 6, 'loan_type' => 'Cukai Jalan', 'created_at' => now()]
        ]);
    }
} 