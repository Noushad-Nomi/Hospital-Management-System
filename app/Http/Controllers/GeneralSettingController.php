<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\Branch;

class GeneralSettingController extends Controller
{
    public function index()
{
    $branches = Branch::all();
    return view('settings.general', compact('branches'));
}

public function update(Request $request)
{
    foreach ($request->fees as $branchId => $fee) {
        GeneralSetting::updateOrCreate(
            ['branch_id' => $branchId],
            ['default_checkup_fee' => $fee]
        );
    }

    return redirect()->back()->with('success', 'Settings updated.');
}

}
