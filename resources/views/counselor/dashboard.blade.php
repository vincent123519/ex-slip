@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Counselor Dashboard</h1>

        <div class="row">
            <div class="col-md-6">
                <h3>Excuse Slip List</h3>
                @if (isset($excuseSlips) && count($excuseSlips) > 0)
                    <ul>
                        @foreach ($excuseSlips as $excuseSlip)
                            <li>Excuse Slip ID: {{ $excuseSlip->excuse_slip_id }}</li>
                            <!-- Display other details of each excuse slip -->
                        @endforeach
                    </ul>
                @else
                    <p>No excuse slips found.</p>
                @endif
            </div>

            <div class="col-md-6">
                <h3>Feedback Form</h3>
                <form action="{{ route('counselor.giveFeedback') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="excuse_slip_id">Excuse Slip ID:</label>
                        <input type="text" name="excuse_slip_id" id="excuse_slip_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="feedback_remarks">Feedback Remarks:</label>
                        <textarea name="feedback_remarks" id="feedback_remarks" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="feedback_type">Feedback Type:</label>
                        <select name="feedback_type" id="feedback_type" class="form-control" required>
                            <option value="positive">Positive</option>
                            <option value="negative">Negative</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </form>
            </div>
        </div>
    </div>
@endsection