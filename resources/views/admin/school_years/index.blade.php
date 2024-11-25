@extends('components.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-manage-sy">
                        <h4>Add School Year</h4>
                        <form action="{{ route('school-year.add') }}" method="POST">
                        @csrf
                        <div>
                            <input type="number" name="sy_id" id="school-year-input" min="1900" max="2099" value="" placeholder="Enter a 4-digit year" required>
                            <button type="submit" class="button school">Add</button>
                        </div>
                    </form>

                    <table id="manage-school-years">
                        <thead>
                            <tr>
                                <th>School Year ID</th>
                                <th>School Year Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($schoolYears as $schoolYear)
                        <tr>
                            <td>{{ $schoolYear->sy_id }}</td>
                            <td>{{ $schoolYear->sy_name }}</td>
                           
                        </tr>
                    @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-manage-sy">
                    
                <table class="semester-table">
                    <thead>
                        <tr>
                            <th>Semester ID</th>
                            <th>Semester Name</th>
                            <th>School Year ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semesters as $semester)
                            <tr>
                                <td>{{ $semester->semester_id }}</td>
                                <td>{{ $semester->semester_name }}</td>
                                <td>{{ $semester->sy_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>

    h4 {
    display: block;
    font-size: 1.00em;
    font-weight: bold;
    margin-block: 1.33em;
    text-align: center; 
    }
    
    .card-manage-sy  {
    position: relative;
    border: 10px solid #55825f;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;
    font-family: 'Montserrat', sans-serif;
    }


    #manage-school-years {
        font-family: 'Montserrat', sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #manage-school-years td, #manage-school-years th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #manage-school-years tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #manage-school-years tr:hover {
        background-color: #ddd;
    }

    #manage-school-years th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }

    .button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        cursor: pointer;
        font-size: 14px;
        position: center;
    }

    .button:hover {
        background-color: #0069d9;
    }

    .school {
        background-color: #04AA6D;
    }

    .school:hover {
        background-color: #038c5a;
    }
   

    .semester-table {
        font-family: 'Montserrat', sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .semester-table td, .semester-table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .semester-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .semester-table tr:hover {
        background-color: #ddd;
    }

    .semester-table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }

    
</style>