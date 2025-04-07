@extends('components.admin')

@section('content')
<div class="container">
    <h1>All Department Degrees</h1>

    <!-- Add Department Degree Button -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addDegreeModal">Add Department Degree</button>

    <!-- Degrees Table -->
    <table id="degree" class="table">
        <thead>
            <tr>
                <th>Degree ID</th>
                <th>Degree Code</th>
                <th>Degree Name</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departmentDegrees as $degree)
                <tr>
                    <td>D{{ $degree->degree_id }}</td>
                    <td>{{ $degreeLabels[$degree->degree_id] ?? 'N/A' }}</td>

                    <td>{{ $degree->degree_name }}</td>
                    <td>{{ $degree->department->department_name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Degree Modal -->
<div class="modal fade" id="addDegreeModal" tabindex="-1" aria-labelledby="addDegreeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.department_degrees.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addDegreeModalLabel">Add Department Degree</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="degree_name" class="form-label">Degree Name</label>
                    <input type="text" class="form-control" name="degree_name" id="degree_name" required>
                </div>
                <div class="mb-3">
                    <label for="department_id" class="form-label">Select Department</label>
                    <select name="department_id" id="department_id" class="form-control" required>
                        <option value="">-- Select Department --</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add Degree</button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    #degree {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    #degree td, #degree th {
        border: 1px solid #ddd;
        padding: 12px;
    }

    #degree tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #degree tr:hover {
        background-color: #ddd;
    }

    #degree th {
        background-color: #04AA6D;
        color: white;
    }
</style>
