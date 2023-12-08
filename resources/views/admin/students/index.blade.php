@extends('components.signlayout')

@section('content')
    <div class="manage-users-container">
        <h1 class="text-center">All Students</h1>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Degree ID</th>
                        <th>Year Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->degree_id }}</td>
                            <td>{{ $student->year_level }}</td>
                            <td>
                                <a href="{{ route('admin.studyload.create', ['studentId' => $student->id ?? 0]) }}" class="btn btn-primary">Add Studyload</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

        <style>.manage-users-container {
        /* background-color: rgb(243 254 240 / 98%); */
    /* // padding: 20px; */
        position: relative;
        border: 1px solid #ccc;
        border-radius: 10px;
        /* width: 80%; */
        margin: 20px auto;
    }</style>

@endsection