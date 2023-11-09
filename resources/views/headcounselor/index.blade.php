<!-- index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Head Counselor Index</title>
</head>
<body>
    <h2>Head Counselor Index</h2>
    
    <table>
        <thead>
            <tr>
                <th>Head Counselor</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            @foreach($headCounselors as $headCounselor)
                <tr>
                    <td>{{ $headCounselor->user->name }}</td>
                    <td>{{ $headCounselor->department->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>