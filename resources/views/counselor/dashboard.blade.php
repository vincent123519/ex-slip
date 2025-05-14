@extends('components.counselor')

@section('content')

    <div class="excuse-container">
        <!-- <div class="logosc"></div> -->

            <h1>Absence Request</h1>
            <p style="font-weight: bold; float:left; font-size: 1vw;">Total Excuse Slips: {{ $excuseSlips->count() }}</p>
            <div class="notifContainer">
                <div class="notification">
                    <i id="bell" class=" fas fa-solid fa-bell fa-2x"></i>
                    <span></span>
                    <div class="notification-content">
    @php
        // Filter to exclude excuse slips that have been read by the counselor
        $unreadExcuseSlips = $latestExcuseSlips->where('read_by_counselor', false);
    @endphp

    @foreach ($unreadExcuseSlips as $latestExcuseSlip)
        <form method="POST" action="{{ route('excuse_slips.mark_as_read', ['excuseSlipId' => $latestExcuseSlip->excuse_slip_id]) }}" class="notification-form">
            @csrf
            @method('PUT')

            <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $latestExcuseSlip->excuse_slip_id]) }}"
               onclick="submitMarkAsRead(event, this)"
               class="notification-link">
                <h4 style="display: inline;">
                    {{ $latestExcuseSlip->student->first_name }} created an excuse slip {{ $latestExcuseSlip->created_at }}
                    @if ($latestExcuseSlip->read_by_counselor)
                        <span style="color: green;">(Seen)</span>
                    @else
                        <span style="color: red;">(Not Seen)</span>
                    @endif
                </h4>
            </a>

            <!-- Eye Icon -->
            <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $latestExcuseSlip->excuse_slip_id]) }}"
               onclick="submitMarkAsRead(event, this)"
               class="view-button" style="margin-left: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 
                    1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 
                    5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 
                    1.12-1.465 1.755C11.879 11.332 10.119 12.5 
                    8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 
                    2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 
                    7 0 3.5 3.5 0 0 1-7 0"/>
                </svg>
            </a>

            <hr style="color: #55825f;">
        </form>
    @endforeach

    @if ($unreadExcuseSlips->isEmpty())
        <p>No unread excuse slips.</p>
    @endif
</div>
                </div>
            </div>
            <a class="expo"href="{{ $exportUrl }}">Download Records</a>
            <hr>

            <div class="filterSection">



            <form action="{{ route('counselor.dashboard') }}" method="GET">
                <label for="sort_by" style="font-weight: bold;">Sort By:</label>
                <select class="sorting" name="sort_by" id="sort_by">
                    @foreach (['today' => 'Today', 'weekly' => 'Last 7 Days', 'month' => 'Month', 'year' => 'Year', 'semester' => 'Semester', 'school_year' => 'School Year'] as $value => $label)
                        <option value="{{ $value }}" {{ request()->input('sort_by') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                @if (request()->input('sort_by') == 'month')
                    <select name="month">
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                            </option>
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
        <input type="text" id="searchInput" placeholder="Search by student name">

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
    @if ($excuseSlip->status->status_id == 1 || $excuseSlip->status->status_id == 3)
        <form action="{{ route('excuse.approve', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="btn-approve">Send to Dean</button>
        </form>
    @endif

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
    function submitMarkAsRead(event, link) {
        event.preventDefault(); // Stop the link from navigating immediately
        const form = link.closest('form');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PUT'
            })
        }).then(response => {
            if (response.ok) {
                window.location.href = link.href; // Now go to the show page
            } else {
                alert('Failed to mark as read.');
            }
        }).catch(error => {
            console.error(error);
            alert('Something went wrong.');
        });
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const rows = Array.from(document.querySelectorAll('.excuse-slip-table tbody tr'));

  function filterRows() {
    const searchQuery = searchInput.value.toLowerCase();

    rows.forEach(row => {
      const studentName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

      if (studentName.includes(searchQuery)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  searchInput.addEventListener('input', filterRows);
});
</script>

<style>.btn-approve {
    padding: 6px 10px;
    background-color: #155724;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 8px;
    transition: background-color 0.2s;
}

.btn-approve:hover {
    background-color: darkgreen;
}

.btn-view {
    padding: 6px 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    text-decoration: none;
}

.btn-view:hover {
    background-color: #0056b3;
}
</style>