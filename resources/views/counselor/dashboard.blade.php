@extends('components.counselor')

@section('content')
    <div class="counselor-details-container">
    <div class="logosc"></div>
        <h1>Absence Request</h1>
        <hr>
        
        <!-- <a href="" class="create-slip-button">Number of Excuse slip</a> -->
    
        <p style="font-weight: bold;">Total Excuse Slips: {{ $excuseSlips->count() }}</p> <!-- Display the count of excuse slips -->

        <form action="{{ route('counselor.dashboard') }}" method="GET">
        <label for="sort_by" style="font-weight: bold;">Sort By:</label>
<select name="sort_by" id="sort_by" style="font-weight: bold; background: darkseagreen;">
    <option value="today" {{ request()->input('sort_by') == 'today' ? 'selected' : '' }}>Today</option>
    <option value="weekly" {{ request()->input('sort_by') == 'weekly' ? 'selected' : '' }}>Last 7 Days</option>
    <option value="month" {{ request()->input('sort_by') == 'month' ? 'selected' : '' }}>Month</option>
    <option value="year" {{ request()->input('sort_by') == 'year' ? 'selected' : '' }}>Year</option>
    <option value="semester" {{ request()->input('sort_by') == 'semester' ? 'selected' : '' }}>Semester</option>
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

<!-- Display semester dropdown if "semester" is selected -->
@php
    $semesters = App\Models\Semester::all();
@endphp

@if (request()->input('sort_by') == 'semester')
    <select name="semester_id">
        <!-- Populate the semester options here -->
        @foreach ($semesters as $semester)
            <option value="{{ $semester->semester_id }}" {{ request()->input('semester_id') == $semester->semester_id ? 'selected' : '' }}>
                {{ $semester->semester_name }}
            </option>
        @endforeach
    </select>
@endif

<button type="submit">Sort</button>
        </form>
    </div>

    <div class="excuse-container">
    <div class="logosc"></div>
    <a href="{{ $exportUrl }}">Export Excuse Slips</a>

    <h2 style="
    margin-top: 71px;
    margin-left: 395px;
">List of Student Excuse Slips</h2>

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
                    <td>
                    @if($excuseSlip->status->status_name == 'Approved by Counselor')
                        Approved
                    @else
                        {{ $excuseSlip->status->status_name }}
                    @endif
                </td>
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

    <footer>
    <div class="notification">
      <span>notification</span>
      <div class="notification-content">
      @foreach ($latestExcuseSlips as $latestExcuseSlip)
      <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $latestExcuseSlip->excuse_slip_id]) }}" class="view-button">

    <h4>{{ $latestExcuseSlip->student->first_name }} created an excuse slip {{ $latestExcuseSlip->created_at }}
      @if ($latestExcuseSlip->read_by_counselor == 1)
        <span style="color: green;">(Seen)</span>
      @else
        <span style="color: red;">(Not Seen)</span>
      @endif
    </h4>
    <!-- Additional details or actions related to the excuse slip -->
    <p>Course: {{ $latestExcuseSlip->course->course_code }}</p>
    <form method="POST" action="{{ route('excuse_slips.mark_as_read', ['excuseSlipId' => $latestExcuseSlip->excuse_slip_id]) }}" style="display: inline;">
      @csrf
      @method('PUT')
      <button type="submit" class="view-button">
        
      </button>

    </form>

    <hr style="color: #55825f;">
  @endforeach
</div>
    </div>
  </footer>

@endsection


<style>
.logosc {
    background-image: url(http://[::1]:4000/resources/scss/image/ExcUseSlip.png);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    margin-top: -15px;
    margin-left: 485px;
    position: absolute;
    height: 50px;
    width: 102px;
    z-index: 1;
    padding: 21px 22px;
}

    body{
        font-family: 'Montserrat', sans-serif;
    }
    .counselor-details-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 10px solid #55825f;
        border-radius: 1px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

    }
    .excuse-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 10px solid yellowgreen;
        border-radius: 0px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
    margin-top: 75px;
    margin-left: 418px;
}

hr{
        height: 1px;
        background-color: darkgreen;
        border: 2px solid black;
        border-radius: 10px;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
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
    font-size: xx-small;
    color: #28a745;
    text-align: left;
    overflow: auto; /* Add the overflow property for scrollable content */
}
    .notification.active .notification-content {
      display: block; /* Show the notification content when the notification is active */
    }
   
    
</style>
<script>
    document.getElementById('exportBtn').addEventListener('click', function() {
        window.location.href = "{{ $exportUrl }}";
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const notification = document.querySelector('.notification');
      const notificationContent = document.querySelector('.notification-content');

      notification.addEventListener('click', function() {
        notification.classList.toggle('active');
      });
    });
  </script>

<script>
function markAsRead(excuseSlipId) {
  // Send an AJAX request to mark the excuse slip as read by the counselor
  fetch('/excuse_slips/' + excuseSlipId + '/mark-as-read', {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}' // Make sure to include the CSRF token
    },
    body: JSON.stringify({ excuse_slip_id: excuseSlipId })
  })
  .then(response => {
    // Handle the response
    if (response.ok) {
      // Success: Update the UI or perform any necessary actions
    } else {
      // Error: Handle the error case
    }
  })
  .catch(error => {
    // Error: Handle the error case
  });
}
</script>