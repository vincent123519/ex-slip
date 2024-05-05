@extends('components.teacher')
@section('content')
    <div class="teacher-details-container">
    <div class="logosc"></div>
        <h1>Absence Request</h1>
        <hr>
        <!-- <a href="" class="create-slip-button"> Number of Excuse slip</a> -->
        <h2>Excuse Slips</h2>
            @if($excuseSlips->count() > 0)
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
                        @foreach($excuseSlips as $excuseSlip)
                            <tr>
                                <td>{{ $excuseSlip->student->first_name}} {{ $excuseSlip->student->last_name}}</td>
                                <td>{{ $excuseSlip->status->status_name }}</td>
                                <td>{{ $excuseSlip->course->course_code }} - {{ $excuseSlip->course->offer_code }} </td>
                                <td>{{ $excuseSlip->start_date->format('m-d-Y') }} - {{ $excuseSlip->end_date->format('m-d-Y') }}</td>
                                <td> {{ $excuseSlip->start_date->format('l') }} - {{ $excuseSlip->end_date->format('l') }}
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
        @endforeach
        </ul>
    @else
        <p>No unread excuse slips.</p>
    @endif
                

                
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
    .teacher-details-container {
    background-color: #f8f9fa;
    padding: 20px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    width: 60%;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Montserrat', sans-serif;
}


    h1 {
       margin-top: 75px;
       margin-left: 418px;
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
    .excuse-slip-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .excuse-slip-table th,
    .excuse-slip-table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    .excuse-slip-table th {
        background-color: #f2f2f2;
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
      const notification = document.querySelector('.notification');
      const notificationContent = document.querySelector('.notification-content');

      notification.addEventListener('click', function() {
        notification.classList.toggle('active');
      });
    });
  </script>