@extends('components.admin')

@section('content')
    <div class="manage-users-container">
        <h1 class="text-center">All Students</h1>
        <div class="table-container">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Degree Yr level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->last_name }}, {{ $student->first_name }}</td>
                            <td>{{ $student->degree->degree_name }}-{{ $student->year_level }}</td>
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
    background-color: #f8f9fa;
    padding: 20px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    width: 60%;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    




}

.manage-users-container h1 {
    margin-top: 20px;
    text-align: left;

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
    background-color: darkgreen;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.manage-users-container .btn-primary:hover {
    background-color: teal;
}

.table-sm th,
.table-sm td {
    padding: 0.3rem;
}


</style>