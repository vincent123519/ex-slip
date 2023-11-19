@extends('components.layout') <!-- You might need to create this layout -->
@section('content')
<head><title>EDIT USER</title></head>

<!-- // -->
<div class="main-container">
<div class="user-details-container">
        <h1>User Details</h1>
        <div class="user-details">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
    </div>
<div class="edit-user-container">
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
</div>
</div>
@endsection

<style>
    .main-container {
    max-width: 750px;
    margin: 20px;
    /* padding: 40px; */
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: rgba(13,62,32,0.98);
    display: block;
    
}
   .edit-user-container {
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 20px;
    margin: 10px; /* Add margin for spacing from the right side */
    width: 300px; /* Adjust the width as needed */
    float: right; /* Align it to the right */
}

/* Rest of the styling (same as the previous answer) */


.edit-user-container h1 {
    font-size: 24px;
}

.edit-user-container form {
    margin-top: 10px;
}

.edit-user-container form div {
    margin: 10px 0;
}

.edit-user-container form label {
    display: block;
    font-weight: bold;
}

.edit-user-container form input {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.edit-user-container button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
}

.edit-user-container a {
    display: block;
    margin-top: 10px;
    text-decoration: none;
    color: #007bff;
}

.user-details-container {
    flex: 1; /* Expand to fill available space */
    padding: 20px;
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 20px; /* Add margin to separate columns */
}
</style>