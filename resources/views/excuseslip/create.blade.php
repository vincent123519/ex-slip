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
                <label for="course_ids">Course/Subject/s Absent:</label>
                <div class="dropdown">
                    <div class="dropdown-menu" aria-labelledby="courseDropdown">
                        @foreach($studyLoad as $study)
                            @php
                                $course = $study->courseOffering->course;
                            @endphp
                            @if($course)
                                <div class="form-check">
                                    <input type="checkbox" name="course_ids[]" id="course_{{ $course->id }}" value="{{ $course->id }}"
                                           @if(is_array(old('course_ids')) && in_array($course->id, old('course_ids'))) checked @endif>
                                    <label class="form-check-label" for="course_{{ $course->id }}">{{ $course->course_name }}</label>
                                </div>
                            @endif
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

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

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