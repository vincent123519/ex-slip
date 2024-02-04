

@extends('components.layout') <!-- You might need to create this layout -->
@section('content')<!-- index.blade.php -->

<head>
    <title>Head Counselor Index</title>
</head>
<div class="manage-users-container">
    <h2>Head Counselor Index</h2>
    
    <table>
        <thead>
            <tr>
                <th>Head Counselor</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Counselors as $headCounselor)
                <tr>
                    <td>{{ $Counselor->user->name }}</td>
                    <td>{{ $Counselor->department->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

</body>
</html>
<style>
    .manage-users-container {
    /* background-color: rgb(243 254 240 / 98%); */
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;
    }
</style>