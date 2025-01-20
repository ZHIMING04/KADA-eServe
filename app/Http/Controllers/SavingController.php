<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Setting;

class SavingController extends Controller
{
    public function updateSavingsBalance()
    {
        $rate = Setting::where('key', 'dividend_rate')->first()->value ?? 5.00;
        // Retrieve all savings records from the database
        $savingsRecords = DB::table('savings')->get();

        foreach ($savingsRecords as $record) {
            // Calculate the new balance based on the provided rate
            $newBalance = $record->balance + ($record->balance * ($rate / 100));

            // Update the balance in the database
            DB::table('savings')
                ->where('id', $record->id)->update(['balance' => round($newBalance,2)]);
        }
    }
}