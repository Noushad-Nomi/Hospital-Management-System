<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = DB::table('employees')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $branches = DB::table('branches')->get();
        return view('employees.create', compact('branches'));
    }

    public function store(Request $request)
    {
      
        // ✅ Step 1: Validate input
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'branch_id' => 'required|integer',
            'basic_salary' => 'required',
            'phone' => 'required',
            'joining_date' => 'required|date',
        ]);

        // ✅ Step 2: Remove comma from salary input
        $salary = str_replace(',', '', $request->basic_salary);

        // ✅ Step 3: Insert into database
        DB::table('employees')->insert([
            'name' => $request->name,
            'designation' => $request->designation,
            'branch_id' => $request->branch_id,
            'basic_salary' => $salary,
            'phone' => $request->phone,
            'joining_date' => $request->joining_date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

      

        // ✅ Step 4: Redirect with success message
        return redirect('employees')->with('success', 'Employee added successfully!');
    }
}
