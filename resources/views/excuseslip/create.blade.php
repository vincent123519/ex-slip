@extends('components.signlayout')

@section('content')
    <div class="manage-slip-container">
        <h2 class="excuse-slip-header">Excuse Slip</h2>
        <form action="{{ route('excuse_slips.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="offer_code">Offer Code:</label>
                <select name="offer_code" id="offer_code" class="form-control" required>
                    @foreach($studyLoad as $study)
                        <option value="{{ $study->offer_code }}">{{ $study->offer_code }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea name="reason" id="reason" class="form-control" rows="4" required>{{ old('reason') }}</textarea>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
