@extends('components.teacher')
@section('content')
<div class="teacher-details-container">
    <!-- <div class="logosc"></div> -->
    <h1 style="margin-left: 31vw;">Absence Request</h1>
    <div class="notifContainer">
        <div class="notification">
            <i id="bell" class="fas fa-solid fa-bell fa-2x"></i>
            <div class="notification-content">
                @php
                $unreadExcuseSlips = $unreadExcuseSlips->sortByDesc('updated_at');
                @endphp
                @if ($unreadExcuseSlips->count() > 0)
                
                @foreach ($unreadExcuseSlips as $unreadExcuseSlip)
                <div>
                    <p>
                        <b>{{ $unreadExcuseSlip->dean->first_name }} {{ $unreadExcuseSlip->created_at }},{{ $unreadExcuseSlip->dean->last_name }}</b>
                        approved <b>{{ $unreadExcuseSlip->student->first_name }} {{ $unreadExcuseSlip->student->last_name }}</b>
                        excuse slip
                    </p>
                    <p>pending for Teacher's approval.. 
                        @if ($unreadExcuseSlip->read_by_teacher == 1)
                        <span style="color: green;">(Seen)</span>
                        @elseif($unreadExcuseSlip->read_by_teacher == 0)
                        <span style="color: red;">(Not Seen)</span>
                        <form action="{{ route('excuse_slips.markAsReadByTeacher', ['excuseSlipId' => $unreadExcuseSlip->excuse_slip_id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit">Mark as Read</button>
                        </form>
                        @endif
                    </p>
                    <hr>
                </div>
                @endforeach
                @else
                <p>No unread excuse slips.</p>
                @endif       
            </div>
        </div>
        <hr>
    </div>
    <div>
        <h2>Excuse Slips</h2>
        <input type="text" id="searchInput" placeholder="Search by student name, status, or course name">
        <div class="filter-container">
            <label for="filter" style="font-weight: bold;">Filter by:</label>
            <select id="filter" name="filter">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="approved_by_dean">Approved by Dean</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        @if($allExcuseSlips->count() > 0)
        <table class="excuse-slip-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Status</th>
                    <th>Course Name</th>
                    <th>Date</th>
                    <th>Duration day</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allExcuseSlips as $excuseSlip)
                <tr>
                    <td>{{ $excuseSlip->student->first_name}} {{ $excuseSlip->student->last_name}}</td>
                    <td>{{ $excuseSlip->status->status_name }}</td>
                    <td>{{ $excuseSlip->course->course_code }} - {{ $excuseSlip->course->offer_code }}</td>
                    <td>{{ $excuseSlip->start_date->format('m-d-Y') }} - {{ $excuseSlip->end_date->format('m-d-Y') }}</td>
                    <td>{{ $excuseSlip->start_date->format('l') }} - {{ $excuseSlip->end_date->format('l') }}
                        ({{ $excuseSlip->start_date->diffInDays($excuseSlip->end_date) }} days)</td>
                    <td width="300">
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
</div>
@endsection


<style>
  
</style>
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
    $('#filter').change(function() {
        var selectedOption = $(this).val();
        filterExcuseSlips(selectedOption);
    });

    function filterExcuseSlips(option) {
        var rows = $('.excuse-slip-table tbody tr');

        rows.each(function() {
            var status = $(this).find('td:nth-child(2)').text().toLowerCase();

            if (option === 'all' || status === option || (option === 'approved_by_dean' && status === 'approved by dean')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
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
      const courseName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

      if (studentName.includes(searchQuery) || status.includes(searchQuery) || courseName.includes(searchQuery)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  searchInput.addEventListener('input', filterRows);
});
</script>