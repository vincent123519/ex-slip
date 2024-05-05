@extends('components.stud')

@section('content')
    <div class="student-details-container">
        <div class="logosc"></div>
        <h1>Absence Request</h1>
        <a href="{{ route('excuse_slips.create') }}" class="create-slip-button">Request Excuse Slip</a>

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

            <h2>Excuse Slips Dashboard</h2>

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
                            <td>{{ $excuseSlip->course->course_code}} -{{ $excuseSlip->course->offer_code}}</td>
                            <td>{{ $excuseSlip->start_date }}</td>
                            <td>{{ $excuseSlip->end_date }}</td>
                            <td>{{ $excuseSlip->status->status_name }}</td>
                            <td>
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
                {{ $excuseSlips->links() }} <!-- Add pagination links -->
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


    <footer>
    <div class="notification">
        <span>notification</span>
        <div class="notification-content">
            @if ($unreadExcuseSlips->count() > 0)
                @foreach ($unreadExcuseSlips as $unreadExcuseSlip)
                    <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $unreadExcuseSlip->excuse_slip_id]) }}" class="view-button">
                        @php
                            $approver = '';
                            if ($unreadExcuseSlip->status_id == 2) {
                                $approver = $unreadExcuseSlip->counselor->first_name. ' ' . $unreadExcuseSlip->counselor->last_name;
                            } elseif ($unreadExcuseSlip->status_id == 4) {
                                $approver = $unreadExcuseSlip->dean->first_name. ' ' . $unreadExcuseSlip->dean->last_name;
                            } elseif ($unreadExcuseSlip->status_id == 5) {
                                $approver = $unreadExcuseSlip->teacher->first_name . ' ' . $unreadExcuseSlip->teacher->last_name;
                            }
                        @endphp
                        <p>
                            @if ($unreadExcuseSlip->status_id == 1)
                                An excuse slip is sent  to <b>{{$unreadExcuseSlip->counselor->first_name}}, {{$unreadExcuseSlip->counselor->last_name}}</b>
                            @else
                                <b>{{ $approver }}</b> approved your excuse slip
                            @endif
                        </p>
                        <p>View excuse slip.. 
                    </a>
                    <hr>
                @endforeach
            @else
                <p>No unread excuse slips.</p>
            @endif
        </div>
    </div>
</footer>
@endsection

<style>
    .sidebar {
    z-index: 0;
    background: #fec039;
    position: absolute;
    width: 250px;
    height: calc(100% - 9%);
    /* opacity: .9; */
    transition: 0.3s;
    transition-property: width;
    overflow-y: auto;
    font-family: Arial, sans-serif;
}

.header {
    z-index: 1;
    background-color: rgba(13, 62, 32, 0.98);
    background-image: linear-gradient(to right, rgba(13, 62, 32, 0.98), rgba(2, 28, 2, 0.98));
    width: 100%;
    height: 100px;
    display: flex;
    top: 0;
    position: static;
}

/* Added CSS for .student-details-container */
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

/* Added CSS for .excuse-slip-table */
.excuse-slip-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.excuse-slip-table th, .excuse-slip-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    width: auto; /* Adjust the width as needed */
}

.excuse-slip-table th {
    background-color: #f2f2f2;
}

.excuse-slip-table td {
    vertical-align: top;
}

@media screen and (max-width: 768px) {
    /* Added CSS for responsive sidebar and header */
    .sidebar {
        z-index: 1;
        background: #fec039;
        position: absolute;
        width: 103px;
        height: 120%;
        opacity: .9;
        transition: 0.3s;
        transition-property: all;
        overflow-y: auto;
        font-family: Arial, sans-serif;
    }

    .header {
        z-index: 1;
        background-color: rgba(13, 62, 32, 0.98);
        background-image: linear-gradient(to right, rgba(13, 62, 32, 0.98), rgba(2, 28, 2, 0.98));
        width: 100%;
        height: 100px;
        display: flex;
        top: 0;
        position: static;
    }

    /* Added CSS to reset table cell width for smaller screens */
    .excuse-slip-table th, .excuse-slip-table td {
        width: auto; /* Set back to auto for smaller screens */
    }
}
.hidden-pagination {
    display: none;
}

footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: rgba(13, 62, 32, 0.98);
      text-align: right; /* Align the notification to the right */
      padding: 0 20px;
    }
    footer hr {
      border: none;
      border-top: 1px solid #ccc;
      margin: 10px auto;
    }
    .notification {
      background-color: #fec039;
      color: white;
      text-decoration: none;
      position: relative;
      display: inline-block;
      border-radius: 2px;
      padding-right: 250px;
      cursor: pointer; /* Add cursor pointer to indicate interactivity */
    }
    .notification:hover {
      background: #fec039;
    }
    .notification-content {
    display: none;
    position: absolute;
    top: -145px;
    right: 0;
    width: 341px;
    height: 200px; /* Set a specific height for the container */
    background-color: #fec039;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    z-index: 1;
    font-size: small;
    color: #28a745;
    text-align: left;
    overflow: auto; /* Add the overflow property for scrollable content */
    font-family: 'Montserrat', sans-serif;

}
    .notification.active .notification-content {
      display: block; /* Show the notification content when the notification is active */
    }
   
    

</style>
<style></style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const notification = document.querySelector('.notification');
      const notificationContent = document.querySelector('.notification-content');

      notification.addEventListener('click', function() {
        notification.classList.toggle('active');
      });
    });
  </script>