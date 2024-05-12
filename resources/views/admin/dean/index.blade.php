@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Deans</h1>
        <table id="dean" class="table">
            <thead>
                <tr>
                    <th>Dean ID - Useraccount</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>School</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deans as $dean)
                    <tr>
                        <td>{{ $dean->dean_id }} | {{ $dean->user->username }}</td>
                        <td>{{ $dean->first_name }}</td>
                        <td>{{ $dean->last_name }}</td>
                        <td>{{ $dean->school->school_name }}</td>
                        <td>{{ $dean->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style>
    #dean {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 60%;
        margin-left: 350px;
    }

    #dean td, #dean th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #dean tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #dean tr:hover {
        background-color: #ddd;
    }

    #dean th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>