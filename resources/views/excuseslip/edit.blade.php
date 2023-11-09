<!-- edit.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Edit Excuse Slip</title>
</head>
<body>
    <h1>Edit Excuse Slip</h1>

    <form action="{{ route('excuse_slips.update', ['id' => $excuseSlip->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="student_id">Student:</label>
            <select name="student_id" id="student_id">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ $student->id == $excuseSlip->student_id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="teacher_id">Teacher:</label>
            <select name="teacher_id" id="teacher_id">
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $teacher->id == $excuseSlip->teacher_id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="course_code">Course:</label>
            <select name="course_code" id="course_code">
                @foreach ($courses as $course)
                    <option value="{{ $course->code }}" {{ $course->code == $excuseSlip->course_code ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="reason">Reason:</label>
            <input type="text" name="reason" id="reason" value="{{ $excuseSlip->reason }}">
        </div>

        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="{{ $excuseSlip->start_date }}">
        </div>

        <div>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" value="{{ $excuseSlip->end_date }}">
        </div>

        <!-- Add other fields as necessary -->

        <button type="submit">Update Excuse Slip</button>
    </form>

    <a href="{{ route('excuse_slips.show', ['id' => $excuseSlip->id]) }}">Cancel</a>
</body>
</html>