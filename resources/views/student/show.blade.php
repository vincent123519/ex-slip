<!-- student/show.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Student Details</title>
</head>
<body>
    <h1>Student Details</h1>

    <div>
        <strong>ID:</strong> {{ $student->id }}
    </div>

    <div>
        <strong>User ID:</strong> {{ $student->user_id }}
    </div>

    <div>
        <strong>Name:</strong> {{ $student->name }}
    </div>

    <div>
        <strong>Degree ID:</strong> {{ $student->degree_id }}
    </div>

    <div>
        <strong>Year Level:</strong> {{ $student->year_level }}
    </div>

    <br>

    <div>
        <a href="{{ route('students.edit', $student->id) }}">Edit</a>
        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
</body>
</html>