@extends('components.admin')

@section('content')
<div class="container1">
    <div class="row">
        <!-- Course Offerings -->
        <div class="col-md-8 offset-md-2">
            <div class="card-manage">
                <div class="card-header">
                    <h2 class="table-heading">Search Course Offerings</h2>
                </div>
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('admin.course_offerings_and_courses') }}" class="mb-3 d-flex">
                        <input type="text" name="offering_search" class="form-control mr-2" placeholder="Search by course code, offer code.." value="{{ request('offering_search') }}">
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                    <table class="course-offerings-table">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Offer Code</th>
                                <th>Teacher Name - ID</th>
                                <th>Department</th>
                                <th>School</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allCourseOfferings as $courseOffering)
                                <tr>
                                    <td>{{ $courseOffering->course->course_code }}</td>
                                    <td>{{ $courseOffering->course->course_name }}</td>
                                    <td>{{ $courseOffering->offer_code }}</td>
                                    <td>{{ $courseOffering->teacher->first_name }} {{ $courseOffering->teacher->last_name }} - {{ $courseOffering->teacher->user->username }}</td>
                                    <td>{{ $courseOffering->course->department->department_name }}</td>
                                    <td>{{ $courseOffering->course->department->school->school_name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No course offerings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $allCourseOfferings->appends(['offering_search' => request('offering_search')])->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Courses -->
        <div class="col-md-8 offset-md-2">
            <div class="card-manage">
                <div class="card-header">
                    <h2 class="table-heading">Search Courses</h2>
                </div>
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('admin.course_offerings_and_courses') }}" class="mb-3 d-flex">
                        <input type="text" name="course_search" class="form-control mr-2" placeholder="Search by course code or name..." value="{{ request('course_search') }}">
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                    <table class="courses-table">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allCourses as $course)
                                <tr>
                                    <td>{{ $course->course_code }}</td>
                                    <td>{{ $course->course_name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No courses found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $allCourses->appends(['course_search' => request('course_search')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.container1 {
    max-width: 100%;
    padding: 20px;
}

.card-manage {
    border: 8px solid #55825f;
    margin: 20px auto;
    width: 90%;
    font-family: 'Montserrat', sans-serif;
    border-radius: 10px;
    background-color: #f9f9f9;
}

.table-heading {
    font-size: 1.5rem;
    font-weight: 600;
    padding: 10px 0;
    text-align: center;
    background-color: #04AA6D;
    color: white;
    border-radius: 10px 10px 0 0;
}

.course-offerings-table,
.courses-table {
    width: 100%;
    border-collapse: collapse;
}

.course-offerings-table th,
.course-offerings-table td,
.courses-table th,
.courses-table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.course-offerings-table tr:nth-child(even),
.courses-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.course-offerings-table tr:hover,
.courses-table tr:hover {
    background-color: #e0f7e9;
}

.course-offerings-table th,
.courses-table th {
    background-color: #04AA6D;
    color: white;
}

.btn-success {
    background-color: #04AA6D;
    border: none;
    padding: 8px 16px;
}

.btn-success:hover {
    background-color: #038a5d;
}
</style>
