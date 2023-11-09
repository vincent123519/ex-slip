<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <!-- Include your CSS styles here -->
    <style>
        /* Add your CSS styles for the profile page here */
    </style>
</head>
<body>
    <h1>User Profile</h1>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('update-profile') }}">
        @csrf

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" required>
            @error('username')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">Update Profile</button>
        </div>
    </form>

    <!-- You can add additional content or styling here -->

</body>
</html>
