<!DOCTYPE html>
<html>
<head>
    <title>Give Feedback</title>
</head>
<body>
    <h1>Give Feedback</h1>

    <form action="{{ route('feedback.submit') }}" method="POST">
        @csrf

        <input type="hidden" name="excuse_slip_id" value="{{ $excuseSlip->excuse_slip_id }}">

        <div>
            <label for="feedback_remarks">Feedback Remarks:</label>
            <textarea id="feedback_remarks" name="feedback_remarks" rows="5" required></textarea>
        </div>

        <div>
            <label for="feedback_type">Feedback Type:</label>
            <select id="feedback_type" name="feedback_type" required>
                <option value="Positive">Positive</option>
                <option value="Negative">Negative</option>
            </select>
        </div>

        <div>
            <label for="feedback_date">Feedback Date:</label>
            <input type="date" id="feedback_date" name="feedback_date" required>
        </div>

        <div>
            <button type="submit">Submit Feedback</button>
        </div>
    </form>
</body>
</html>