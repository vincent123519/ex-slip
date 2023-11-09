<!-- student/edit.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}">
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="degree_id">Degree ID:</label>
            <input type="text" id="degree_id" name="degree_id" value="{{ old('degree_id', $student->degree_id) }}">
            @error('degree_id')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="year_level">Year Level:</label>
            <input type="text" id="year_level" name="year_level" value="{{ old('year_level', $student->year_level) }}">
            @error('year_level')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <br>

        <div>
            <button type="submit">Update</button>
        </div>
    </form>
</body>
</html>