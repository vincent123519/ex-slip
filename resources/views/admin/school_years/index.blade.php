@extends('components.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                <h4>Manage School Years</h4>
                </div>
                <div class="card-manage-sy">
                        <h5>Add School Year</h5>
                        <form action="{{ route('school-year.add') }}" method="POST">
                     @csrf
                    <div class="form-group">
                        <label for="school-year">School Year:</label>
                        <select name="sy_id" id="school-year">
                            @for ($year = 2027; $year <= 2040; $year++)
                                <option value="{{ $year }}-{{ $year + 1 }}">{{ $year }}-{{ $year + 1 }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sy_name">School Year Name:</label>
                        <input type="text" name="sy_name" id="sy_name" class="form-control @error('sy_name') is-invalid @enderror" required>
                        @error('sy_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="button school">Add</button>
                </form>

                    <table id="manage-school-years">
                        <thead>
                            <tr>
                                <th>School Year ID</th>
                                <th>School Year Name</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schoolYears as $schoolYear)
                                <tr>
                                    <td>{{ $schoolYear->sy_id }}</td>
                                    <td>{{ $schoolYear->sy_name }}</td>
                                    <td>{{ $schoolYear->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        @if (!$schoolYear->is_active)
                                            <form action="{{ route('school-year.activate', $schoolYear->sy_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="button school">Activate</button>
                                            </form>
                                        @endif
                                    </td>
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
    .card-manage-sy  {
    position: relative;
    border: 10px solid #55825f;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;
    }


    #manage-school-years {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 60%;
        margin-left: 350px;
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
</style>