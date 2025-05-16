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

@extends('components.excuse')
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
                    <table>
    <thead>
        <tr>
            <th>Offer Code</th>
            <th>Course Code</th>
            <th>Teacher Name</th>
            <th>
                @if(auth()->user()->role_id == 2) <!-- Check if the user is a teacher -->
                    Actions
                @else
                    Status
                @endif
            </th>
            <th>Feedback</th>
        </tr>
    </thead>
    <tbody>
        @php
            // Get the teacher ID for the authenticated user
            $teacherId = auth()->user()->role_id == 2 ? auth()->user()->teacher->teacher_id : null;
            $excuseSlipId = $excuseSlip->excuse_slip_id; // Use the actual excuse slip ID passed from the controller

            // Fetch offer codes related to the teacher if the user is a teacher
            $offerCodesWithDetails = auth()->user()->role_id == 2
                ? DB::table('course_excuse_slip as ces')
                    ->join('course_offerings as co', 'ces.offer_code', '=', 'co.offer_code')
                    ->join('teachers as t', 'co.teacher_id', '=', 't.teacher_id') // Join to get teacher info
                    ->select('ces.offer_code', 'co.course_code', 't.first_name', 't.last_name', 'ces.is_remark_by_teacher')
                    ->where('co.teacher_id', $teacherId)
                    ->where('ces.excuse_slip_id', $excuseSlipId)
                    ->distinct()
                    ->get()
                : DB::table('course_excuse_slip as ces')
                    ->join('course_offerings as co', 'ces.offer_code', '=', 'co.offer_code')
                    ->join('teachers as t', 'co.teacher_id', '=', 't.teacher_id') // Join to get teacher info
                    ->select('ces.offer_code', 'co.course_code', 't.first_name', 't.last_name', 'ces.is_remark_by_teacher')
                    ->where('ces.excuse_slip_id', $excuseSlipId)
                    ->distinct()
                    ->get();
        @endphp

        @if($offerCodesWithDetails->isEmpty())
            <tr>
                <td colspan="5">No relevant offer codes found.</td>
            </tr>
        @else
            @foreach($offerCodesWithDetails as $details)
                <tr>
                    <td>{{ $details->offer_code }}</td>
                    <td>{{ $details->course_code }}</td>
                    <td>{{ $details->first_name }} {{ $details->last_name }}</td> <!-- Display teacher's full name -->
                    <td>
                        @if(auth()->user()->role_id == 2) <!-- Teacher View -->
                            @if($details->is_remark_by_teacher != 1)
                                <form action="{{ route('excuse.approveteacher', ['id' => $excuseSlipId]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Sign Slip</button>
                                </form>
                            @else
                                <span class="text-muted">Already approved</span>
                            @endif
                        @else <!-- Student View -->
                            <span class="text-muted">
                                @if($details->is_remark_by_teacher == 1)
                                    Already approved
                                @else
                                    Not approved
                                @endif
                            </span>
                        @endif
                    </td>
                    <td>
    @php
        // Retrieve feedback for the current offer code
        $feedback = DB::table('course_excuse_slip')
            ->where('excuse_slip_id', $excuseSlipId)
            ->where('offer_code', $details->offer_code) // This is fine as is
            ->value('teacher_feedback');
    @endphp

    <p> {{ $feedback ? $feedback : 'No feedback provided' }}</p>

    @if(auth()->user()->role_id == 2) <!-- Teacher View -->
        @if(!$feedback) <!-- Only show the feedback form if there is no feedback -->
            @php
                // Check if the teacher has an association with the offer code
                $courseOffering = $excuseSlip->courseOfferings()
                    ->where('course_offerings.offer_code', $details->offer_code) // Specify the table for offer_code
                    ->where('course_offerings.teacher_id', auth()->user()->teacher->teacher_id) // Specify the table for teacher_id
                    ->first();
            @endphp

            @if($courseOffering) <!-- Only show the feedback form if associated -->
                <form action="{{ route('teacher.feedback.store', ['id' => $excuseSlipId]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="offer_code" value="{{ $details->offer_code }}"> <!-- Hidden field for offer_code -->
                    <label for="feedback_remarks">Feedback Remarks:</label>
                    <textarea name="feedback_remarks" id="feedback_remarks" rows="1" cols="50" required></textarea>
                    <button type="submit">Submit Feedback</button>
                </form>
            @else
                <span class="text-muted">You are not authorized to provide feedback for this course offering.</span>
            @endif
        @endif
    @endif
</td>
                </tr>
            @endforeach
        @endif
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
                                    <button type="submit" class="btn-approved" style=" margin-top: 0vw; background-color: green; color: yellow;margin-left: 45vw;">APPROVE</button>                              </form>

                <form action="{{ route('excuse.reject', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-reject" style="background: red;border: green;border-style: solid;">REJECT</button>                                </form>

                <form action="{{ route('dean.feedback.store', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST">
                    @csrf
                    <label for="feedback_remarks" style="margin-top: -0.4vw;">Feedback Remarks:</label>
                    <textarea name="feedback_remarks" id="feedback_remarks" rows="1" cols="50"></textarea>
                    <button type="submit" style="margin-top: -0.4vw;">Submit Feedback</button>
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
        


        <hr>

        <div class="status">
        @if ($excuseSlip->status->status_id == 2)
            <ul>
            <li style="color: #26d187;font-weight: bold;">Noted by {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>
            <li style="color: orange;font-weight: bold;">To be approved by {{$excuseSlip->dean->first_name}} {{$excuseSlip->dean->last_name}}</li>
            </ul>
        @elseif ($excuseSlip->status->status_id == 4)
            <ul>
            <li style="color: #26d187;font-weight: bold;">Noted by {{$excuseSlip->counselor->first_name}} {{$excuseSlip->counselor->last_name}}</li>
            <li  style="color: #26d187;font-weight: bold;">Approved by {{$excuseSlip->dean->first_name}} {{$excuseSlip->dean->last_name}}</li>
            <li style="color: orange;font-weight: bold;">To be approved by 
                @foreach($excuseSlip->courseOfferings as $courseOffering)
                            @if ($courseOffering->teacher)
                                {{ $courseOffering->teacher->first_name }} {{ $courseOffering->teacher->last_name }}
                            @else
                                N/A
                            @endif
                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach</li>
            </ul>
        @elseif ($excuseSlip->status->status_id == 5)
            <ul>
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

<style>
   <style>
    .teacher-container {
        padding: 20px; 
        border-radius: 8px; 
        background-color: #f8f9fa; 
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
    }

    table {
        margin-top: 20px; 
        width: 100%; 
        border-collapse: separate; 
        border-spacing: 0 10px; 
    }

    th, td {
        padding: 20px; 
        text-align: center;
        vertical-align: middle;
    }

    th {
        background-color: rgba(13, 62, 32, 0.98);;
        color: white; 
    }

    @media (max-width: 576px) {
        .teacher-container {
            padding: 10px;
        }

        th, td {
            padding: 10px; 
        }
    }
</style>