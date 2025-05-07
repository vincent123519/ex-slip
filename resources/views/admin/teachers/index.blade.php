@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Teachers</h1>
        <div class="filter-search-wrapper">
        <form method="GET" action="{{ route('admin.teachers.index') }}" class="d-flex justify-content-center mb-4">
    <input type="text" name="search" class="form-control w-50" placeholder="Search by name or username" value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary ms-2">Search</button>
</form>

    <div class="filters mb-4">
        <select id="schoolFilter" class="filter-dropdown">
            <option value="">Filter by School</option>
            @foreach($schools as $school)
                <option value="{{ $school->school_code }}">{{ $school->school_name }}</option>
            @endforeach
        </select>

        <select id="departmentFilter" class="filter-dropdown" disabled>
            <option value="">Filter by Department</option>
        </select>
    </div>
</div>

<table id="teachers" class="table">
    <thead>
        <tr>
            <th>ID | UserAccount</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Department</th>
            <th>School</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($teachers as $teacher)
            <tr>
                <td>{{ $teacher->user->username }}</td>
                <td>{{ $teacher->first_name }}</td>
                <td>{{ $teacher->last_name }}</td>
                <td>{{ $teacher->department->department_name }}</td>
                <td>{{ $teacher->department->school->school_name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $teachers->appends(request()->query())->links() }}
</div>
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

    #teachers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    #teachers td,
    #teachers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #teachers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #teachers tr:hover {
        background-color: #ddd;
    }

    #teachers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }

    <style>
    .filter-search-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 30px auto;
        max-width: 600px;
    }

    .search-container {
        width: 100%;
        margin-bottom: 20px;
    }

    #search-input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .filters {
        display: flex;
        gap: 15px;
        width: 100%;
    }

    .filter-dropdown {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        appearance: none;
        background: white;
        cursor: pointer;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .filter-dropdown:focus {
        border-color: #007BFF;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        outline: none;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const teachersTable = document.getElementById('teachers');
        const searchInput = document.getElementById('search-input');
        const teacherRows = document.querySelectorAll('#teachers tbody tr');

        function filterTeachers() {
            const searchQuery = searchInput.value.toLowerCase();

            teacherRows.forEach((row, index) => {
                const fullName = index === 1 || index === 2 ? `${row.children[1].textContent} ${row.children[2].textContent}` : row.children[1].textContent; // Combined Name column

                if (fullName.toLowerCase().includes(searchQuery)) {
                    row.style.display = ''; // Show matching row
                } else {
                    row.style.display = 'none'; // Hide non-matching row
                }
            });
        }

        searchInput.addEventListener('input', filterTeachers);
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const teachersTable = document.getElementById('teachers');
    const schoolFilter = document.getElementById('schoolFilter');
    const departmentFilter = document.getElementById('departmentFilter');

    // Update departments when school changes
    schoolFilter.addEventListener('change', function() {
        const schoolCode = this.value;
        departmentFilter.innerHTML = '<option value="">Filter by Department</option>';

        if (schoolCode && departmentsBySchool[schoolCode]) {
            departmentsBySchool[schoolCode].forEach(dept => {
                const option = document.createElement('option');
                option.value = dept.name;  // We'll match department by name for simplicity
                option.textContent = dept.name;
                departmentFilter.appendChild(option);
            });
            departmentFilter.disabled = false;
        } else {
            departmentFilter.disabled = true;
        }

        filterTable();  // Filter immediately
    });

    departmentFilter.addEventListener('change', filterTable);

    function filterTable() {
        const schoolText = schoolFilter.options[schoolFilter.selectedIndex]?.text.toLowerCase() || '';
        const departmentText = departmentFilter.value.toLowerCase();
        const rows = teachersTable.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const schoolCell = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
            const departmentCell = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            let showRow = true;

            if (schoolFilter.value && schoolCell !== schoolText) {
                showRow = false;
            }
            if (departmentFilter.value && departmentCell !== departmentText) {
                showRow = false;
            }

            row.style.display = showRow ? '' : 'none';
        });
    }
});
</script>

<script>
    const departmentsBySchool = @json(
        $schools->mapWithKeys(function($school) {
            return [$school->school_code => $school->departments->map(function($dept) {
                return ['id' => $dept->department_id, 'name' => $dept->department_name];
            })];
        })
    );
</script>

