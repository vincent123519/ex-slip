@extends('components.admin')

@section('content')

<div class="user-container">
    <h1>Users</h1>
    <nav>
  <div class="dashboard-stats">
    <a href="{{ route('admin.students.index') }}" class="stat">
      <div>
        <h3>Total Students</h3>
        <p>{{ $total_students }}</p>
      </div>
    </a>
    <a href="{{ route('admin.teachers.index') }}" class="stat">
      <div>
        <h3>Total Teachers</h3>
        <p>{{ $total_teachers }}</p>
      </div>
    </a>
      <div>
        <h3>Total Deans</h3>
        <p>{{ $total_deans }}</p>
      </div>
    </a>
      <div>
        <h3>Total Counselors</h3>
        <p>{{ $total_counselors }}</p>
      </div>
    </a>
  </div>
</nav>


@endsection
<style>
      .user-container {
        /* background-color: #f8f9fa; */
        background-color: #f8f9fa;
    padding: 20px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    width: 60%;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Montserrat', sans-serif;
        

    }

    nav {
      background-color: #f8f9fa; /* Light gray background color */
      padding: 10px;
      display: absolute;
      justify-content: space-around;
      align-items: center;
    }

    .dashboard-stats {
      display: flex;
      justify-content: space-around;
      width: 100%; /* Adjust the width as needed */
    }

    .stat {
      text-align: center;
    }

/* Add more styles as needed */

/* Add more styles as needed */
</style>