<!DOCTYPE html>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Course</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('courses.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="course_code">Course Code:</label>
                                <input type="text" name="course_code" id="course_code" class="form-control" value="{{ old('course_code') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="course_name">Course Name:</label>
                                <input type="text" name="course_name" id="course_name" class="form-control" value="{{ old('course_name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="department_id">Department:</label>
                                <select name="department_id" id="department_id" class="form-control" required>
                                    {{-- Assuming you have a $departments variable from the controller --}}
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Course</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
