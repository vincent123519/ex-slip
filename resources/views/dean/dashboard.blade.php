@extends('components.dean')
@section('content')
    <div class="dean-details-container">
        <h1 style="margin-left: 605px;">Absence Request</h1>
        <div class="notifContainer">
    <div class="notification" id="notification">
        <i id="bell" class="fas fa-solid fa-bell fa-2x"></i>
        <div class="notification-content">
        @if ($unreadExcuseSlips->isNotEmpty())
    @foreach ($unreadExcuseSlips->sortByDesc('updated_at') as $unreadExcuseSlip)
        <form method="POST"
              action="{{ route('excuse_slips.markAsReadByDean', ['excuseSlipId' => $unreadExcuseSlip->excuse_slip_id]) }}"
              class="notification-form">
            @csrf
            @method('PUT')

            <!-- Text Link -->
            <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $unreadExcuseSlip->excuse_slip_id]) }}"
               onclick="submitDeanMarkAsRead(event, this)"
               class="notification-link">
                <p>
                    <b>{{ $unreadExcuseSlip->counselor->first_name }} {{ $unreadExcuseSlip->counselor->last_name }}</b>
                    approved <b>{{ $unreadExcuseSlip->student->first_name }} {{ $unreadExcuseSlip->student->last_name }}</b>
                </p>
                <p>Pending for dean approval.. {{ $unreadExcuseSlip->updated_at->diffForHumans() }}</p>
                <span style="color: {{ $unreadExcuseSlip->read_by_dean ? 'green' : 'red' }};">
                    ({{ $unreadExcuseSlip->read_by_dean ? 'Seen' : 'Not Seen' }})
                </span>
            </a>

            <!-- Eye Icon -->
            <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $unreadExcuseSlip->excuse_slip_id]) }}"
               onclick="submitDeanMarkAsRead(event, this)"
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

            <hr>
        </form>
    @endforeach
@else
    <p>No unread excuse slips.</p>
@endif

        </div>
    </div>
    <hr>
</div>
    
        <h2>Total Excuse Slips: <span id="total-count">{{ count($excuseSlips) }}</span></h2>
        @if(count($excuseSlips) > 0)
        <div class="filter-container">
                    <label for="filter" style="font-weight: bold;">Filter by:</label>
                    <select id="filter" name="filter">
                        <option value="pending">Pending</option>
                        <option value="approved_by_counselor">Approved by Counselor</option>
                        <option value="rejected">Rejected</option>
                        <option value="approved_by_dean">Approved by Dean</option>
                        <option value="approved_by_teacher">Approved by Teacher</option>
                        <option value="all">All</option>

                    </select>
                </div>


            
        <table class="excuse-slip-table">
            <br>
        <input type="text" id="searchInput" placeholder="seach by">

            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Course Name</th>
                    <th>Teacher's Name</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Duration day</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    @foreach($excuseSlips as $excuseSlip)
    <tr>
        <td>{{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</td>
        
        <td>
            @foreach($excuseSlip->courseOfferings as $courseOffering)
                {{ $courseOffering->course->course_code }} - {{ $courseOffering->offer_code }}
                @if (!$loop->last)<br>@endif
            @endforeach
        </td>

        <td>
            @foreach($excuseSlip->courseOfferings as $courseOffering)
                @if ($courseOffering->teacher)
                    {{ $courseOffering->teacher->first_name }} {{ $courseOffering->teacher->last_name }}
                @else
                    N/A
                @endif
                @if (!$loop->last)<br>@endif
            @endforeach
        </td>

        <td>{{ $excuseSlip->status->status_name }}</td>
        <td>{{ $excuseSlip->start_date->format('m-d-Y') }} - {{ $excuseSlip->end_date->format('m-d-Y') }}</td>
        <td>{{ $excuseSlip->start_date->format('l') }} - {{ $excuseSlip->end_date->format('l') }}
            ({{ $excuseSlip->start_date->diffInDays($excuseSlip->end_date) }} days)
        </td>

        <td>
    @if($excuseSlip->status->status_id == 2)
        <!-- Approve Button -->
        <form action="{{ route('excuse.approvedean', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="btn-approve">Approve</button>
        </form>
    @endif

    <!-- Always show View Button -->
    <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $excuseSlip->excuse_slip_id]) }}" class="view-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8
                     M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5
                     8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83
                     1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457
                     A13 13 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5
                     M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
        </svg>
    </a>
</td>

    </tr>
    @endforeach
</tbody>
        </table>
        @else
        <p>No Excuse Slips found.</p>
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
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function() {
    function filterExcuseSlips(option) {
        var rows = $('.excuse-slip-table tbody tr');
        var visibleCount = 0; 

        rows.each(function() {
            var status = $(this).find('td:nth-child(4)').text().trim().toLowerCase();
            var isVisible = false; // Track if the row should be visible

            if (option === 'all') {
                isVisible = true;
            } else if (option === 'pending' && status.includes('pending')) {
                isVisible = true;
            } else if (option === 'approved_by_counselor' && status.includes('approved by counselor')) {
                isVisible = true;
            } else if (option === 'rejected' && status.includes('rejected')) {
                isVisible = true;
            } else if (option === 'approved_by_dean' && status.includes('approved by dean')) {
                isVisible = true;
            } else if (option === 'approved_by_teacher' && status.includes('approved by teacher')) {
                isVisible = true;
            }

            if (isVisible) {
                $(this).show();
                visibleCount++; // Increment the counter if the row is visible
            } else {
                $(this).hide();
            }
        });

        // Update the total count in the HTML
        $('#total-count').text(visibleCount);
    }

    $('#filter').change(function() {
        var selectedOption = $(this).val();
        filterExcuseSlips(selectedOption);
    });

    // Initial count update on page load
    filterExcuseSlips('all');
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const rows = Array.from(document.querySelectorAll('.excuse-slip-table tbody tr'));

  function filterRows() {
    const searchQuery = searchInput.value.toLowerCase();

    rows.forEach(row => {
      const studentName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
      const teacherName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

      if (studentName.includes(searchQuery) || teacherName.includes(searchQuery)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  searchInput.addEventListener('input', filterRows);
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const notification = document.querySelector('.notification');
    
    notification.addEventListener('click', function() {
        this.classList.toggle('active'); // Toggle the 'active' class
    });
});
</script>

<script>
    function submitDeanMarkAsRead(event, link) {
        event.preventDefault(); // Prevent the default <a> behavior
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
                window.location.href = link.href;
            } else {
                alert('Failed to mark as read.');
            }
        }).catch(error => {
            console.error(error);
            alert('Something went wrong.');
        });
    }
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



.btn-view:hover {
    background-color: #0056b3;
}
</style>