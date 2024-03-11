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

<form action="{{ route('admin.import.students') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept=".csv">
    <button type="submit">Import Students</button>
</form>






@endsection
<style>
      .user-container {
        /* background-color: #f8f9fa; */
        position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;
    font-family: 'Montserrat', sans-serif;
    border-collapse: collapse;
    background-color: rgba(255, 255, 255, 0.5);
        

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