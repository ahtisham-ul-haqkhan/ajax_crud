<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $data = $request->all();
        Employee::create($data);
        return response()->json([
            'data' => $data,
            'success' => 'Data Submit Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $show = Employee::get();

        return response()->json([
            'show' => $show
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            $employee->update($validatedData);

            return response()->json(['message' => 'Employee updated successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Employee not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee,Request $request)
    {
        Employee::findOrFail($request->id)->delete();
    }
}
