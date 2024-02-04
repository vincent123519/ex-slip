@extends('components.admin')

@section('content')
<div class="manage-users-container">
    <h1>Manage Users Password</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('manage-users') }}" method="GET">
        <div class="form-group">
            <label for="role_filter">Filter by Role:</label>
            <select name="role_filter" id="role_filter" class="form-control" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="Head Counselor">Head Counselor</option>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
                <option value="Counselor">Counselor</option>
                <option value="Dean">Dean</option>
                <option value="Admin">Admin</option>
                 <!-- Add reset option -->
                <!-- Add other roles as needed -->
            </select>
        </div>
        <a href="{{ route('manage-users') }}" class="btn btn-secondary">Reset</a> 
    </form>

    <table class="user-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Useraccount</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ $user->username }}</td>
                <td>
                    @if($user->role)
                        {{ $user->role->role_name }}
                    @else
                        No role assigned for user {{ $user->name }}
                    @endif
                </td>
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

<style>
body {
    font-family: 'Montserrat', sans-serif;
}

.manage-users-container {
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
    margin-top: 10px;
}

.user-table th, .user-table td {
    border: 1px solid #ccc;
    padding: 6px;
    text-align: left;
    font-size: 14px;
}

.user-table th {
    background-color: #4CAF50;
    color: white;
}
</style>

@endsection
