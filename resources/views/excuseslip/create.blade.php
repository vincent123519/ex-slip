<!DOCTYPE html>
<html>
<head>
    <title>Create Excuse Slip</title>
</head>
<body>
    <h1>Create Excuse Slip</h1>

    <form action="{{ route('excuse_slips.store') }}" method="POST">

        @csrf

        <label for="student_id">Student:</label>
        <select name="student_id" id="student_id">
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>

        <label for="teacher_id">Teacher:</label>
        <select name="teacher_id" id="teacher_id">
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
        </select>

        <label for="counselor_id">Counselor:</label>
        <select name="counselor_id" id="counselor_id">
            @foreach($counselors as $counselor)
                <option value="{{ $counselor->id }}">{{ $counselor->name }}</option>
            @endforeach
        </select>

        <label for="course_code">Course:</label>
        <select name="course_code" id="course_code">
            @foreach($courses as $course)
                <option value="{{ $course->code }}">{{ $course->name }}</option>
            @endforeach
        </select>

        <label for="reason">Reason:</label>
        <textarea name="reason" id="reason" rows="4"></textarea>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date">

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date">

        <label for="status_id">Status:</label>
        <select name="status_id" id="status_id">
            @foreach($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
        </select>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
