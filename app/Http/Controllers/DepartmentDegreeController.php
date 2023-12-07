<?php

namespace App\Http\Controllers;

use App\Models\DepartmentDegree;
use Illuminate\Http\Request;

class DepartmentDegreeController extends Controller
{
    /**
     * Display a listing of the department degrees.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departmentDegrees = DepartmentDegree::all();
        return response()->json(['department_degrees' => $departmentDegrees], 200);
    }

    /**
     * Store a newly created department degree in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'degree_name' => 'required',
        ]);

        $departmentDegree = DepartmentDegree::create($request->all());

        return response()->json(['department_degree' => $departmentDegree], 201);
    }

    /**
     * Display the specified department degree.
     *
     * @param  \App\Models\DepartmentDegree  $departmentDegree
     * @return \Illuminate\Http\Response
     */
    public function show(DepartmentDegree $departmentDegree)
    {
        return response()->json(['department_degree' => $departmentDegree], 200);
    }

    /**
     * Update the specified department degree in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DepartmentDegree  $departmentDegree
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentDegree $departmentDegree)
    {
        $request->validate([
            'department_id' => 'required',
            'degree_name' => 'required',
        ]);

        $departmentDegree->update($request->all());

        return response()->json(['department_degree' => $departmentDegree], 200);
    }

    /**
     * Remove the specified department degree from storage.
     *
     * @param  \App\Models\DepartmentDegree  $departmentDegree
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentDegree $departmentDegree)
    {
        $departmentDegree->delete();

        return response()->json(['message' => 'Department degree deleted successfully'], 200);
    }
}