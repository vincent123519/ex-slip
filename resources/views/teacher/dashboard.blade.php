@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Teacher Dashboard</h1>

        <div class="row">
            <div class="col-md-6">
                <h3>Excuse Slips</h3>
                @if (isset($excuseSlips) && count($excuseSlips) > 0)
                    <ul>
                        @foreach ($excuseSlips as $excuseSlip)
                            <li>
                                <h4>Excuse Slip ID: {{ $excuseSlip->excuse_slip_id }}</h4>
                                <p>Student: {{ $excuseSlip->student->name }}</p>
                                <p>Course: {{ $excuseSlip->course->name }}</p>
                                <!-- Display other details of each excuse slip -->
                                <form action="{{ route('teacher.signExcuseSlip', $excuseSlip->excuse_slip_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary">Sign Excuse Slip</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No excuse slips found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection