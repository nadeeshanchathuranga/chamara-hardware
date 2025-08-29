<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }
        $allemployee = Employee::orderBy('created_at', 'desc')->get();



        return Inertia::render('Employee/Index', [
            'allemployee' => $allemployee,
            'totalEmployee' => $allemployee->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Authorization check
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }


        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|regex:/^[\w\.-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z]{2,6}$/|unique:employees,email',
            'phone' => 'nullable|string|regex:/^\d{10}$/',
        ]);


        $lastEmployee = Employee::orderBy('id', 'desc')->first();

        if ($lastEmployee && $lastEmployee->employee_id) {

            $lastIdNum = (int) filter_var($lastEmployee->employee_id, FILTER_SANITIZE_NUMBER_INT);
            $nextIdNum = $lastIdNum + 1;


            $newEmployeeId = 'EMP' . str_pad($nextIdNum, 3, '0', STR_PAD_LEFT);
        } else {

            $newEmployeeId = 'EMP001';
        }


        $employee = Employee::create(array_merge($validated, [
            'employee_id' => $newEmployeeId
        ]));


        return redirect()->route('employees.index')->banner('Employee created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {


        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);
        $employee->update($validated);

        return redirect()->route('employees.index')->banner('Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {



        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $employee->delete();
        return redirect()->route('employees.index')->banner('Employee Deleted successfully.');
    }
}
