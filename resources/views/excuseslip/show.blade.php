<!-- show.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Excuse Slip Details</title>
</head>
<body>
    <h1>Excuse Slip Details</h1>

    <table>
        <tr>
            <th>Excuse Slip ID:</th>
            <td>{{ $excuseSlip->id }}</td>
        </tr>
        <tr>
            <th>Student:</th>
            <td>{{ $excuseSlip->student->name }}</td>
        </tr>
        <tr>
            <th>Teacher:</th>
            <td>{{ $excuseSlip->teacher->name }}</td>
        </tr>
        <tr>
            <th>Counselor:</th>
            <td>{{ $excuseSlip->counselor->name }}</td>
        </tr>
        <tr>
            <th>Dean:</th>
            <td>{{ $excuseSlip->dean->name }}</td>
        </tr>
        <tr>
            <th>Course:</th>
            <td>{{ $excuseSlip->course->name }}</td>
        </tr>
        <tr>
            <th>Reason:</th>
            <td>{{ $excuseSlip->reason }}</td>
        </tr>
        <tr>
            <th>Start Date:</th>
            <td>{{ $excuseSlip->start_date }}</td>
        </tr>
        <tr>
            <th>End Date:</th>
            <td>{{ $excuseSlip->end_date }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{ $excuseSlip->status->name }}</td>
        </tr>
    </table>

    <a href="{{ route('excuse_slips.index') }}">Back to Excuse Slips</a>
</body>
</html>