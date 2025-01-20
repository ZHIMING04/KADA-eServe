<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function updateDividendRate(Request $request)
    {
        $validated = $request->validate([
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        Setting::updateOrCreate(
            ['key' => 'dividend_rate'],
            ['value' => $validated['rate']]
        );

        return response()->json(['success' => true]);
    }

    public function updateInterestRate(Request $request)
    {
        $validated = $request->validate([
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        Setting::updateOrCreate(
            ['key' => 'interest_rate'],
            ['value' => $validated['rate']]
        );

        return response()->json(['success' => true]);
    }
} 