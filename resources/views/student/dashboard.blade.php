@extends('components.stud')

@section('content')
    <div class="student-details-container">
        <h1>Absence Request</h1>        <a href="{{ route('excuse_slips.create') }}" class="create-slip-button">Request Excuse Slip</a>

        <hr>

        <form action="{{ route('student.dashboard') }}" method="GET">
            <label for="sort_by">Sort By:</label>
            <select name="sort_by" id="sort_by">
                <option value="day" {{ request()->input('sort_by') == 'day' ? 'selected' : '' }}>All</option>
                <option value="today" {{ request()->input('sort_by') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="month" {{ request()->input('sort_by') == 'month' ? 'selected' : '' }}>Month</option>
                <option value="year" {{ request()->input('sort_by') == 'year' ? 'selected' : '' }}>Year</option>
            </select>

            @if (request()->input('sort_by') == 'month')
            <label for="month">Select Month:</label>
            <select name="month" id="month">
                @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                @endforeach
            </select>
            <label for="year">Select Year:</label>
            <select name="year" id="year">
                @for ($year = date('Y'); $year >= 2000; $year--)
                    <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        @endif

            @if (request()->input('sort_by') == 'year')
                <select name="year">
                    @for ($year = date('Y'); $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            @endif

            <button type="submit">Sort</button>
        </form>

        <div class="manage-slip-container">

            <h1>Excuse Slips Dashboard</h1>

            @if($excuseSlips->isEmpty())
                <p>No Excuse Slips found.</p>
            @else
                <table class="excuse-slip-table">
                    <thead>
                        <tr>
                            <th>Date Created</th>
                            <th>Student</th>
                            <th>Teacher</th>
                            <th>Course</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th> 

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($excuseSlips as $excuseSlip)
                            <tr>
                                <td>{{ $excuseSlip->formatted_created_at }}</td>
                                <td>{{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</td>
                                <td>{{ $excuseSlip->teacher->first_name }} {{ $excuseSlip->teacher->last_name }}</td>
                                <td>{{ $excuseSlip->course->course_name }}</td>
                                <td>{{ $excuseSlip->start_date }}</td>
                                <td>{{ $excuseSlip->end_date }}</td>
                                <td>{{ $excuseSlip->status->status_name }}</td>
                                <td><a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $excuseSlip->excuse_slip_id]) }}" class="view-button">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    @if(session('start_date') && session('end_date'))
                        <br>
                        <strong>Excuse Slip Dates:</strong> {{ session('start_date') }} to {{ session('end_date') }}
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

<style>
    .student-details-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        width: 62%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-family: 'Montserrat', sans-serif;

    }

    h1 {
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 5px;
    }

    .create-slip-button {
        display: inline-block;
        /* padding: 12px 400px; */
        font-size: 20px;
        text-align: center;
        text-decoration: none;
        background-color: #28a745;
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s;
        border: 5px solid #218838;
    }

    .create-slip-button:hover {
        background-color: #218838;
    }

    .manage-slip-container {
        margin-top: 20px;
    }

    .excuse-slip {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .excuse-slip p {
        margin-bottom: 5px;
    }

    .alert {
        margin-top: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    .excuse-slip-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .excuse-slip-table th, .excuse-slip-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .excuse-slip-table th {
        background-color: #f2f2f2;
    }

    .excuse-slip-table td {
        vertical-align: top;
    }

    

</style>
