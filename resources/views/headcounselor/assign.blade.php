<!-- assign.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Assign Counselor</title>
</head>
<body>
    <h2>Assign Counselor</h2>
    
    <form action="{{ route('head-counselor.assign') }}" method="POST">
        @csrf
        <div>
            <label for="head_counselor_id">Counselor:</label>
            <select name="head_counselor_id" id="head_counselor_id">
                @foreach($headCounselors as $headCounselor)
                    <option value="{{ $headCounselor->id }}">{{ $headCounselor->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="department_id">Department:</label>
            <select name="department_id" id="department_id">
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Assign Counselor</button>
    </form>
</body>
</html>