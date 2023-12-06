<?php

namespace App\Http\Controllers;

use App\Models\ExcuseStatus;
use Illuminate\Http\Request;

class ExcuseStatusController extends Controller
{
    /**
     * Display a listing of the excuse statuses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $excuseStatuses = ExcuseStatus::all();
        return response()->json(['excuseStatuses' => $excuseStatuses], 200);
    }

    /**
     * Store a newly created excuse status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status_name' => 'required',
        ]);

        $excuseStatus = ExcuseStatus::create($request->all());

        return response()->json(['excuseStatus' => $excuseStatus], 201);
    }

    /**
     * Display the specified excuse status.
     *
     * @param  \App\Models\ExcuseStatus  $excuseStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ExcuseStatus $excuseStatus)
    {
        return response()->json(['excuseStatus' => $excuseStatus], 200);
    }

    /**
     * Update the specified excuse status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExcuseStatus  $excuseStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExcuseStatus $excuseStatus)
    {
        $request->validate([
            'status_name' => 'required',
        ]);

        $excuseStatus->update($request->all());

        return response()->json(['excuseStatus' => $excuseStatus], 200);
    }

    /**
     * Remove the specified excuse status from storage.
     *
     * @param  \App\Models\ExcuseStatus  $excuseStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExcuseStatus $excuseStatus)
    {
        $excuseStatus->delete();

        return response()->json(['message' => 'Excuse status deleted successfully'], 200);
    }
}