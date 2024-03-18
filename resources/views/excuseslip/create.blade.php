
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
                <label for="name" id="student_name">Name: {{ Auth::user()->last_name }}, {{ Auth::user()->first_name }}</label>
            </div>

            <!-- <div class="form-group">
                <label for="name" id="student_id">Student ID:</label>
                <ul class="list-unstyled">
                    <li>{{ Auth::user()->student->student_id }}</li>
                </ul>
            </div> -->

            <div class="form-group">
            <label for="degree">Degree: </label>
            @if($degree)
                <input type="text" class="form-control" id="degree" name="degree" value="{{$yearLevel}} - {{ $degree->degree_name }}" readonly>
                <input type="hidden" name="degree_id" value="{{ $degree->degree_id }}">
            @else
                <input type="text" class="form-control" id="degree" name="degree" value="No Degree found" readonly>
                <input type="hidden" name="degree_id" value="">
            @endif
        </div>






        <form action="{{ route('excuse_slips.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group" style="display: none;">
            <label for="student_id">Student ID:</label>
            <input type="text" name="student_id" id="student_id" class="form-control" value="{{ Auth::user()->student->student_id }}" required readonly>
        </div>

        <div class="form-group">
        <label for="dean">Dean:</label>
        @if($dean)
            <input type="text" class="form-control" id="dean" name="dean" value="{{ $dean->first_name }} {{ $dean->last_name }}" readonly>
            <input type="hidden" name="dean_id" value="{{ $dean->dean_id }}">
        @else
            <input type="text" class="form-control" id="dean" name="dean" value="No Dean found" readonly>
            <input type="hidden" name="dean_id" value="">
        @endif
    </div>


        
    <div class="form-group">
        <label for="counselor">Counselor:</label>
        @if($counselor)
            <input type="text" class="form-control" id="counselor" name="counselor" value="{{ $counselor->first_name }} {{ $counselor->last_name }}" readonly>
            <input type="hidden" name="counselor_id" value="{{ $counselor->counselor_id }}">
        @else
            <input type="text" class="form-control" id="counselor" name="counselor" value="No Counselor found" readonly>
            <input type="hidden" name="counselor_id" value="">
        @endif
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
                <label for="course_code">Course/Subject/s Absent:</label>
                <div class="dropdown">
                    <div class="dropdown-menu" aria-labelledby="courseDropdown">
                        @foreach($coursesData as $course)
                            <div class="form-check">
                                <input type="checkbox" name="course_code" id="course_code" value="{{ $course->course_code }}"
                                    @if(is_array(old('course_codes')) && in_array($course->course_code, old('course_codes'))) checked @endif>
                                <label class="form-check-label" for="course_{{ $course->course_code }}">{{ $course->course_name }}</label> 
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-group">
        <label for="supporting_document">Supporting Document</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="supporting_document" name="supporting_document" accept=".pdf" required>
            <label class="custom-file-label" for="supporting_document"></label>
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
        font-family: 'Montserrat', sans-serif;

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
    
    .form-check {
        display: inline-block;
        margin-right: 10px; /* Adjust the margin as needed */
    }

  .navmenu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            
        }
        
        .navmenu li {
            display: inline-block;
            padding: 2px;
            border-bottom: 1px solid rgba(13,62,32,0.98);
            border-top: none;
            width: 250px;
        }
        
        .navmenu li span {
            padding: 10px;
            cursor: pointer;
        }
        
        .navmenu .dropdown {
            display: none;
            position: absolute;
            background-color: #fec039;
            width: 250px;
            box-shadow: 2px 8px 16px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(13,62,32,0.98);
            font-family: 'Montserrat', sans-serif;            
        }
        
        .navmenu .dropdown li {
            display: block;
        }
        
        .dropdown-li:focus .dropdown {
            display: block;
        }
        
        .dropdown-li {
            position: relative;
            
        }
    
        #schoolYearButton {
            cursor: pointer;
            color: rgba(13, 62, 32, 0.98);
    
        }
    
        /* .dropdown {
            display: none;
            position: absolute;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
            list-style-type: none;
            padding: 0;
            margin: 0;
        } */
    
        .dropdown li {
            display: block;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: rgba(13, 62, 32, 0.98);
            
    
        }
    
        .dropdown li:last-child {
            border-bottom: none;
        }
    
        .dropdown a {
            text-decoration: none;
            display: block;
        }
    
        .dropdown a:hover {
            background-color: #f5f5f5; /* Hover background color for options */
        }
    
</style>