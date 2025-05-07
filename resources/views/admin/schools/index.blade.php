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

                        @php
                            $lastSchool = \App\Models\School::orderBy('school_code', 'desc')->first();
                            $nextSchoolCode = $lastSchool ? $lastSchool->school_code + 1 : 1001;
                        @endphp

                        <div class="mb-3">
                            <label for="school_code_preview" class="form-label">Next School Code (Auto-generated)</label>
                            <input type="text" class="form-control" id="school_code_preview" value="{{ $nextSchoolCode }}" disabled>
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
        width: 60%;
        margin: 30px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #school td, #school th {
        border: 1px solid #ddd;
        padding: 16px;
        text-align: left;
    }

    #school tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #school tr:hover {
        background-color: #e6f7ff;
    }

    #school th {
        background-color: #04AA6D;
        color: white;
        font-size: 16px;
        text-align: center;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #04AA6D;
    }

    .btn-success {
        display: block;
        margin: 0 auto 20px auto;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background-color: #04AA6D;
        color: white;
    }

    .modal-title {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #04AA6D;
        border-color: #04AA6D;
    }

    .btn-primary:hover {
        background-color: #038d5a;
        border-color: #037f51;
    }
</style>
