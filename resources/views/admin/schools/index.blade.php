@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Schools</h1>

        <table id="school" class="table">
            <thead>
                <tr>
                    <th>School Code</th>
                    <th>School Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schools as $school)
                    <tr>
                        <td>{{ $school->school_code }}</td>
                        <td>{{ $school->school_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style>
      #school {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 50%; /* Adjust width to avoid overlap */
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
