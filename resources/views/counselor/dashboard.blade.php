@extends('components.counselor')

@section('content')
    <div class="counselor-details-container">
        <h1>Absence Request</h1>
        <a href="" class="create-slip-button">Number of Excuse slip</a>
        <p>Total Excuse Slips: {{ $excuseSlips->count() }}</p> <!-- Display the count of excuse slips -->

        <form action="{{ route('counselor.dashboard') }}" method="GET">
            <label for="sort_by">Sort By:</label>
            <select name="sort_by" id="sort_by">
                <option value="today" {{ request()->input('sort_by') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="weekly" {{ request()->input('sort_by') == 'weekly' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="month" {{ request()->input('sort_by') == 'month' ? 'selected' : '' }}>Month</option>
                <option value="year" {{ request()->input('sort_by') == 'year' ? 'selected' : '' }}>Year</option>
            </select>

            <!-- Display month dropdown if "month" is selected -->
            @if (request()->input('sort_by') == 'month')
                <select name="month">
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                    @endforeach
                </select>
            @endif

            <!-- Display year dropdown if "year" is selected -->
            @if (request()->input('sort_by') == 'year')
                <select name="year">
                    @for ($year = date('Y'); $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            @endif

            <button type="submit">Sort</button>
        </form>
    </div>


    <div class="excuse-container">
        <h2>List of Student Excuse Slips</h2>

        @if($excuseSlips->count() > 0)
            <table class="excuse-slip-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student Name</th>
                        <th>Reason</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($excuseSlips as $index => $excuseSlip)
                <tr>
                  <td>{{ $excuseSlip->created_at->format('Y-m-d') }}</td>
                    <td>{{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</td>
                    <td>{{ $excuseSlip->reason }}</td>
                    <td>{{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</td>
                    <td>{{ $excuseSlip->status->status_name }}</td>
                    <td>
                    <form action="{{ route('excuse.approve', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
    @csrf
    @method('PUT')
    <!-- <button type="submit" class="btn-approved">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-check" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
        </svg> Note
    </button> -->
</form>


    <!-- <form action="{{ route('excuse.reject', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
        @csrf
        @method('PUT')
        <button type="submit" class="btn-reject">Reject</button>
    </form> -->

    <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $excuseSlip->excuse_slip_id]) }}" class="view-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
        </svg>
    </a>
</td>

                </tr>
            @endforeach
                </tbody>
            </table>
        @else
            <p>No excuse slips found.</p>
        @endif
    </div>
@endsection


<style>
    body{
        font-family: 'Montserrat', sans-serif;
    }
    .counselor-details-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

    }
    .excuse-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 5px;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .excuse-slips-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .excuse-slip {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 15px;
        width: 95%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .excuse-slip p {
        margin: 0 0 10px;
    }

    .excuse-slip strong {
        font-weight: bold;
    }

    .btn-approved {
        background-color: #28a745;
        height: 30px; /* Set the height you desire */
        width: 40%; /* Full width of the container */
        border: none;
        border-radius: 5px;
        color: white;
    }

    .btn-approved:hover {
        background-color: darkgreen;
        height: 30px; /* Set the height you desire */
        width: 45%; /* Full width of the container */
        
    }
    .btn-reject {
        background-color: red;
        height: 30px; /* Set the height you desire */
        width: 40%; /* Full width of the container */
        border: none;
        border-radius: 5px;
        color: white;
    }

    .btn-reject:hover {
        background-color: darkred;
        height: 30px; /* Set the height you desire */
        width: 45%; /* Full width of the container */
        
    }

    .excuse-slip-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .excuse-slip-table th, .excuse-slip-table td {
        border: 1px solid #ddd;
        padding: px;
        text-align: center;
    }

    .excuse-slip-table th {
        background-color: #f2f2f2;
    }

    .excuse-slip-table td {
        vertical-align: top;
    }

    .excuse-slip-table tbody td {
    }
    
</style>