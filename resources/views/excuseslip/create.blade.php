<!DOCTYPE html>

@extends('components.stud')

@section('content')
    
    <div class="manage-slip-container">
        <h2 class="excuse-slip-header">Excuse Slip</h2>

        <!-- Display errors if there are any -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <!-- <div class="form-group">
            <input type="hidden" name="course_id" id="course_id" value="">
            </div> -->
            <div class="form-group">
                <label for="name" id="student_name">Name: {{ Auth::user()->name }}</label>
            </div>

            <!-- <div class="form-group">
                <label for="name" id="student_id">Student ID:</label>
                <ul class="list-unstyled">
                    <li>{{ Auth::user()->student->student_id }}</li>
                </ul>
            </div> -->


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

        <form action="{{ route('excuse_slips.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="form-control" value="{{ Auth::user()->student->student_id }}" required>
            </div>

            <div class="form-group">
                <label for="teacher_id">Teacher:</label>
                <select name="teacher_id" id="teacher_id" class="form-control" required>
                    @foreach($teacherData as $teacher)
                        <option value="{{ $teacher->teacher_id }}">{{ $teacher->name }}</option>
                    @endforeach 
                </select>
            </div>

            <div class="form-group">
                <label for="dean_id">Dean:</label>
                <select name="dean_id" id="dean_id" class="form-control" required>
                    @foreach($deanData as $dean)
                        <option value="{{ $dean->dean_id }}">{{ $dean->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="counselor_id">Counselor:</label>
                <select name="counselor_id" id="counselor_id" class="form-control" required>
                    @foreach($counselorData as $counselor)
                        <option value="{{ $counselor->counselor_id }}">{{ $counselor->first_name  }} {{ $counselor->last_name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="course_code">Course/Subject/s Absent:</label>
                <div class="dropdown">
                    <div class="dropdown-menu" aria-labelledby="courseDropdown">
                        @foreach($coursesData as $course)
                            <div class="form-check">
                                <input type="checkbox" name="course_code" id="course_code" value="{{ $course->course_code }}"
                                    @if(is_array(old('course_codes')) && in_array($course->course_code, old('course_codes'))) checked @endif>
                                <label class="form-check-label" for="course_{{ $course->course_code }}">{{ $course->course_code }}</label> 
                            </div>
                        @endforeach
                    </div>
                </div>
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

            <!-- <div class="form-group">
                <label for="end_date">Status:</label>
                <input type="text" name="status_id" id="status_id" class="form-control" value="{{ old('status_id') }}" required readonly>
            </div> -->
            <div class="button color">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#course_id').change(function () {
                var selectedCourseId = $(this).val();

                // Fetch the course_name based on the selected course_id (you may use an AJAX request).
                // For simplicity, let's assume you have a function named fetchCourseNameById.

                // Fetch the course_name using an imaginary fetchCourseNameById function
                var courseName = fetchCourseNameById(selectedCourseId);

                // Update the displayed course_name in the form
                $('#course_absent').val(courseName);
            });


            // Function to fetch course_name by course_id (replace it with your actual implementation)
            function fetchCourseNameById(courseId) {
                // You may use an AJAX request here to fetch the course_name from the server.
                // For simplicity, return a static value here.
                return "Course Name"; // Replace this with your actual implementation
            }
        });
    </script>
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

    label {
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-check-input {
        margin-top: 3px;
    }

    button {
        background-color: darkgreen;
        color: #fff;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    
</style>