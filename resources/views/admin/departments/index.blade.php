@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Departments</h1>

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
@endsection

@section('scripts')
<script>
    // Ensure the script runs after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Add the input event listener for real-time search
        document.getElementById('searchInput').addEventListener('input', function() {
            var searchValue = this.value.toLowerCase(); // Get the search value and convert it to lowercase
            var rows = document.querySelectorAll('#department tbody tr'); // Get all rows in the table body

            rows.forEach(function(row) {
                var departmentName = row.querySelector('.department-name'); // Get the department name cell
                var schoolName = row.querySelector('.school-name'); // Get the school name cell

                if (departmentName && schoolName) {
                    var departmentText = departmentName.textContent.toLowerCase(); // Get the text of the department name
                    var schoolText = schoolName.textContent.toLowerCase(); // Get the text of the school name
                    
                    // Check if either department name or school name contains the search term
                    if (departmentText.includes(searchValue) || schoolText.includes(searchValue)) {
                        row.style.display = ''; // Show the row if it matches the search
                    } else {
                        row.style.display = 'none'; // Hide the row if it doesn't match
                    }
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
        width: 60%; /* Adjusted width to make sure the table does not overlap */
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
        margin-right: 1030px;

            }
</style>
