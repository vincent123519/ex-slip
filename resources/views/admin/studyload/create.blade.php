@extends('components.signlayout')

@section('content')
<div class="manage-users-container">
<h1>Add Studyload</h1>
    <form method="POST" action="{{ route('admin.studyload.store') }}">
        @csrf
        <input type="hidden" name="student_id" value="{{ $studentId }}">
        <label for="semester_id">Semester ID:</label>
        <input type="text" name="semester_id" id="semester_id" required>
        <label for="course_code">Course Code:</label>
        <input type="text" name="course_code" id="course_code" required>
        <label for="offer_code">Offer Code:</label>
        <input type="text" name="offer_code" id="offer_code" required>
        <button type="submit">Add Studyload</button>
    </form></div>
@endsection

<style>.manage-users-container {
    /* background-color: rgb(243 254 240 / 98%); */
   /* // padding: 20px; */
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    /* width: 80%; */
    margin: 20px auto;
}</style>