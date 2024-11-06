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
                    @if ($offerCodesWithDetails->isEmpty())
                        <p>No course offerings available.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Offer Code</th>
                                    <th>Course Code</th> <!-- Add course code header -->
                                    <th>Teacher Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offerCodesWithDetails as $offering)
                                    <tr>
                                        <td>{{ $offering['offer_code'] }}</td>
                                        <td>{{ $offering['course_code'] }}</td> <!-- Display course code -->
                                        <td>{{ $offering['teacher_name'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <!-- <p><strong>Date:</strong> {{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</p> -->
                <p><strong>Reason:</strong> {{ $excuseSlip->reason }}</p>


                <h2>File Attachments</h2>
<div id="supporting_documents_container">
    <div class="form-group">
        <label for="supporting_document">Supporting Documents: </label>
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
    </div>


        



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

 @endif 


@if(auth()->user()->role_id == 4)
@if($excuseSlip->status->status_id == 1 || $excuseSlip->status->status_id == 3)

            <div>
                <form action="{{ route('excuse.approve', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="text-align: right;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="approve button">
                            Send to Dean
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
                @endif

                @if(auth()->user()->role_id == 5)
                @if($excuseSlip->status->status_id == 2)

                
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
                @endif


            @if(auth()->user()->role_id == 2)
            <!-- teacher -->

            @if($excuseSlip->status->status_id == 4 || $excuseSlip->status->status_id == 3)
)
            <form action="{{ route('excuse.approveteacher', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="text-align: right;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-approved" style=" margin-top: 5vw;">Noted</button>
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
                <li style="color: orange;font-weight: bold;" >Pending for Approval</li>
                <li style="color: #26d187;font-weight: bold;">Sent to {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>

            </ul>
    @endif
        </div>
        

      

        


    </div>
</div>

</body>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function() {
    var submitFeedbackButton = document.getElementById("submitFeedbackButton");
    var sendToDeanButton = document.getElementById("sendToDeanButton");

    // Function to trigger both buttons
    function triggerBothButtons() {
        submitFeedbackButton.click(); // Simulate click on the first button
        sendToDeanButton.click(); // Simulate click on the second button
    }

    // Event listener for the first button
    submitFeedbackButton.addEventListener("click", function() {
        // Your code for submitting feedback
        console.log("Submitting feedback...");
    });

    // Event listener for the second button
    sendToDeanButton.addEventListener("click", function() {
        // Your code for sending to Dean
        console.log("Sending to Dean...");
    });

    // Event listener to trigger both buttons when any one of them is clicked
    submitFeedbackButton.addEventListener("click", triggerBothButtons);
    sendToDeanButton.addEventListener("click", triggerBothButtons);
});
</script>