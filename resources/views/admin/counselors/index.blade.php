@extends('components.admin')

@section('content')
    <div class="container">
        <h1>Counselors</h1>
        <table id="counselor" class="table">
            <thead>
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
    #counselor {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 90%;
        margin: 30px auto;
    }

    #counselor td, #counselor th {
        border: 1px solid #ddd;
        padding: 10px;
    }

    #counselor tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #counselor tr:hover {
        background-color: #eee;
    }

    #counselor th {
        background-color: #04AA6D;
        color: white;
        text-align: left;
        padding: 12px;
    }

    .btn {
        margin: 0 5px;
    }

    .pagination-wrapper {
        width: 90%;
        margin: 20px auto;
        text-align: center;
    }

    .pagination {
        justify-content: center;
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
        color: #04AA6D;
        padding: 8px 12px;
        text-decoration: none;
        border: 1px solid #ddd;
    }

    .page-link:hover {
        background-color: #f2f2f2;
    }
</style>
