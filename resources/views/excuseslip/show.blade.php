<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Slip</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8f9fa;
        }

        .slip-view-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
        }

        .slip-view-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin: 20px auto;
            border: 2px solid #28a745; /* Green border color */
        }

        .slip-view-header {
            text-align: center;
            padding: 20px;
        }

        .slip-view-body {
            margin-top: 20px;
        }

        .slip-view-container .form-group {
            margin-bottom: 20px;
        }

        .slip-view-container label {
            display: block;
            font-weight: bold;
        }

        .slip-view-container input[type="text"],
        .slip-view-container textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .slip-view-container input[type="file"] {
            padding: 10px;
        }

        .slip-view-container button[type="submit"] {
            padding: 15px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .slip-view-container button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Add custom styles for alignment */
        .excuse-slip p {
            margin-bottom: 5px;
        }

        .name-container p{
            display: inline-block;
            margin-right: 10px;
        }
        /* Add custom styles for alignment */
        .teacher-container p {
            display: inline-block;
            margin-right: 10px; /* Adjust the margin to control the space between Teacher and Subject */
        }
        .excuse-slip p {
                    margin-bottom: 0px;
                }

            
                

        .teacher-container p {
                    display: inline-block;
                    margin-right: 100px; /* Adjust the margin to control the space between Teacher and Subject */
                }

    </style>
</head>

@extends('components.stud')

@section('content')

<body>

<div class="slip-view-container">
    <div class="slip-view-card">
        <div class="slip-view-header">
            <h1>View Slip</h1>
        </div>
        <p><strong>Excuse slip ID:</strong> {{ $excuseSlip->excuse_slip_id }}</p>

        <div class="slip-view-body">
            <div class="excuse-slip">
                <div class="name-container">
                    <p><strong>Student:</strong> {{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</p>
                    <p><strong>Degree Yr Level:</strong>{{ $excuseSlip->student->year_level}} - {{ $excuseSlip->student->degree->degree_name}} </p>
                </div>
                <div class="teacher-container">
                <p><strong>Teacher:</strong> {{ $excuseSlip->teacher->first_name }} {{ $excuseSlip->teacher->last_name }}</p>
                <p><strong>Subject:</strong> {{ $excuseSlip->course->course_name}} </p>


                </div>
                <p><strong>Date:</strong> {{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</p>
                <p><strong>Reason:</strong> {{ $excuseSlip->reason }}</p>


                <h2>File Attachment</h2>
                @if ($excuseSlip->supportingDocuments->isEmpty())
                    <p>No supporting documents available.</p>
                @else
                    <ul>
                        @foreach ($excuseSlip->supportingDocuments as $document)
                            <li>
                        <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank">
                            {{ $document->document_path }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
                

            @if ($excuseSlip->status->status_id == 2)
            <ul>
                <li>Noted by {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>
                <li>To be approved by Dean</li>
                <li>To be approved by Teacher</li>
            </ul>
        @elseif ($excuseSlip->status->status_id == 4)
            <ul>
            <li>Noted by {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>
                <li>Approved by {{$excuseSlip->dean->first_name}} {{$excuseSlip->dean->last_name}}</li>
                <li>To be approved by Teacher</li>
            </ul>
        @elseif ($excuseSlip->status->status_id == 5)
            <ul>
                <li>Approved by Teacher</li>
                <li>Approved by Dean</li>
                <li>Approved by Counselor</li>
            </ul>
        @elseif ($excuseSlip->status->status_id == 1)
            <ul>
                <li>Pending for Approval</li>
                <li>Sent to Counselor</li>

            </ul>
@endif

@if(auth()->user()->role_id == 4)

<!-- counselor -->
 @if ($deanFeedback)
     <p><strong>Dean Feedback:</strong> {{ $deanFeedback->remarks }}</p>
 @else
     <p>No Dean feedback available.</p>
 @endif

 @if ($teacherFeedback)
     <p><strong>Teacher Feedback:</strong> {{ $teacherFeedback->remarks }}</p>
 @else
     <p>No teacher feedback available.</p>
 @endif
 @endif

 @if(auth()->user()->role_id == 5)

<!-- dean -->
 @if ($counselorFeedback)
     <p><strong>Counselor Feedback:</strong> {{ $counselorFeedback->remarks }}</p>
 @else
     <p>No Counselor feedback available.</p>
 @endif

 @if ($teacherFeedback)
     <p><strong>Teacher Feedback:</strong> {{ $teacherFeedback->remarks }}</p>
 @else
     <p>No teacher feedback available.</p>
 @endif
 @endif


                @if(auth()->user()->role_id == 4)
                <form action="{{ route('excuse.approve', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="text-align: right;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="approve button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-check" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
            </svg>
            Note
        </button>
                    </form>
                <!-- Add this to your view where counselors can provide feedback -->
                <form action="{{ route('counselor.feedback.store', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST">
                    @csrf
                    <label for="feedback_remarks">Feedback Remarks:</label>
                    <textarea name="feedback_remarks" id="feedback_remarks" rows="1" cols="50"></textarea>
                    <button type="submit">Submit Feedback</button>
                </form>

                @endif

                @if(auth()->user()->role_id == 5)
                
                <!-- <form action="{{ route('excuse.approvedean', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-approved">Approve</button>
                                </form>

                <form action="{{ route('excuse.reject', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-reject">Reject</button>
                                </form> -->
    <!-- Form for Dean Feedback -->
                <form action="{{ route('dean.feedback.store', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST">
                    @csrf
                    <label for="feedback_remarks">Feedback Remarks:</label>
                    <textarea name="feedback_remarks" id="feedback_remarks" rows="1" cols="50"></textarea>
                    <button type="submit">Submit Feedback</button>
                </form>
            @endif

            @if(auth()->user()->role_id == 2)

            @if($excuseSlip->status->status_id == 4)
            <form action="{{ route('excuse.approveteacher', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="text-align: right;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-approved">Approve</button>
            </form>
            <form action="{{ route('teacher.feedback.store', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST">
                @csrf
                <label for="feedback_remarks">Feedback Remarks:</label>
                <textarea name="feedback_remarks" id="feedback_remarks" rows="1" cols="50"></textarea>
                <button type="submit">Submit Feedback</button>
            </form>

            @endif
        @endif


                
            </div>
        </div>
     

        @if(auth()->user()->role_id == 3)

        @if ($counselorFeedback)
            <p><strong>Counselor Feedback:</strong> {{ $counselorFeedback->remarks }}</p>
        @else
            <p>No counselor feedback available.</p>
        @endif
        @if ($deanFeedback)
            <p><strong>Dean Feedback:</strong> {{ $deanFeedback->remarks }}</p>
        @else
            <p>No Dean feedback available.</p>
        @endif

        @if ($teacherFeedback)
            <p><strong>Teacher Feedback:</strong> {{ $teacherFeedback->remarks }}</p>
        @else
            <p>No teacher feedback available.</p>
        @endif
        @endif

        @if(auth()->user()->role_id == 4)

        @if ($counselorFeedback)
            <p><strong>Feedback:</strong> {{ $counselorFeedback->remarks }}</p>
        @else
            <p>No feedback available.</p>
        @endif
        @endif

          @if(auth()->user()->role_id == 5)

        @if ($deanFeedback)
            <p><strong>Feedback:</strong> {{ $deanFeedback->remarks }}</p>
        @else
            <p>No feedback available.</p>
        @endif
        @endif
        
        @if(auth()->user()->role_id == 2)
        @if ($teacherFeedback)
            <p><strong>Teacher Feedback:</strong> {{ $teacherFeedback->remarks }}</p>
        @else
            <p>No teacher feedback available.</p>
        @endif

        @endif

      

        


    </div>
</div>

</body>
@endsection
<style>
    .slip-view-container button[type="submit"] {
        background-color: #28a745;
        height: 50px; /* Set the height you desire */
        width: 10%; /* Full width of the container */
        border: none;
        border-radius: 5px;
        color: white;
    }
    .slip-view-container button[type="submit"]:hover {
    background-color: #218838; /* Change the background color on hover */
    cursor: pointer; /* Add a pointer cursor on hover */
}
</style>