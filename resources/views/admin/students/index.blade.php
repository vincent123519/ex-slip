@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Students</h1>
        <div class="filter-search-wrapper">
        <form method="GET" action="{{ route('admin.students.index') }}" class="d-flex justify-content-center mb-4">
    <input type="text" name="search" class="form-control w-50" placeholder="Search by name..." value="{{ request('search') }}">
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

        <table id="students" class="table">
            <thead>
                <tr>
                    <th>Student ID | UserAccount</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Degree Year Level</th>
                    <th>Department</th>
                    <th>School</th>

                    
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td> {{$student->user->username}} </td>
                        <td>{{ $student->first_name }}</td>
                        <td>{{ $student->last_name }}</td>
                        <td>{{ $student->degree->degree_name }}-{{ $student->year_level }}</td>
                        <td>{{ $student->degree->department->department_name}}</td>
                        <td>{{ $student->degree->department->school->school_name}}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $students->links() }}

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
  const studentsTable = document.getElementById('students');
  const searchInput = document.getElementById('search-input');

  searchInput.addEventListener('input', function() {
    const searchQuery = searchInput.value.toLowerCase();
    const rows = studentsTable.querySelectorAll('tbody tr');

    rows.forEach(row => {
      const rowText = row.textContent.toLowerCase();
      if (rowText.includes(searchQuery)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentsTable = document.getElementById('students');
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
        const rows = studentsTable.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const schoolCell = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
            const departmentCell = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
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
