@extends('components.admin')

@section('content')
    <div class="manage-student-container">
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
.manage-student-container {
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;
    font-family: 'Montserrat', sans-serif;
    border-collapse: collapse;
    background-color: rgba(255, 255, 255, 0.5);

}

.manage-student-container h1 {
    margin-top: 20px;
    text-align: left;

}

.manage-student-container label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.manage-student-container select {
    width: 100%;
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

.manage-student-container .btn-primary {
    background-color: darkgreen;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.manage-student-container .btn-primary:hover {
    background-color: teal;
}

.table-sm th{
    border: 1px solid #000;
}
.table-sm td {
    padding: 0.3rem;
    
}


</style>