
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/apps.css'])
    @yield('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
</head>
@extends('components.excuse')

@section('content')

    <div class="manage-slip-container">
    <div class="logoss"></div>
    <h3 class="excuse-slip-header">Excuse Slip</h3>        <!-- Display errors if there are any -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="formContainer">
                <!-- <div class="form-group">
                <input type="hidden" name="course_id" id="course_id" value="">
                </div> -->
                <div class="form-group">
                    <label for="name" id="student_name">Name:</label>
                    <input type="text" class="form-control" for="name" id="student_name" value="{{ Auth::user()->last_name }}, {{ Auth::user()->first_name }}" readonly >
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
            </div>






            <form action="{{ route('excuse_slips.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
           

            <div class="form-group" style="display: none;">
                <label for="student_id">Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="form-control" value="{{ Auth::user()->student->student_id }}" required readonly>
            </div>

            <div class="formContainer">
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
            </div>

            <div class="form-group">
                <label for="offer_codes">Select Courses:</label>
                <div class="form-group-course">

                    <ul>
                        @foreach($selectedCourseOfferings as $courseOffering)
                            <li>
                                <input type="checkbox" name="offer_codes[]" id="offer_code_{{ $courseOffering['offer_code'] }}" value="{{ $courseOffering['offer_code'] }}" data-teacher-id="{{ $courseOffering['teacher_id'] }}">
                                <label for="offer_code_{{ $courseOffering['offer_code'] }}">
                                    {{ $courseOffering['course_name'] }} - {{ $courseOffering['teacher_name'] }} (ID: {{ $courseOffering['teacher_id'] }})
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="form-group-files">
    <label for="supporting_documents">Supporting Document/s: </label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="supporting_documents" name="supporting_documents[]" accept=".pdf" multiple required>
        <label class="custom-file-label" for="supporting_documents">Choose file(s)</label>
    </div>
</div>



            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea name="reason" id="reason" class="form-control" rows="4" required>{{ old('reason') }}</textarea>
            </div>

            <div class="formContainer">
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                </div>

                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                </div>
            </div>

            <!-- <div class="form-group">
                <label for="end_date">Status:</label>
                <input type="text" name="status_id" id="status_id" class="form-control" value="{{ old('status_id') }}" required readonly>
            </div> -->
            <div class="button color">
                <button type="submit" class="btn btn-primary">Submit</button>
        </form>
            </div>
    <!-- <div class="nav-right">
        <form action="{{ route('student.dashboard') }}" method="get" style="display: inline;">
            @csrf
            <button type="submit" class="home-btn">
           <div class="home-icon"><i style="
                color: beige;
                font-weight: bold;
            "> </i></div>
            </button>
        </form> -->
@endsection



<style>

.home-icon {
            width: 26px;
            height: 30px;
            background: url("..s/scss/image/home.png") center/cover;
            border-radius: 50%;
            margin-right: 10px;
        }

        .home-btn {
            background: #fff;
            color: rgba(13, 62, 32, 0.98);
            display: block;
            margin: -36px 451px;
            font-size: 18px;
            width: 39px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            border-radius: 50%;
            transition: 0.3s;
        }
</style>

<script>
    // Get the select element teacher id    
    const selectElement = document.getElementById('offer_code_select');

    selectElement.addEventListener('change', function(event) {
        const selectedOption = event.target.options[event.target.selectedIndex];
        const teacherId = selectedOption.getAttribute('data-teacher-id');
        document.getElementById('teacher_id').value = teacherId;
    });
    document.getElementById('add_supporting_document').addEventListener('click', function() {
        var container = document.getElementById('supporting_documents_container');
        var fileInput = document.createElement('div');
        fileInput.classList.add('form-group');
        fileInput.innerHTML = `
            <label for="supporting_document">Supporting Document: </label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="supporting_documents[]" accept=".pdf" required>
                <label class="custom-file-label">Choose file</label>
            </div>`;
        container.appendChild(fileInput);
    });
    document.querySelector('form').addEventListener('submit', function(event) {
            var confirmation = confirm("Are you sure you want to submit the form?");
            if (!confirmation) {
                event.preventDefault();
            }
        });
</script>

<style>
  
</style>