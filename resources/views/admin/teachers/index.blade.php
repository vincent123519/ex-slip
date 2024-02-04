@extends('components.Admin')

@section('content')
    <div class="manage-teachers-container">
        <h1>Teachers List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>last Name</th>
                    <th>Department</th>
                    <th>Action</th>

                   

                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->teacher_id }}</td>
                    <td>{{ $teacher->first_name }},</td>
                    <td>{{ $teacher->last_name }}</td>
                    <td>{{$teacher->department->department_name}}</td>
                    <td><button class="add-subject-btn">Add Subject</button></td>



                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style>
    .manage-teachers-container {
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;
    font-family: 'Montserrat', sans-serif;
    border-collapse: collapse;
    background-color: rgba(255, 255, 255, 0.5);
    }

    .manage-teachers-container th,
.manage-teachers-container {
    border: 1px solid #000;
    padding: 8px;
}

.add-subject-btn {
    background-color: green;
    color: white;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    border-radius: 4px;

}

</style>