@extends('components.admin')

@section('content')
<div class="manage-users-container">
    <div class="logoss"></div>

    <h1 class="page-title">Manage Users Password</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('manage-users') }}" method="GET" class="filter-form">
        <div class="form-group">
            <label for="role_filter">Filter by Role:</label>
            <select name="role_filter" id="role_filter" class="styled-select" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="Head Counselor">Head Counselor</option>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
                <option value="Counselor">Counselor</option>
                <option value="Dean">Dean</option>
                <option value="Admin">Admin</option>
            </select>
            <button type="submit" class="btn-reset">Reset</button>
        </div>
    </form>

    <div class="form-group">
        <label for="searchInput">Search by Name or Username:</label>
        <input type="text" id="searchInput" class="styled-input" placeholder="Enter name or username..." onkeyup="filterUsers()">
    </div>
    <div class="table-wrapper">
    <div class="pagination-links">
    {{ $users->links() }}
        <table class="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User Account</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role ? $user->role->role_name : 'No role assigned' }}</td>
                    <td class="action-buttons">
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
    </div>
</div>

<style>
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f4f6f9;
    }

    .manage-users-container {
        background: white;
        padding: 40px;
        margin: 80px auto;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 1000px;
        position: relative;
    }

    .page-title {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #2d472c;
    }

    .logoss {
        background-image: url('../scss/image/ExcUseSlip.png');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        position: absolute;
        height: 60px;
        width: 120px;
        top: 15px;
        right: 20px;
        z-index: 1;
    }

    .filter-form {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
        width: 100%;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
        color: #333;
    }

    .styled-select,
    .styled-input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #fffceb;
        color: #2d472c;
        font-weight: 600;
    }

    .styled-select:focus,
    .styled-input:focus {
        border-color: #fec039;
        outline: none;
        box-shadow: 0 0 6px rgba(254, 192, 57, 0.4);
    }

    .btn-reset {
        margin-top: 10px;
        background-color: #eee;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-reset:hover {
        background-color: #ccc;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .user-table th,
    .user-table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 14px;
    }

    .user-table th {
        background-color: #4CAF50;
        color: white;
        font-size: 15px;
        text-transform: uppercase;
    }

    .user-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .user-table tr:hover {
        background-color: #eef6ee;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn {
        padding: 8px 14px;
        font-size: 13px;
        border-radius: 6px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-edit:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #bd2130;
    }
    .pagination-links {
    margin-top: 20px;
    text-align: center;
}

.pagination-links nav {
    display: inline-block;
}

.pagination-links .flex {
    display: flex;
    justify-content: center;
    list-style: none;
    padding-left: 0;
}

.pagination-links .flex li {
    margin: 0 5px;
}

.pagination-links .flex li a,
.pagination-links .flex li span {
    padding: 8px 12px;
    border-radius: 8px;
    background-color: #f1f1f1;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s;
}

.pagination-links .flex li a:hover {
    background-color: #4CAF50;
    color: white;
}


    @media screen and (max-width: 768px) {
        .filter-form {
            flex-direction: column;
            align-items: flex-start;
        }

        .logoss {
            position: static;
            margin: 0 auto 20px;
        }
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
                let name = nameCell.textContent.toLowerCase();
                let username = usernameCell.textContent.toLowerCase();

                row.style.display = name.includes(input) || username.includes(input) ? "" : "none";
            }
        }
    }
</script>

@endsection
