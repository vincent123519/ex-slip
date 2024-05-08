@extends('components.dean')
@section('content')
    <div class="dean-details-container">
    <div class="logosc"></div>
        <h1>Absence Request</h1>
        <hr>
        <!-- <a href="" class="create-slip-button"> Number of Excuse slip</a> -->
        <h2>Total Excuse Slips: {{ count($excuseSlips) }}
</h2>
        @if(count($excuseSlips) > 0)
                <table class="excuse-slip-table">
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
                                <td>{{ $excuseSlip->student->first_name}} {{ $excuseSlip->student->last_name}}</td>
                                <td>{{ $excuseSlip->Course->course_code}} - {{ $excuseSlip->Course->offer_code}}</td>
                                <td>{{ $excuseSlip->teacher->first_name}} {{ $excuseSlip->teacher->Last_name}}</td>
                                <td>{{ $excuseSlip->status->status_name }}</td>
                                <td>{{ $excuseSlip->start_date->format('m-d-Y') }} - {{ $excuseSlip->end_date->format('m-d-Y') }}</td>
                                <td> {{ $excuseSlip->start_date->format('l') }} - {{ $excuseSlip->end_date->format('l') }}
                                ({{ $excuseSlip->start_date->diffInDays($excuseSlip->end_date) }} days)</td>
                                <td width="500">
                                <form action="{{ route('excuse.approvedean', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
    <!-- @csrf
    @method('PUT')
    <button type="submit" class="btn btn-approved">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
        </svg> APPROVE
    </button>
</form>

<form action="{{ route('excuse.reject', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
    @csrf
    @method('PUT')
    <button type="submit" class="btn-reject">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
        </svg> REJECT
    </button>
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
    </div>

    <footer>
            <div class="notification">
            <span>notification</span>
            <div class="notification-content">
            @php
            $unreadExcuseSlips = $unreadExcuseSlips->sortByDesc('updated_at');
            @endphp
            @if ($unreadExcuseSlips->count() > 0)
            
            @foreach ($unreadExcuseSlips as $unreadExcuseSlip)
    <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $unreadExcuseSlip->excuse_slip_id]) }}" class="view-button">
        <p>
            <b>{{ $unreadExcuseSlip->counselor->first_name }} {{ $unreadExcuseSlip->created_at }},{{ $unreadExcuseSlip->counselor->last_name }}</b>
            approved <b>{{ $unreadExcuseSlip->student->first_name }} {{ $unreadExcuseSlip->student->last_name }}</b>
        </p>
        <p>pending for dean approval.. {{ $unreadExcuseSlip->updated_at->diffForHumans() }}</p>
        @if ($unreadExcuseSlip->read_by_dean == 1)
            <span style="color: green;">(Seen)</span>
        @elseif($unreadExcuseSlip->read_by_dean == 0)
            <span style="color: red;">(Not Seen)</span>
        @endif

        <form action="{{ route('excuse_slips.markAsReadByDean', ['excuseSlipId' => $unreadExcuseSlip->excuse_slip_id]) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit">Mark as Read</button>
        </form>
        <hr>
    @endforeach
    </ul>
@else
    <p>No unread excuse slips.</p>
@endif
            
        </div>
    </div>
  </footer>
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