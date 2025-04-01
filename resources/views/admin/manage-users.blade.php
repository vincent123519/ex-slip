@extends('components.admin')

@section('content')
<div class="manage-users-container">
<div class="logoss"></div>
<h1 style="margin-top: 92px; margin-left: 546px;">Manage Users Password</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('manage-users') }}" method="GET">
        <div class="form-group">
            <label for="role_filter">Filter by Role:</label>
            <select name="role_filter" id="role_filter" class="form-control" onchange="this.form.submit()" style="font-weight: bold; background: yellow; color: darkgreen; font-family: auto;">
                <option value="">All</option>
                <option value="Head Counselor">Head Counselor</option>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
                <option value="Counselor">Counselor</option>
                <option value="Dean">Dean</option>
                <option value="Admin">Admin</option>
            </select>
            <button type="submit" class="btn btn-reset">Reset</button>
        </div>
    </form>
    
    <div class="form-group">
        <label for="searchInput">Search by Name or Username:</label>
        <input type="text" id="searchInput" class="form-control" placeholder="Enter name or username..." onkeyup="filterUsers()" style="font-weight: bold; background: lightyellow; color: darkgreen; font-family: auto;">
    </div>

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
                <td>{{ $user->role ? $user->role->role_name : 'No role assigned' }}</td>
                <td>
                    <a href="{{ route('edit-user', $user) }}" class="btn btn-edit">Edit</a>
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
    body { font-family: 'Montserrat', sans-serif; }
    .manage-users-container {
        position: relative;
        border: 10px solid #55825f;
        width: 80%;
        margin: 20px auto;
        margin-right: 30px;
    }
    .user-table { width: 95%; margin-top: 10px; }
    .user-table th, .user-table td {
        border: 3px solid #ccc;
        padding: 6px;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
    }
    .user-table th { background-color: #4CAF50; color: white; }
    .logoss {
        background-image: url(..s/scss/image/ExcUseSlip.png);
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        margin-top: 7px;
        margin-left: 668px;
        position: absolute;
        height: 50px;
        width: 102px;
        z-index: 1;
        padding: 21px 22px;
    }
    .btn-danger, .btn-reset, .btn-edit {
        background-color: white;
        color: #333;
        border: 1px solid #ccc;
    }
</style>

<script>
function filterUsers() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let table = document.querySelector(".user-table tbody");
    let rows = table.getElementsByTagName("tr");

    for (let row of rows) {
        let nameCell = row.getElementsByTagName("td")[0];
        let usernameCell = row.getElementsByTagName("td")[1];
        
        if (nameCell && usernameCell) {
            let name = nameCell.textContent.toLowerCase() || nameCell.innerText.toLowerCase();
            let username = usernameCell.textContent.toLowerCase() || usernameCell.innerText.toLowerCase();
            
            row.style.display = name.includes(input) || username.includes(input) ? "" : "none";
        }
    }
}
</script>

@endsection
