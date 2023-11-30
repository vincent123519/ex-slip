@extends('components.signlayout')

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
                <label for="role">Role</label>
                <select name="role" required>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
                @error('role')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
@endsection