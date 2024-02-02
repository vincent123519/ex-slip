@extends('components.Admin')

@section('content')
    <div class="teacher-container">
        <h1>Teachers List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->id }}</td>
                    <td>{{ $teacher->first_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style></style>