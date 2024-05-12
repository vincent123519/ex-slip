@extends('components.counselor')

@section('content')
    <!-- <div class="counselor-details-container">
        <h1>Absence Request</h1>
        <hr>
        
    
        <p style="font-weight: bold;">Total Excuse Slips: {{ $excuseSlips->count() }}</p>

        <form action="{{ route('counselor.dashboard') }}" method="GET">
        <label for="sort_by" style="font-weight: bold;">Sort By:</label>
            <select class="sorting"name="sort_by" id="sort_by">
                <option value="today" {{ request()->input('sort_by') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="weekly" {{ request()->input('sort_by') == 'weekly' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="month" {{ request()->input('sort_by') == 'month' ? 'selected' : '' }}>Month</option>
                <option value="year" {{ request()->input('sort_by') == 'year' ? 'selected' : '' }}>Year</option>
                <option value="semester" {{ request()->input('sort_by') == 'semester' ? 'selected' : '' }}>Semester</option>
                <option value="school_year" {{ request()->input('sort_by') == 'school_year' ? 'selected' : '' }}>School Year</option>
            </select>

        @if (request()->input('sort_by') == 'month')
            <select name="month">
                @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                @endforeach
            </select>
        @endif

        @if (request()->input('sort_by') == 'year')
            <select name="year">
                @for ($year = date('Y'); $year >= 2000; $year--)
                    <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        @endif

        @php
            $semesters = App\Models\Semester::all();
            $schoolYears = App\Models\SchoolYear::all();

        @endphp

        @if (request()->input('sort_by') == 'semester')
            <select name="semester_id">
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->semester_id }}" {{ request()->input('semester_id') == $semester->semester_id ? 'selected' : '' }}>
                        {{ $semester->semester_name }}
                    </option>
                @endforeach
            </select>
        @endif


        @if (request()->input('sort_by') == 'school_year')
            <select name="school_year_id">
                @foreach ($schoolYears as $schoolYear)
                    <option value="{{ $schoolYear->sy_id }}" {{ request()->input('school_year_id') == $schoolYear->sy_id ? 'selected' : '' }}>
                        {{ $schoolYear->sy_name }}
                    </option>
                @endforeach
            </select>
        @endif

            <button class="sorting" type="submit">Sort</button>
        </form>
    </div> -->

    <div class="excuse-container">
        <!-- <div class="logosc"></div> -->

            <h1>Absence Request</h1>
            <p style="font-weight: bold; float:left; font-size: 1vw;">Total Excuse Slips: {{ $excuseSlips->count() }}</p>
            <div class="notifContainer">
                <div class="notification">
                    <i id="bell" class=" fas fa-solid fa-bell fa-2x"></i>
                    <span></span>
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
            </div>
            <a class="expo"href="{{ $exportUrl }}">Export Excuse Slips</a>
            <hr>

            <div class="filterSection">
                <form action="{{ route('counselor.dashboard') }}" method="GET">
                    <label for="sort_by" style="font-weight: bold;">Sort By:</label>
                        <select class="sorting"name="sort_by" id="sort_by">
                            <option value="today" {{ request()->input('sort_by') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="weekly" {{ request()->input('sort_by') == 'weekly' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="month" {{ request()->input('sort_by') == 'month' ? 'selected' : '' }}>Month</option>
                            <option value="year" {{ request()->input('sort_by') == 'year' ? 'selected' : '' }}>Year</option>
                            <option value="semester" {{ request()->input('sort_by') == 'semester' ? 'selected' : '' }}>Semester</option>
                            <option value="school_year" {{ request()->input('sort_by') == 'school_year' ? 'selected' : '' }}>School Year</option>
                        </select>

                    @if (request()->input('sort_by') == 'month')
                        <select name="month">
                            @foreach (range(1, 12) as $month)
                                <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                            @endforeach
                        </select>
                    @endif

                    @if (request()->input('sort_by') == 'year')
                        <select name="year">
                            @for ($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    @endif

                    @php
                        $semesters = App\Models\Semester::all();
                        $schoolYears = App\Models\SchoolYear::all();

                    @endphp

                    @if (request()->input('sort_by') == 'semester')
                        <select name="semester_id">
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->semester_id }}" {{ request()->input('semester_id') == $semester->semester_id ? 'selected' : '' }}>
                                    {{ $semester->semester_name }}
                                </option>
                            @endforeach
                        </select>
                    @endif


                    @if (request()->input('sort_by') == 'school_year')
                        <select name="school_year_id">
                            @foreach ($schoolYears as $schoolYear)
                                <option value="{{ $schoolYear->sy_id }}" {{ request()->input('school_year_id') == $schoolYear->sy_id ? 'selected' : '' }}>
                                    {{ $schoolYear->sy_name }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                        <button class="sortingBtn" type="submit">Sort</button>
                </form>

                
                <div class="filter-container">
                    <label for="filter" style="font-weight: bold;">Filter by:</label>
                    <select id="filter" name="filter">
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="approved_by_counselor">Approved by Counselor</option>
                        <option value="rejected">Rejected</option>
                        <option value="approved_by_dean">Approved by Dean</option>
                        <option value="approved_by_teacher">Approved by Teacher</option>
                    </select>
                </div>

            </div>
        

        <h2 style="text-align: center;">List of Student Excuse Slips</h2>

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
                    <td>{{ $excuseSlip->status->status_name}}</td>
                    
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
  fetch('/excuse_slips/' + excuseSlipId + '/mark-as-read', {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}' 
    },
    body: JSON.stringify({ excuse_slip_id: excuseSlipId })
  })
  .then(response => {
    if (response.ok) {
    } else {
      // Error: Handle the error case
    }
  })
  .catch(error => {
e  });
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    function filterExcuseSlips(option) {
        var rows = $('.excuse-slip-table tbody tr');

        rows.each(function() {
            var status = $(this).find('td:nth-child(5)').text().trim().toLowerCase();

            console.log('Status:', status); // Debugging statement

            if (option === 'all') {
                $(this).show();
            } else if (option === 'pending' && status.includes('pending')) {
                $(this).show();
            } else if (option === 'approved_by_counselor' && status.includes('approved by counselor')) {
                $(this).show();
            } else if (option === 'rejected' && status.includes('rejected')) {
                $(this).show();
            } else if (option === 'approved_by_dean' && status.includes('approved by dean')) {
                $(this).show();
            } else if (option === 'approved_by_teacher' && status.includes('approved by teacher')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('#filter').change(function() {
        var selectedOption = $(this).val();
        console.log('Selected Option:', selectedOption); // Debugging statement
        filterExcuseSlips(selectedOption);
    });
});
</script>