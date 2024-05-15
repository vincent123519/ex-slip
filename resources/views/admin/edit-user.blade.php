@extends('components.admin')
@section('content')
<body>
    <div class="container">
    @php
$imagePath = Auth::user()->image ? 'storage/user_image/' . Auth::user()->image : 'storage/user_image/user.png';
@endphp

<div class="user-details-container">
<img src="{{ asset($imagePath) }}"
            alt="User Image"
            style="width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    background-color: #fff;
                    margin-bottom: 10px;
                    background-size: cover;
                    background-position: center;"
        />
    <h1>Change Password</h1>
    <hr>
    <div class="user-details">

   
        <div class="profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
        <p><strong>Role:</strong> {{ $user->role->role_name }}</p>
    </div>


            <form action="{{ route('update-user', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="username">UserAccount</label>
                    <input type="text" id="username" name="username" value="{{ $user->username }}">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>

                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z" />
                    </svg>
                    Update User
                </button>
            </form>

            <a href="{{ route('manage-users') }}" class="btn btn-secondary">
                Back to Manage Users
            </a>
        </div>
    </div>
</body>
@endsection


<style> body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            
            position: relative;
            border: 1px solid #fff;
            border-radius: 10px;
            width: 50%;
            margin: 20px auto;
            padding: 50px;
            box-sizing: border-box;
            /* background-color: #f9f9f9; */
            margin-top: 100px;
        
        }

        .container h1 {
            font-size: 24px;
            margin: 0 0 20px;
        }

        .user-details {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            text-decoration: none;
            color: #fff;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-secondary {
            background-color: #6c757d;
            margin-left: 0;
        }

        
    </style></style>