@extends('components.admin')

@section('content')
    <div class="manage-dean-container">
        <h1 class="text-center">All Deans</h1>
        <div class="table-container">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>dean ID</th>
                        <th>Name</th>
                        <th>School</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($deans as $dean)
                    <tr>
                        <td>{{ $dean->dean_id }}</td>
                        <td>{{ $dean->first_name }}</td>
                        <td>{{ $dean->school->school_name }}</td>
                        <td>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<style>
.manage-dean-container {
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

.manage-dean-container h1 {
    margin-top: 20px;
    text-align: left;

}

.manage-dean-container label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.manage-dean-container select {
    width: 100%;
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

.manage-dean-container .btn-primary {
    background-color: darkgreen;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.manage-student-container .btn-primary:hover {
    background-color: teal;
}

.table-sm th{
    border: 1px solid #000;
}
.table-sm td {
    padding: 0.3rem;
    
}


</style>