@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Students</h1>
        <table id="students" class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Degree Year Level</th>
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
                            <!-- <a href="{{ route('admin.studyload.create', ['studentId' => $student->student_id]) }}" class="btn btn-primary btn-sm">Add Study Load</a> -->
                            <a href="{{ route('admin.students.edit', ['id' => $student->student_id]) }}" class="btn btn-secondary btn-sm">Edit Student</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style>
    .container {
        position: relative;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 80%;
        margin: 20px auto;
        margin-right: 30px;
        font-family: Arial, Helvetica, sans-serif;
        background-color: rgba(255, 255, 255, 0.5);
    }

    .container h1 {
        margin-top: 20px;
        text-align: center;
    }

    #students {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    #students td,
    #students th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #students tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #students tr:hover {
        background-color: #ddd;
    }

    #students th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .btn-primary {
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
    }

    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
        color: #fff;
        background-color: #286090;
        border-color: #204d74;
    }

    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover,
    .btn-secondary:focus,
    .btn-secondary:active {
        color: #fff;
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
    }
</style>