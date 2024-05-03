
@extends('components.stud')

@section('content')

    
    <div class="manage-slip-container">
    <div class="logoss"></div>
    <h2 class="excuse-slip-header" style="margin-left: 473px;margin-top: 79px;">Excuse Slip</h2>        <!-- Display errors if there are any -->
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



    <div class="form-group-course">
    <label for="offer_codes">Select Courses:</label>
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



<style>
    body{
    margin: 0;
    overflow-x: hidden;
}
.logoss {
    background-image: url(http://[::1]:4000/resources/scss/image/ExcUseSlip.png);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    margin-top: -6px;
    margin-left: 470px;
    position: absolute;
    height: 50px;
    width: 102px;
    z-index: 1;
    padding: 21px 22px;
}
.manage-slip-container {
    background-color: #f8f9fa;
    padding: 20px;
    border: 7px solid yellow;
    border-radius: 0px;
    width: 60%;
    padding: 5px -2px;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Montserrat', sans-serif;
    border-style: inset;
}
.logout-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            margin-left: 451px;
            margin-top: -9px;
        }
        .circle-icon {
            width: 35px;
            height: 34px;
            background: url('../scss/image/logout.png') center/cover; /* Set your image path */
            border-radius: 50%;
            margin-right: 10px; /* Adjust margin as needed */
        }
        .home-icon {
            width: 26px;
            height: 30px;
            background: url("http://[::1]:4000/resources/scss/image/home.png") center/cover;
            border-radius: 50%;
            margin-right: 10px;
        }

        .home-btn {
            background: #fff;
            color: rgba(13, 62, 32, 0.98);
            display: block;
            margin: -36px 406px;
            font-size: 18px;
            width: 41px;
            height: 37px;
            line-height: 35px;
            text-align: center;
            border-radius: 50%;
            transition: 0.3s;
        }
    .text-center {
        text-align: center;
    }

    .form-group {
    margin-bottom: 20px;
    width: 100%;
    padding: 10px;
    border-bottom: 1px solid #ced4da;
    box-sizing: border-box;
}

    label {
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
    width: 100%;
    padding: 10px;
    border-radius: 0px;
    background-color: #f8f9fa;
    border: 0;
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

<script>
    // Get the select element
    const selectElement = document.getElementById('offer_code_select');

    // Add event listener to handle change event
    selectElement.addEventListener('change', function(event) {
        // Get the selected option
        const selectedOption = event.target.options[event.target.selectedIndex];

        // Get the teacher ID from the data attribute
        const teacherId = selectedOption.getAttribute('data-teacher-id');

        // Update the value of the hidden input field
        document.getElementById('teacher_id').value = teacherId;
    });
</script>

<style>
    .form-group-course ul {
        list-style: none;
        padding: 0;
    }

    .form-group-course li {
        margin-bottom: 10px;
    }

    .form-group-course input[type="checkbox"] {
        display: none;
    }

    .form-group-course li {
        display: block;
        position: relative;
        padding-left: 30px; /* Adjust this value to change the spacing between the checkbox and label */
        cursor: pointer;
        font-family: Arial, sans-serif; /* Adjust font family as needed */
        font-size: 16px; /* Adjust font size as needed */
    }

    /* Style the custom checkbox */


    /* Style the custom checkbox when checked */
    .form-group-course input[type="checkbox"]:checked + label:before {
        background-color: #007bff; /* Change this to the desired color when the checkbox is checked */
    }

    /* Style the custom checkmark */
    .form-group-course label:after {
        content: "";
        position: absolute;
        left: 7px; /* Adjust this value to position the checkmark */
        top: 5px; /* Adjust this value to position the checkmark */
        width: 6px;
        height: 12px;
        border: solid #fff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        display: none;
    }

    /* Show the custom checkmark when the checkbox is checked */
    .form-group-course input[type="checkbox"]:checked + label:after {
        display: block;
    }
</style>