@extends('components.signlayout')

@section('content')

<div class="manage-users-container">
    <h1>Add Studyload</h1>
    <form method="POST" action="{{ route('admin.studyload.store') }}">
        @csrf
        <input type="hidden" name="student_id" value="{{ $studentId }}">
        <div class="form-group">
            <label for="semester_id">Semester:</label>
            <select name="semester_id" id="semester_id" class="form-control" required>
                <option value="">Select a semester</option>
                @foreach($semesters as $semester)
                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="course_code">Course Code:</label>
            <select name="course_code" id="course_code" class="form-control" required>
                <option value="">Select a course code</option>
                @foreach($courseCodes as $courseCode)
                    <option value="{{ $courseCode->course_code }}">{{ $courseCode->course_code }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="offer_code">Offer Code:</label>
            <select name="offer_code" id="offer_code" class="form-control" required>
                <option value="">Select an offer code</option>
                @foreach($offerCodes as $offerCode)
                    <option value="{{ $offerCode->offer_code }}">{{ $offerCode->offer_code }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Studyload</button>
    </form>
</div>

@endsection

@section('styles')
<style>
.manage-users-container {
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin: 20px auto;
}

.manage-users-container h1 {
    text-align: center;
    margin-top: 20px;
}

.manage-users-container form {
    padding: 20px;
}

.manage-users-container .form-group {
    margin-bottom: 20px;
}

.manage-users-container label {
    display: block;
    font-weight: bold;
}

.manage-users-container select {
    width: 100%;
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.manage-users-container button[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.manage-users-container button[type="submit"]:hover {
    background-color: #0056b3;
}
</style>
@endsection