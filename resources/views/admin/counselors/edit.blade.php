@extends('components.admin')

@section('content')
<body>
    <div class="container">
        @php
            $imagePath = Auth::user()->image ? 'storage/user_image/' . Auth::user()->image : 'storage/user_image/user.png';
        @endphp

        <div class="user-details-container text-center">
            <img src="{{ asset($imagePath) }}" alt="User Image" class="profile-image" />
            <h1>{{ $counselor->first_name }} {{ $counselor->last_name }}</h1>
            <hr>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('teacher_info'))
                @php
                    $teacherInfo = session('teacher_info');
                @endphp
                <div class="alert alert-info">
                    Selected Teacher: {{ $teacherInfo['first_name'] }} {{ $teacherInfo['last_name'] }} ({{ $teacherInfo['username'] }})
                </div>
            @endif

            <form action="{{ route('admin.counselors.update', $counselor->counselor_id) }}" method="POST" id="counselorForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $counselor->first_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $counselor->last_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username', $counselor->user->username) }}" required>
                </div>

                <div class="form-group">
                    <label for="teacher_id">Select Teacher</label>
                    <select id="teacher_id" name="teacher_id">
                        <option value="">Select a teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" 
                                data-first-name="{{ $teacher->first_name }}" 
                                data-last-name="{{ $teacher->last_name }}" 
                                data-username="{{ $teacher->user->username }}">
                                {{ $teacher->first_name }} {{ $teacher->last_name }} ({{ $teacher->user->username }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Profile
                </button>
            </form>

            <a href="{{ route('admin.counselors.index') }}" class="btn btn-secondary">
                Back to Manage Counselors
            </a>
        </div>
    </div>

    <script>
        document.getElementById('teacher_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const firstName = selectedOption.getAttribute('data-first-name');
            const lastName = selectedOption.getAttribute('data-last-name');
            const username = selectedOption.getAttribute('data-username');

            // Update input fields with selected teacher's details
            document.getElementById('first_name').value = firstName;
            document.getElementById('last_name').value = lastName;
            document.getElementById('username').value = username;
        });
    </script>
</body>
@endsection

<style>
    body {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f7fa;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .user-details-container {
        text-align: center;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 20px;
        border: 3px solid #007bff;
        background-color: #fff;
        object-fit: cover;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
        color: #555;
    }

    .form-group input[type="text"],
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        text-decoration: none;
        color: #fff;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-secondary {
        background-color: #6c757d;
        margin-left: 10px;
    }
</style>