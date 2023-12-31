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

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" required>
            @foreach($roles as $role)
                <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit">Register</button>
</form>
    </div>
@endsection