@extends('components.layout') <!-- You might need to create this layout -->
@section('content')

<div class="manage-users-container">
    <h1>Manage Users</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="user-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('edit-user', $user) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('delete-user', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
<style>
.manage-users-container {
    /* background-color: rgb(243 254 240 / 98%); */
    padding: 20px;
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;
}


/* CSS styles for the user table */
.user-table {
    width: 95%;
    margin-top: 10px; /* Reduce the top margin */
}

.user-table th, .user-table td {
    border: 1px solid #ccc;
    padding: 6px; /* Reduce the cell padding */
    text-align: center;
    font-size: 14px; /* Reduce the font size */
}

.user-table th {
    background-color: #f2f2f2;
}

.user-table tr:hover {
    background-color: #e0e0e0;
}

/* CSS styles for the "Edit" and "Delete" buttons */
.btn {
    padding: 5px 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn:hover {
    background-color: #0056b3;
}
</style>
