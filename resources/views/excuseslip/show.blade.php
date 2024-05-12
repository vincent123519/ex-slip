<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/apps.css'])
    <title>View Slip</title>
    <style>
        
      
    </style>
</head>

@extends('components.stud')
@section('content')

<body>

<div class="slip-view-container">
    <div class="slip-view-card">
        <div class="slip-view-header">
        <div class="logosp"></div>         
        <h1 class="h1s"  >View Slip</h1>
        <hr>
        </div>
        <!-- <p><strong>Excuse slip ID:</strong> {{ $excuseSlip->excuse_slip_id }}</p> -->

        <div class="slip-view-body">
            <div class="excuse-slip">
                <div class="dateContainer">
                    <p><strong>Date:</strong> {{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</p>
                </div>
                <div class="name-container">
                    <p><strong>Student:</strong> {{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</p>
                    <p><strong style=" margin-left: 145px;">Degree & Year Level: </strong> {{ $excuseSlip->student->year_level}} - {{ $excuseSlip->student->degree->degree_name}} </p>
                </div>
                <div class="teacher-container">
                    <p><strong>Teacher:</strong> {{ $excuseSlip->teacher->first_name }} {{ $excuseSlip->teacher->last_name }}</p>
                    <strong style="margin-left: 34px;">Subject:</strong> {{ $excuseSlip->course->course_code}} - {{ $excuseSlip->course->offer_code}}</p>
                </div>
                <!-- <p><strong>Date:</strong> {{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</p> -->
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
                

        

@if(auth()->user()->role_id == 4)

<!-- counselor -->
 @if ($deanFeedback)
    <div class="feedback-container">
        <p><strong>Dean Feedback:</strong> {{ $deanFeedback->remarks }}</p>
    </div>
 @else
    <div class="feedback-container">
        <p>No Dean feedback available.</p>
    </div>
 @endif

 @if ($teacherFeedback)
    <div class="feedback-container">
        <p><strong>Teacher Feedback:</strong> {{ $teacherFeedback->remarks }}</p>
    </div>
 @else
    <div class="feedback-container">
        <p>No teacher feedback available.</p>
    </div>
 @endif
 @endif

 @if(auth()->user()->role_id == 5)

<!-- dean -->
 @if ($counselorFeedback)
    <div class="feedback-container">
        <p><strong>Counselor Feedback:</strong> {{ $counselorFeedback->remarks }}</p>
    </div>
 @else
    <div class="feedback-container">
        <p>No Counselor feedback available.</p>
    </div>
 @endif

 @if ($teacherFeedback)
    <div class="feedback-container">
        <p><strong>Teacher Feedback:</strong> {{ $teacherFeedback->remarks }}</p>
    </div>
 @else
    <div class="feedback-container">
        <p>No teacher feedback available.</p>
    </div>
 @endif
 @endif


@if(auth()->user()->role_id == 4)
            <div>
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
                    <label for="feedback_remarks" style=" margin-top: -124px;">Feedback Remarks:</label>
                    <textarea name="feedback_remarks" id="feedback_remarks" rows="1" cols="50"></textarea>
                    <button type="submit" style="margin-top: 0px;">Submit Feedback</button>
                </form>
            </div>
                @endif

                @if(auth()->user()->role_id == 5)
                
                <form action="{{ route('excuse.approvedean', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-approved" style="margin-left: 50vw; margin-top: 0vw; background-color: green; color: yellow;">Approve</button>                              </form>

                <form action="{{ route('excuse.reject', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-reject" style="background: red;border: green;border-style: solid;">Reject</button>                                </form>

                <form action="{{ route('dean.feedback.store', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST">
                    @csrf
                    <label for="feedback_remarks" style="margin-top: -6.4vw;">Feedback Remarks:</label>
                    <textarea name="feedback_remarks" id="feedback_remarks" rows="1" cols="50"></textarea>
                    <button type="submit" style="margin-top: -1vw;">Submit Feedback</button>
                </form>
            @endif

            @if(auth()->user()->role_id == 2)

            @if($excuseSlip->status->status_id == 4)
            <form action="{{ route('excuse.approveteacher', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="text-align: right;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-approved" style=" margin-top: 5vw;">Approve</button>
            </form>
            <form action="{{ route('teacher.feedback.store', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST">
                @csrf
                <label for="feedback_remarks" style="margin-top: -119px;">Feedback Remarks:</label>
                <textarea name="feedback_remarks" id="feedback_remarks" rows="1" cols="50"></textarea>
                <button type="submit" style=" margin-top: -1vw;">Submit Feedback</button>
            </form>

            @endif
            @endif

            </div>
        </div>
     

        @if(auth()->user()->role_id == 3)

        @if ($counselorFeedback)
            <div class="feedback-container">
            <p><strong>Counselor Feedback:</strong> {{ $counselorFeedback->remarks }}</p>
            </div>
        @else
            <div class="feedback-container">
                <p>No counselor feedback available.</p>
            </div>
        @endif
        @if ($deanFeedback)
            <div class="feedback-container">
                <p><strong>Dean Feedback:</strong> {{ $deanFeedback->remarks }}</p>
            </div>
        @else
            <div class="feedback-container">
                <p>No Dean feedback available.</p>
            </div>
        @endif

        @if ($teacherFeedback)
            <div class="feedback-container">
                <p><strong>Teacher Feedback:</strong> {{ $teacherFeedback->remarks }}</p>
            </div>
        @else
            <div class="feedback-container">
                <p>No teacher feedback available.</p>
            </div>
        @endif
        @endif

        @if(auth()->user()->role_id == 4)

        @if ($counselorFeedback)
            <div class="feedback-container">
                <p><strong>Feedback:</strong> {{ $counselorFeedback->remarks }}</p>
            </div>
        @else
            <div class="feedback-container">
                <p>No feedback available.</p>
            </div>
        @endif
        @endif

          @if(auth()->user()->role_id == 5)

        @if ($deanFeedback)
            <div class="feedback-container">
                <p><strong>Feedback:</strong> {{ $deanFeedback->remarks }}</p>
            </div>
        @else
            <div class="feedback-container">
                <p>No feedback available.</p>
            </div>
        @endif
        @endif
        
        @if(auth()->user()->role_id == 2)
        @if ($teacherFeedback)
            <div class="feedback-container">
                <p><strong>Teacher Feedback:</strong> {{ $teacherFeedback->remarks }}</p>
            </div>
        @else
            <div class="feedback-container">
                <p>No teacher feedback available.</p>
            </div>
        @endif

        @endif

        <hr>

        <div class="status">
        @if ($excuseSlip->status->status_id == 2)
            <ul>
            <li style="color: #26d187;font-weight: bold;">Noted by {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>
            <li style="color: orange;font-weight: bold;">To be approved by {{$excuseSlip->dean->first_name}} {{$excuseSlip->dean->last_name}}</li>
            <li style="color: orange;font-weight: bold;">To be approved by {{$excuseSlip->teacher->first_name}} {{$excuseSlip->teacher->last_name}}</li>
            </ul>
        @elseif ($excuseSlip->status->status_id == 4)
            <ul>
            <li style="color: #26d187;font-weight: bold;">Noted by {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>
            <li  style="color: #26d187;font-weight: bold;">Approved by {{$excuseSlip->dean->first_name}} {{$excuseSlip->dean->last_name}}</li>
            <li style="color: orange;font-weight: bold;">To be approved by {{$excuseSlip->teacher->first_name}} {{$excuseSlip->teacher->last_name}}</li>
            </ul>
        @elseif ($excuseSlip->status->status_id == 5)
            <ul>
            <li style="color: green;font-weight: bold;">Approved by {{ $excuseSlip->teacher->first_name }} {{ $excuseSlip->teacher->last_name }}</li>
            <li style="color: green;font-weight: bold;">Approved by {{$excuseSlip->dean->first_name}} {{$excuseSlip->dean->last_name}}</li>
            <li style="color: #26d187;font-weight: bold;">Noted by {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>
            </ul>
        @elseif ($excuseSlip->status->status_id == 1)
            <ul>
                <li>Pending for Approval</li>
                <li style="color: orange;font-weight: bold;">Sent to {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>

            </ul>
    @endif
        </div>
        

      

        


    </div>
</div>

</body>
@endsection
<style>


</style>