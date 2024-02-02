@extends('components.layout')
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

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>

        <a href="{{ route('manage-users') }}" class="btn btn-secondary">Back to Manage Users</a>
    </div>
</div>
@endsection
