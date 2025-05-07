@extends('components.admin')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Counselors List</h2>
        <table id="counselor" class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID | UserAccount</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Department</th>
                    <th>School</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($counselors as $counselor)
                    <tr>
                        <td>{{ $counselor->user->username }}</td>
                        <td>{{ $counselor->first_name }}</td>
                        <td>{{ $counselor->last_name }}</td>
                        <td>{{ $counselor->department->department_name }}</td>
                        <td>{{ $counselor->department->school->school_name }}</td>
                        <td>
                            <a href="{{ route('admin.counselor.edit', $counselor->counselor_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Section -->
        <div class="pagination-wrapper">
            <ul class="pagination">
                @if ($counselors->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $counselors->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif

                @for ($i = 1; $i <= $counselors->lastPage(); $i++)
                    <li class="page-item {{ $i == $counselors->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $counselors->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($counselors->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $counselors->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endsection

<style>
    /* Center the table and provide spacing */
    .container {
        max-width: 90%;
        margin: 0 auto;
    }

    /* Table styling */
    #counselor {
        width: 100%;
        margin-bottom: 30px;
        border-collapse: collapse;
    }

    /* Table header styling */
    #counselor th {
        background-color: #04AA6D;
        color: white;
        padding: 12px;
        text-align: left;
    }

    /* Table rows styling */
    #counselor td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    /* Hover effect on rows */
    #counselor tr:hover {
        background-color: #f1f1f1;
    }

    /* Alternate row colors */
    #counselor tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Style for Edit button */
    .btn {
        padding: 8px 16px;
        background-color: #ff9800;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #e68900;
    }

    /* Pagination styling */
    .pagination-wrapper {
        text-align: center;
        margin-top: 20px;
    }

    .pagination {
        display: inline-flex;
        list-style: none;
        padding-left: 0;
        margin-top: 20px;
    }

    .page-item {
        margin: 0 5px;
    }

    .page-item.active .page-link {
        background-color: #04AA6D;
        border-color: #04AA6D;
    }

    .page-link {
        padding: 8px 12px;
        color: #04AA6D;
        text-decoration: none;
        border: 1px solid #ddd;
    }

    .page-link:hover {
        background-color: #f2f2f2;
    }
</style>
