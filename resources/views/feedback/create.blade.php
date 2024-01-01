<!-- resources/views/feedback/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Feedback</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Feedback</h2>
    
    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf

        <label for="excuse_slip_id">Excuse Slip ID:</label>
        <input type="text" id="excuse_slip_id" name="excuse_slip_id" required>

        <label for="feedback_remarks">Feedback Remarks:</label>
        <textarea id="feedback_remarks" name="feedback_remarks" required></textarea>

        <label for="feedback_date">Feedback Date:</label>
        <input type="date" id="feedback_date" name="feedback_date" required>

        <label for="sender_id">Sender ID:</label>
        <input type="text" id="sender_id" name="sender_id" required>

        <label for="feedback_type">Feedback Type:</label>
        <select id="feedback_type" name="feedback_type" required>
            <option value="positive">Positive</option>
            <option value="negative">Negative</option>
        </select>

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
