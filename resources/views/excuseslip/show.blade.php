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
            height: 60vh;
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

        .name-container {
            display: flex;
            justify-content: space-between;
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
        <div class="slip-view-body">
            <div class="excuse-slip">
                <div class="name-container">
                    <p><strong>Student:</strong> {{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</p>
                    <p><strong>Student ID:</strong> {{ $excuseSlip->student->student_id}} </p>
                    <p><strong>Degree Yr Level:</strong>{{ $excuseSlip->student->year_level}} - {{ $excuseSlip->student->degree->degree_name}} </p>
                </div>
                <div class="teacher-container">
                <p><strong>Teacher:</strong> {{ $excuseSlip->teacher->first_name }} {{ $excuseSlip->teacher->last_name }}</p>
                <p><strong>Subject:</strong> {{ $excuseSlip->course->course_name}} </p>

                </div>
                <p><strong>Course:</strong> {{ $excuseSlip->course->course_name }}</p>
                <p><strong>Start Date:</strong> {{ $excuseSlip->start_date }}</p>
                <p><strong>End Date:</strong> {{ $excuseSlip->end_date }}</p>
                <p><strong>Status:</strong> {{ $excuseSlip->status->status_name }}</p>
                {{-- Add other details as needed --}}
            </div>
        </div>
    </div>
</div>

</body>
@endsection
