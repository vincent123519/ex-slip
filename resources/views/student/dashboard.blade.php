@extends('components.stud')
@section('content')

    <div class="student-details-container">
        <!-- <div class="logosc">
            
        </div> -->

        <h1 class="sh1">Absence Request</h1>
        <a href="{{ route('excuse_slips.create') }}" class="create-slip-button">Request Excuse Slip</a>
        <div>
            <div class="notification">
                <!-- <span>notification</span> -->
                <i id="bell" class=" fas fa-solid fa-bell fa-2x"></i>
                <div class="notification-content">
    @if ($unreadExcuseSlips->count() > 0)
        @foreach ($unreadExcuseSlips->sortByDesc('created_at') as $unreadExcuseSlip)
            <div>
                <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $unreadExcuseSlip->excuse_slip_id]) }}"
                   onclick="submitMarkAsRead(event, '{{ $unreadExcuseSlip->excuse_slip_id }}')"
                   class="view-button">
                    @php
                        $approver = '';
                        if ($unreadExcuseSlip->status_id == 2) {
                            $approver = $unreadExcuseSlip->counselor->first_name . ' ' . $unreadExcuseSlip->counselor->last_name;
                        } elseif ($unreadExcuseSlip->status_id == 4) {
                            $approver = $unreadExcuseSlip->dean->first_name . ' ' . $unreadExcuseSlip->dean->last_name;
                        }
                    @endphp

                    <p>
                        @if ($unreadExcuseSlip->status_id == 1)
                            An excuse slip is sent to <b>{{ $unreadExcuseSlip->counselor->first_name }}, {{ $unreadExcuseSlip->counselor->last_name }}</b>
                        @elseif ($unreadExcuseSlip->status_id == 2)
                            <b>{{ $approver }}</b> approved your excuse slip
                        @elseif ($unreadExcuseSlip->status_id == 3)
                            <b>Dean</b> rejected your excuse slip
                        @elseif ($unreadExcuseSlip->status_id == 4)
                            <b>{{ $approver }}</b> approved your excuse slip
                        @elseif ($unreadExcuseSlip->status_id == 5)
                            All <b>teachers</b> have approved your excuse slip
                        @endif
                    </p>

                    {{-- Loop through the course offerings to show teacher feedback --}}
                    @foreach ($unreadExcuseSlip->courseOfferings as $courseOffering)
                        @php
                            $teacherFeedbackExcuseSlip = DB::table('course_excuse_slip')
                                ->where('excuse_slip_id', $unreadExcuseSlip->excuse_slip_id)
                                ->where('offer_code', $courseOffering->offer_code)
                                ->where('is_remark_by_teacher', 1)
                                ->whereNotNull('teacher_feedback')
                                ->first();

                            $teacherFeedback = $teacherFeedbackExcuseSlip ? $teacherFeedbackExcuseSlip->teacher_feedback : null;
                            $teacher = $courseOffering->teacher;
                            $teacherName = $teacher ? $teacher->first_name . ' ' . $teacher->last_name : 'N/A';
                        @endphp

                        @if ($teacherFeedback)
                            <p>Teacher: <strong>{{ $teacherName }}</strong>: "{{ $teacherFeedback }}"</p>
                        @endif
                    @endforeach

                    <p>View excuse slip...</p>
                </a>

                <hr>
            </div>
        @endforeach
    @else
        <p>No unread excuse slips.</p>
    @endif
</div>


            </div>
        </div>
        <hr>
        <div class="filterSection">
            <div class="filter-container">
            <form action="{{ route('student.dashboard') }}" method="GET">
    <label for="sort_by" style="font-weight: bold;">Sort By:</label>
    <select name="sort_by" id="sort_by">
        <option value="day" {{ request()->input('sort_by') == 'day' ? 'selected' : '' }}>All</option>
        <option value="today" {{ request()->input('sort_by') == 'today' ? 'selected' : '' }}>Today</option>
        <option value="month" {{ request()->input('sort_by') == 'month' ? 'selected' : '' }}>Month</option>
        <option value="year" {{ request()->input('sort_by') == 'year' ? 'selected' : '' }}>Year</option>
        <option value="semester" {{ request()->input('sort_by') == 'semester' ? 'selected' : '' }}>Semester</option>
        <option value="school_year" {{ request()->input('sort_by') == 'school_year' ? 'selected' : '' }}>School Year</option>
    </select>

    @if (request()->input('sort_by') == 'month')
        <label for="month">Select Month:</label>
        <select name="month" id="month">
            @foreach (range(1, 12) as $month)
                <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                </option>
            @endforeach
        </select>
        <label for="year">Select Year:</label>
        <select name="year" id="year">
            @for ($year = date('Y'); $year >= 2000; $year--)
                <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>
    @endif

    @if (request()->input('sort_by') == 'year')
        <label for="year">Select Year:</label>
        <select name="year">
            @for ($year = date('Y'); $year >= 2000; $year--)
                <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>
    @endif

    @php
    $semesters = App\Models\Semester::all();
    $schoolYears = App\Models\SchoolYear::all();
@endphp


    @if (request()->input('sort_by') == 'semester')
        <label for="semester_id">Select Semester:</label>
        <select name="semester_id" id="semester_id">
            @foreach ($semesters as $semester)
                <option value="{{ $semester->semester_id }}" {{ request()->input('semester_id') == $semester->semester_id ? 'selected' : '' }}>
                    {{ $semester->semester_name }}
                </option>
            @endforeach
        </select>
    @endif

    @if (request()->input('sort_by') == 'school_year')
        <label for="school_year_id">Select School Year:</label>
        <select name="school_year_id" id="school_year_id">
            @foreach ($schoolYears as $sy)
                <option value="{{ $sy->sy_id }}" {{ request()->input('school_year_id') == $sy->sy_id ? 'selected' : '' }}>
                {{ $sy->sy_name }}
                </option>
            @endforeach
        </select>
    @endif

    <button type="submit" class="sortButton">Sort</button>
</form>

            </div>

            <div class="filter-container">
                <label style="font-weight: bold;" for="filter">Filter by:</label>
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
            @if($excuseSlips->isEmpty())
                <p>No Excuse Slips found.</p>
            @else
                <table class="excuse-slip-table">
                    <thead>
                    <tr>
                        <th>Date Created</th>
                        <!-- <th>Student</th> -->
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
                        <td>{{ $excuseSlip->created_at->format('Y-m-d') }}</td>
                        <!-- <td>{{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</td> -->
                            <td>        @foreach($excuseSlip->courseOfferings as $courseOffering)
                            @if ($courseOffering->teacher)
                                {{ $courseOffering->teacher->first_name }} {{ $courseOffering->teacher->last_name }}
                            @else
                                N/A
                            @endif
                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach</td>

                            <td>   @foreach($excuseSlip->courseOfferings as $courseOffering)
                                {{ $courseOffering->course->course_code }} - {{ $courseOffering->offer_code }}
                                @if (!$loop->last)
                                    <br>
                                @endif
                            @endforeach</td>
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
    @endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const notification = document.querySelector('.notification');
      const notificationContent = document.querySelector('.notification-content');

      notification.addEventListener('click', function() {
        notification.classList.toggle('active');
      });
    });
  </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function filterExcuseSlips(option) {
        var rows = $('.excuse-slip-table tbody tr');

        rows.each(function() {
            var status = $(this).find('td:nth-child(7)').text().trim().toLowerCase();

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
});</script>

<script>
function submitMarkAsRead(event, excuseSlipId) {
    event.preventDefault(); // Prevent the default link behavior

    // Create a form to submit the mark as read request
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ url("excuse_slips/mark_as_read") }}'; // Update this to your route

    // CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);

    // Method spoofing
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    form.appendChild(methodInput);

    // Excuse slip ID
    const excuseSlipInput = document.createElement('input');
    excuseSlipInput.type = 'hidden';
    excuseSlipInput.name = 'excuseSlipId';
    excuseSlipInput.value = excuseSlipId;
    form.appendChild(excuseSlipInput);

    // Append the form to the body and submit
    document.body.appendChild(form);
    form.submit();

    // After marking as read, redirect to the view slip page
    window.location.href = "{{ url('excuse_slips/show') }}/" + excuseSlipId;
}
</script>