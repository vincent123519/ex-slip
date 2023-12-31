<!-- resources/views/counselor/feedback.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Provide Feedback</div>

                    <div class="card-body">
                        <form action="{{ route('counselor.feedback.store', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="feedback_remarks">Feedback Remarks:</label>
                                <textarea class="form-control" name="feedback_remarks" id="feedback_remarks" rows="4" cols="50" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
