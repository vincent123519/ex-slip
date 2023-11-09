<!DOCTYPE html>
<html>
<head>
    <title>Excuse Slip Details</title>
</head>
<body>
    <h1>Excuse Slip Details</h1>

    @if (isset($excuseSlip))
        <h2>Excuse Slip ID: {{ $excuseSlip->excuse_slip_id }}</h2>
        <p>Student Name: {{ $excuseSlip->student->name }}</p>
        <p>Teacher Name: {{ $excuseSlip->teacher->name }}</p>
        <p>Course: {{ $excuseSlip->course->name }}</p>
        <p>Status: {{ $excuseSlip->status->name }}</p>
        <p>Feedback: {{ $excuseSlip->feedback ? $excuseSlip->feedback->feedback_remarks : 'No feedback provided' }}</p>
        <p>Supporting Documents: 
            @foreach ($excuseSlip->supportingDocuments as $document)
                <a href="{{ $document->url }}">{{ $document->name }}</a>
            @endforeach
        </p>
    @else
        <p>Excuse slip not found.</p>
    @endif
</body>
</html>