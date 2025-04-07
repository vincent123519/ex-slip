@extends('components.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card-manage">
                <div class="card-header"></div>
                <div class="card-course">
                    <h2 class="table-heading">List of Course Offerings</h2>
                    <table class="course-offerings-table">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Offer Code</th>
                                <th>Teacher name - ID</th>
                                <th>Department</th>
                                <th>School</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allCourseOfferings as $courseOffering)
                            <tr>
                                <td>{{ $courseOffering->course->course_code }}</td>
                                <td>{{ $courseOffering->course->course_name }}</td>
                                <td>{{ $courseOffering->offer_code }}</td>
                                <td>{{ $courseOffering->teacher->first_name}} {{ $courseOffering->teacher->last_name}}  {{ $courseOffering->teacher->user->username}}</td>
                                <td>{{ $courseOffering->course->department->department_name}}</td>
                                <td>{{ $courseOffering->course->department->school->school_name }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8 offset-md-2">
            <div class="card-manage">
                <div class="card-header"></div>
                <div class="card-offerings">
                    <h2 class="table-heading">List of Courses</h2>
                    <table class="courses-table">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allCourses as $course)
                            <tr>
                                <td>{{ $course->course_code }}</td>
                                <td>{{ $course->course_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>h4 {
    display: block;
    font-size: 1.00em;
    font-weight: bold;
    margin-block: 1.33em;
    text-align: center; 
}

.card-manage {
    position: relative;
    border: 10px solid #55825f;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;
    font-family: 'Montserrat', sans-serif;
}

.course-offerings-table,
.courses-table {
    font-family: 'Montserrat', sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.course-offerings-table th,
.courses-table th,
.course-offerings-table td,
.courses-table td {
    border: 1px solid #ddd;
    padding: 8px;
}

.course-offerings-table tr:nth-child(even),
.courses-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.course-offerings-table tr:hover,
.courses-table tr:hover {
    background-color: #ddd;
}

.course-offerings-table th,
.courses-table th,
.course-offerings-table td,
.courses-table td {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
}

.course-offerings-table th,
.courses-table th {
    background-color: #04AA6D;
    color: white;
}



</style>