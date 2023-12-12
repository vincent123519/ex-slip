@extends('components.admin')

@section('content')

<div class="excuse-container">
    <h1>Admin Dashboard</h1>
    <div class="dashboard-stats">
        <div class="stat">
            <h3>Total Students</h3>
            <p>{{ $total_students }}</p>
        </div>
        <div class="stat">
            <h3>Total Teachers</h3>
            <p>{{ $total_teachers }}</p>
        </div>
        <div class="stat">
            <h3>Total Deans</h3>
            <p>{{ $total_deans }}</p>
        </div>
        <div class="stat">
            <h3>Total Counselors</h3>
            <p>{{ $total_counselors }}</p>
        </div>
    </div>
    <!-- Add more dashboard components as needed -->
</div>

@endsection
<style>
    .excuse-container {
    /* background-color: #f8f9fa; */
    padding: 20px 10px 30px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    width: 60%;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: ;
}

.dashboard-stats {
    display: flex;
    justify-content: space-between;
}

.stat {
    flex: 1;
    text-align: center;
    margin: 0 10px;
}

/* Add more styles as needed */

/* Add more styles as needed */
</style>