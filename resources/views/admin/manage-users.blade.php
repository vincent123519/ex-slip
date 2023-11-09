<!-- manage-users.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <!-- Add your CSS stylesheets here -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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

    <!-- Add your additional HTML content and scripts here -->
    <script src="scripts.js"></script>
</body>
</html>