<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <!-- Add your CSS stylesheets here -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit User</h1>

    <form action="{{ route('update-user', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}">
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}">
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>

        <button type="submit">Update User</button>
    </form>

    <a href="{{ route('manage-users') }}">Back to Manage Users</a>

    <!-- Add your additional HTML content and scripts here -->
    <script src="scripts.js"></script>
</body>
</html>