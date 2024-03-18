@extends('components.admin')
@section('content')
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .main-containerss {
            position: relative;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 80%;
            margin: 20px auto;
            margin-right: auto;
            font-family: 'Montserrat', sans-serif;
            margin-right: 30px;


        }

        .user-details-container {
            background-color: #f8f9fa; /* Light background color */
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-right: 20px; /* Add margin to separate columns */


        }

        .user-details-container h1 {
            font-size: 24px;
            
        }

        .user-details-container .user-details p {
            margin: 5px 0;
        }
    </style>
</head>

<div class="main-containerss">
    <div class="user-details-container">
        <h1>User Account Details</h1>
        <div class="user-details">
            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }} <strong>Username:</strong> {{ $user->username }}</p>
        </div>
        
        <h1>Edit Username/Password</h1>

        <form action="{{ route('update-user', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}">
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
        </svg>
        Update User
    </button>
</form>

<a href="{{ route('manage-users') }}" class="btn btn-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z"/>
    </svg>
    Back to Manage Users
</a>
    </div>
</div>
@endsection
