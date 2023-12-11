@extends('components.excuseslipstud')

@section('content')
    <div class="manage-slip-container">
        <h2 class="excuse-slip-header">Excuse Slip</h2>
        <form action="{{ route('excuse_slips.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name:</label>
                <ul class="list-unstyled">
                    <li><strong>{{ Auth::user()->name }}</strong></li>
                </ul>
            </div>
            <input type="hidden" name="student_id" value="{{ $studentId }}">
            <input type="hidden" name="counselor_id" value="{{ $counselorId }}">
            <input type="hidden" name="dean_id" value="{{ $deanId }}">


            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <ul class="list-unstyled">
                    <li>{{ Auth::user()->student->student_id }}</li>
                </ul>
            </div>

            <div class="form-group">
                <label for="degree_id">Degree Program:</label>
                <select name="degree_id" id="degree_id" class="form-control" required disabled>
                    @foreach($degrees as $degree)
                        <option value="{{ $degree->id }}" @if(optional($excuseSlip)->degree_id == $degree->id) selected @endif>
                            {{ $degree->degree_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="year_level">Year Level:</label>
                <input type="text" name="year_level" id="year_level" class="form-control" value="{{ old('year_level', $yearLevel) }}" required readonly>
            </div>

            <div class="form-group">
                <label for="offer_code">Course/Subject/s Absent:</label>
                <div class="dropdown">
                    <div class="dropdown-menu" aria-labelledby="courseDropdown">
                    @foreach ($studyLoad as $load)
                    <div>
                        
                        <input type="checkbox" id="offer_code-{{ $load->id }}" name="offer_code[]" value="{{ $load->id }}">
                        <label for="offer_code-{{ $load->id }}">Course Code: {{ $load->courseOffering->course_code }}</label>
                        <label>Offer Code: {{ $load->courseOffering->offer_code }}</label>
                        <label>Offer Code: {{ $load->courseOffering->Course->course_name }}</label>
                        
                    </div>
                @endforeach
                    </div>
                </div>
</div>  
            <div class="form-group">
                <label for="counselor_id">Counselor:</label>
                <input type="text" name="counselor_id" id="counselor_id" class="form-control" required readonly value="{{ $counselor->name }}">
            </div>

            <div class="form-group">
                <label for="dean_id">Dean:</label>
                <input type="text" name="dean_id" id="dean_id" class="form-control" required readonly value="{{ $dean->name }}">
            </div>

            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea name="reason" id="reason" class="form-control" rows="4" required>{{ old('reason') }}</textarea>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection



<style>
    .manage-slip-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .text-center {
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }
    </style>