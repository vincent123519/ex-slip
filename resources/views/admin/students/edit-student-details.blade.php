<div class="container">
    <h1>Update Student Details</h1>
    <form action="{{ route('admin.students.update', $student->student_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $student->first_name }}">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $student->last_name }}">
        </div>
        <div class="form-group">
            <label for="year_level">Year Level</label>
            <input type="number" name="year_level" id="year_level" class="form-control" value="{{ $student->year_level }}">
        </div>
        <div class="form-group">
            <label for="degree_id">Degree Name</label>
            <select name="degree_id" id="degree_id" class="form-control">
                @foreach ($degrees as $degree)
                    <option value="{{ $degree->degree_id }}" @if ($degree->degree_id === $student->degree_id) selected @endif>{{ $degree->degree_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $student->email }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>