@extends('components.signlayout')

@section('content')
    <div class="manage-users-container">
        <h1 class="text-center">All Students</h1>
        <div class="table-container">
            <table class="table table-sm">
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
                                <a href="{{ route('admin.studyload.create', ['studentId' => $student->student_id]) }}" class="btn btn-primary btn-sm">Add Studyload</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<style>
.manage-users-container {
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin: 20px auto;
    width: 80%;
    padding: 20px;
}

.manage-users-container h1 {
    text-align: center;
    margin-top: 20px;
}

.manage-users-container label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.manage-users-container select {
    width: 100%;
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

.manage-users-container .btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.manage-users-container .btn-primary:hover {
    background-color: #0056b3;
}

.table-sm th,
.table-sm td {
    padding: 0.3rem;
}
</style>