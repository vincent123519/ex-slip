@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Schools</h1>

        <!-- Add School Button -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSchoolModal">Add School</button>

        <table id="school" class="table">
            <thead>
                <tr>
                    <th>School Code</th>
                    <th>School Name</th>
                    <th>Dean</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schools as $school)
                    <tr>
                        <td>{{ $school->school_code }}</td>
                        <td>{{ $school->school_name }}</td>
                        <td>
                            @if($school->dean)
                                {{ $school->dean->first_name }} {{ $school->dean->last_name }}
                            @else
                                Not Assigned
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add School Modal -->
    <div class="modal fade" id="addSchoolModal" tabindex="-1" aria-labelledby="addSchoolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSchoolModalLabel">Add School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.schools.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="school_code" class="form-label">School Code</label>
                            <input type="number" class="form-control" id="school_code" name="school_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="school_name" class="form-label">School Name</label>
                            <input type="text" class="form-control" id="school_name" name="school_name" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    #school {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 50%;
        margin-left: auto;
        margin-right: auto;
    }

    #school td, #school th {
        border: 1px solid #ddd;
        padding: 22px;
        text-align: left;
    }

    #school tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #school tr:hover {
        background-color: #ddd;
    }

    #school th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #04AA6D;
        color: white;
    }

    .btn {
        margin: 0 5px;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: white;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }
</style>
