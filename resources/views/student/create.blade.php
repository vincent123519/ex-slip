<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
</head>
<body>
    <h1>Create Student</h1>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf

        <div>
            <label for="user_id">User ID:</label>
            <input id="user_id" type="text" name="user_id" value="{{ old('user_id') }}" required>
            @error('user_id')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="name">Name:</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="degree_id">Degree ID:</label>
            <input id="degree_id" type="text" name="degree_id" value="{{ old('degree_id') }}" required>
            @error('degree_id')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="year_level">Year Level:</label>
            <input id="year_level" type="text" name="year_level" value="{{ old('year_level') }}" required>
            @error('year_level')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Create</button>
    </form>
</body>
</html>
