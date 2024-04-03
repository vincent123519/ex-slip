@extends('components.admin')

@section('content')
<div class="studyload-container">
    <div class="studyload-card">
        <div class="studyload-header">
            
        </div>
        <div class="studyload-body">
        <form method="POST" action="{{ route('admin.studyload.store') }}">
        @csrf
        <input type="hidden" name="student_id" value="{{ $studentId }}">
        
        <div class="form-group">
            <label for="offer_codes">Offer Codes:</label>
            <select name="offer_codes[]" id="offer_codes" class="form-control" multiple required>
                <option value="">Select offer codes</option>
                @foreach($offerCodes as $offerCode)
                    <option value="{{ $offerCode->offer_code }}">{{ $offerCode->offer_code }} - {{ $offerCode->course_code }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="semester_id">Semester:</label>
            <select name="semester_id" id="semester_id" class="form-control" required>
                <option value="">Select a semester</option>
                @foreach($semesters as $semester)
                    <option value="{{ $semester->semester_id }}">{{ $semester->semester_name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Studyload</button>
    </form>
        </div>
    </div>
</div>
@endsection

<style>
.studyload-header {
    text-align: center;
    padding: 20px;
}

.studyload-body {
    background-color: #f8f9fa;
    padding: 20px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    width: 60%;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.studyload-container .form-group {
    margin-bottom: 20px;
}

.studyload-container label {
    display: block;
    font-weight: bold;
}

.studyload-container select {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.studyload-container button[type="submit"] {
    padding: 15px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.studyload-container button[type="submit"]:hover {
    background-color: #0056b3;
}
</style>

@section('scripts')
<script>
    // Update semester based on selected offer code
    document.getElementById('offer_codes').addEventListener('change', function() {
        var selectedOfferCode = this.value;
        var semesterSelect = document.getElementById('semester_id');
        var semesterOptions = semesterSelect.options;
        
        // Find the corresponding semester for the selected offer code
        for (var i = 0; i < semesterOptions.length; i++) {
            var semesterOption = semesterOptions[i];
            var semesterOfferCode = semesterOption.getAttribute('data-offer-code');
            
            if (semesterOfferCode === selectedOfferCode) {
                semesterSelect.value = semesterOption.value;
                break;
            }
        }
    });
</script>
@endsection