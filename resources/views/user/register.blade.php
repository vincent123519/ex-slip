<!-- user/register.blade.php -->

@extends('components.signlayout') <!-- You might need to create this layout -->
    @section('content')

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
    <div class="register-container">
    <h1>User Registration</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required>
            @error('username')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
            @error('password')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" required>
            @error('password_confirmation')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">Register</button>
        </div>

        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
    @endsection
    </form>
    </div>

   