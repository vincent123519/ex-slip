@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Departments</h1>

        <!-- Add Department Button -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">Add Department</button>

        <!-- Search Form -->
        <div class="input-group mb-3" style="max-width: 500px; margin: 20px auto;">
            <input 
                type="text" 
                class="form-control" 
                id="searchInput" 
                placeholder="Search by Department or School Name"
            >
        </div>

        <!-- Departments Table -->
        <table id="department" class="table">
            <thead>
                <tr>
                    <th>Department ID</th>
                    <th>Department Name</th>
                    <th>School</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td>D{{ $department->department_id }}</td>
                        <td class="department-name">{{ $department->department_name }}</td>
                        <td class="school-name">{{ $department->school->school_name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Department Modal -->
 <!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.departments.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" name="department_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="school_code" class="form-label">School</label>
                        <select class="form-control" name="school_code" required>
                            <option value="">Select School</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->school_code }}">{{ $school->school_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Department</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('searchInput').addEventListener('input', function() {
            var searchValue = this.value.toLowerCase();
            var rows = document.querySelectorAll('#department tbody tr');

            rows.forEach(function(row) {
                var departmentName = row.querySelector('.department-name');
                var schoolName = row.querySelector('.school-name');

                if (departmentName && schoolName) {
                    var departmentText = departmentName.textContent.toLowerCase();
                    var schoolText = schoolName.textContent.toLowerCase();

                    row.style.display = (departmentText.includes(searchValue) || schoolText.includes(searchValue)) ? '' : 'none';
                }
            });
        });
    });
</script>
@endsection

<style>
    #department {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 60%;
        margin-left: auto;
        margin-right: auto;
    }

    #department td, #department th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #department tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #department tr:hover {
        background-color: #ddd;
    }

    #department th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }

    .input-group {
        max-width: 500px;
        margin-bottom: 26px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
