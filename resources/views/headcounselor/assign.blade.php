<!-- assign.blade.php -->

<head>
    <title>Assign Counselor</title>
</head>
@extends('components.layout') <!-- You might need to create this layout -->
@section('content')
    <div class="manage-users-container">
        <h2>Assign Counselor</h2>

        <form action="{{ route('head-counselor.assign') }}" method="POST">
            @csrf
            <div>
    <label for="head_counselor_id">Counselor:</label>
    <select name="head_counselor_id" id="head_counselor_id">
        @foreach($headCounselors as $headCounselor)
            <option value="{{ $headCounselor->id }}">
                {{ $headCounselor->user->name }} (ID: {{ $headCounselor->counselor_id }})
            </option>
        @endforeach
    </select>
</div>

            <div>
                <label for="department_id">Department:</label>
                <select name="department_id" id="department_id">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Assign Counselor</button>
        </form>
    </div>
@endsection
</html>

<style>
    .manage-users-container {
        padding: 20px;
        position: relative;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 80%;
        margin: 20px auto;
        margin-right: 30px;
    }
</style>
