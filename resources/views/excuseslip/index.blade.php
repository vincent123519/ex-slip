<!-- index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Excuse Slips</title>
</head>
<body>
    <h1>Excuse Slips</h1>

    <table>
        <thead>
            <tr>
                <th>Excuse Slip ID</th>
                <th>Student</th>
                <th>Teacher</th>
                <th>Counselor</th>
                <th>Course</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($excuseSlips as $excuseSlip)
            <tr>
                <td>{{ $excuseSlip->id }}</td>
                <td>{{ $excuseSlip->student->name }}</td>
                <td>{{ $excuseSlip->teacher->name }}</td>
                <td>{{ $excuseSlip->counselor->name }}</td>
                <td>{{ $excuseSlip->course->name }}</td>
                <td>{{ $excuseSlip->status->name }}</td>
                <td>
                    <a href="{{ route('excuse_slips.show', ['id' => $excuseSlip->id]) }}">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">No excuse slips found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>