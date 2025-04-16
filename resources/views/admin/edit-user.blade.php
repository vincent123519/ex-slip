@extends('components.admin')
@section('content')

<body>
    <div class="container">
        @php
            $imagePath = Auth::user()->image ? 'storage/user_image/' . Auth::user()->image : 'storage/user_image/user.png';
        @endphp

        <div class="card">
            <div class="profile-header">
                <img src="{{ asset($imagePath) }}" alt="User Image" class="profile-img" />
                <div class="profile-info">
                    <h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
                    <p class="role">Role: {{ $user->role->role_name }}</p>
                </div>
            </div>

            <hr class="divider">

            <h3 class="section-title">Change Password</h3>

            <form action="{{ route('update-user', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="username">User Account</label>
                    <input type="text" id="username" name="username" value="{{ $user->username }}">
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-square-fill"></i> Update User
                    </button>
                    <a href="{{ route('manage-users') }}" class="btn btn-secondary">
                        Back to Manage Users
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

@endsection

<style>
    body {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        background-color: #f4f6f9;
    }

    .container {
        display: flex;
        justify-content: center;
        margin-top: 80px;
        padding: 20px;
    }

    .card {
        background-color: white;
        border-radius: 12px;
        padding: 40px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .profile-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
        border: 3px solid #fec039;
        background-color: #fff;
    }

    .profile-info h2 {
        margin: 0;
        font-size: 22px;
        color: #333;
    }

    .profile-info .role {
        color: #777;
        font-size: 14px;
        margin-top: 4px;
    }

    .divider {
        border: none;
        height: 1px;
        background-color: #ddd;
        margin: 20px 0;
    }

    .section-title {
        font-size: 20px;
        color: #041f05;
        margin-bottom: 25px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: border 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #fec039;
        box-shadow: 0 0 5px rgba(254, 192, 57, 0.3);
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        gap: 10px;
    }

    .btn {
        flex: 1;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: background 0.3s ease;
    }

    .btn-primary {
        background-color: #fec039;
        color: #041f05;
    }

    .btn-primary:hover {
        background-color: #e3aa32;
    }

    .btn-secondary {
        background-color: #ddd;
        color: #333;
    }

    .btn-secondary:hover {
        background-color: #ccc;
    }
</style>
