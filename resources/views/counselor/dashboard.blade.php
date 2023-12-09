@extends('components.counselor')
@section('content')
    <div class="counselor-details-container">
        <h1>Absence Request</h1>
        <a href="" class="create-slip-button"> Number of Excuse slip</a>
        <h2>Excuse Slips</h2>
            @if($excuseSlips->count() > 0)
                @foreach($excuseSlips as $excuseSlip)
                    <div class="excuse-slip">
                        <p><strong>Duration:</strong> {{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</p>
                        <p><strong>Status:</strong> {{ $excuseSlip->status->name }}</p>
                        <p><strong>Counselor's Feedback:</strong> {{ $excuseSlip->counselor_feedback }}</p>
                        <p><strong>Dean's Feedback:</strong> {{ $excuseSlip->dean_feedback }}</p>
                        <p><strong>Teacher's Feedback:</strong> {{ $excuseSlip->teacher_feedback }}</p>
                        <!-- Add other information as needed -->
                    </div>
                @endforeach
            @else
                <p>No excuse slips found.</p>
            @endif

        </div>
    </div>
        @endsection

<style>
    .counselor-details-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 5px;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
