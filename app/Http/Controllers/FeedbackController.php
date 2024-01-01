<?php

namespace App\Http\Controllers;


use App\Models\Feedback;
use App\Models\User;
use App\Models\ExcuseSlip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all();

        return view('feedback.index', compact('feedbacks'));
        // Assuming you have a blade view file at resources/views/feedback/index.blade.php
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('feedback.show', compact('feedback'));
        // Assuming you have a blade view file at resources/views/feedback/show.blade.php
    }

    // You can add other CRUD methods (create, edit, update, destroy) as needed.

    // Example create method
    public function create()
    {
        // You may need to provide necessary data to the view, such as users or excuse slips
        $users = User::all();
        $excuseSlips = ExcuseSlip::all();

        return view('feedback.create', compact('users', 'excuseSlips'));
    }

    // Example store method for handling form submission
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'excuse_slip_id' => 'required',
            'feedback_remarks' => 'required',
            'feedback_date' => 'required',
            'sender_id' => 'required',
            'feedback_type' => 'required',
        ]);

        $feedback = Feedback::create($validatedData);

        return redirect()->route('feedback.show', $feedback->feedback_id);
    }

    // Example edit method
    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('feedback.edit', compact('feedback'));
        // Assuming you have a blade view file at resources/views/feedback/edit.blade.php
    }

    // Example update method
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'excuse_slip_id' => 'required',
            'feedback_remarks' => 'required',
            'feedback_date' => 'required',
            'sender_id' => 'required',
            'feedback_type' => 'required',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update($validatedData);

        return redirect()->route('feedback.show', $feedback->feedback_id);
    }

    // Example destroy method
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedback.index');
    }
}
