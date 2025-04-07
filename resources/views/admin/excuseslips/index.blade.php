@extends('components.admin')
@section('content')

    <h1>Excuse Slips</h1>

    <form action="{{ route('admin.excuseslip.index') }}" method="GET" id="forms">
    <div class="filter">
        <label for="school">School:</label>
        <select name="school_code" id="school">
            <option value="">All</option>
            @foreach ($schools as $school)
                <option value="{{ $school->school_code }}" {{ Request::input('school_code') == $school->school_code ? 'selected' : '' }}>
                    {{ $school->school_name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
    </div>
</form>
<form action="{{ route('admin.excuseslip.index') }}" method="GET" id="forms">
    <div class="filter">
        <label for="department">Department:</label>
        <select name="department_id" id="department">
            <option value="">All</option>
            @foreach ($departments as $department)
                <option value="{{ $department->department_id }}" {{ Request::input('department_id') == $department->id ? 'selected' : '' }}>
                    {{ $department->department_name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
    </div>
</form>

    <table id="excuseSlip">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Degree year level</th>
                <th>Department - School</th>
                <th>Date Absent</th>
                <th>Dean</th>
                <th>Counselor</th>
                <th>View</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($excuseslips as $excuseslip)
                <tr>
                    <td>{{ $excuseslip->student->first_name }}, {{ $excuseslip->student->last_name }}</td>
                    <td>{{ $excuseslip->student->year_level }} -{{ $excuseslip->student->degree->degree_name }}</td>
                    <td>{{ $excuseslip->student->degree->department->department_name }} -{{ $excuseslip->student->degree->department->school->school_code }}</td>
                    <td>{{ $excuseslip->start_date}} to {{ $excuseslip->end_date}}</td>
                    <td>{{ $excuseslip->dean->first_name }} {{ $excuseslip->dean->last_name }}</td>
                    <td>{{ $excuseslip->counselor->first_name }} {{ $excuseslip->counselor->last_name }}</td>
                    <td><a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $excuseslip->excuse_slip_id]) }}" class="view-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
            </svg>
    </a></td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection



<style>
        #forms {
            margin-left: 350px;

        }
        #excuseSlip {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 60%;
            margin-left: 350px;
        }

        #excuseSlip td, #excuseSlip th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #excuseSlip tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #excuseSlip tr:hover {
            background-color: #ddd;
        }

        #excuseSlip th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    
</style>