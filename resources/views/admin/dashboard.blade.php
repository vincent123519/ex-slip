@extends('components.admin')

@section('content')
    <div class="user-container">
        <h1>Users</h1>
        <nav>
            <div class="dashboard-stats">
                <a href="{{ route('admin.students.index') }}" class="stat">
                    <div>
                        <div class="user-image student-image"></div>
                        <h3>Total Students</h3>
                        <p>{{ $total_students }}</p>
                    </div>
                </a>
                <a href="{{ route('admin.teachers.index') }}" class="stat">
                    <div>
                        <div class="user-image teacher-image"></div>
                        <h3>Total Teachers</h3>
                        <p>{{ $total_teachers }}</p>
                    </div>
                </a>
                <a href="{{ route('admin.dean.index') }}" class="stat">
                    <div>
                        <div class="user-image dean-image"></div>
                        <h3>Total Deans</h3>
                        <p>{{ $total_deans }}</p>
                    </div>
                </a>
                <a href="{{ route('admin.counselors.index') }}" class="stat">
                    <div>
                        <div class="user-image counselor-image"></div>
                        <h3>Total Counselors</h3>
                        <p>{{ $total_counselors }}</p>
                    </div>
                </a>
            </div>
        </nav>
    </div>

    <div class="excuse-container">
    <h2>Excuse Stats</h2>
    <div class="excuse-records">
        <div class="excuse-stat">
            <p>Total Excuse Slips: <span>{{ $total_excuse }}</span></p>
        </div>
        <div class="excuse-stat">
            <div class="status-icon pending-icon"></div>
            <p>Pending: <span>{{ $pending_excuses }}</span></p>
        </div>
        <div class="excuse-stat">
            <div class="status-icon approve-icon"></div>
            <p>Approved: <span>{{ $approved_excuses }}</span></p>
        </div>
        <div class="excuse-stat">
            <div class="status-icon reject-icon"></div>
            <p>Rejected: <span>{{ $rejected_excuses }}</span></p>
        </div>
    </div>
</div>

<div class="school-container">
    <h2>School Information</h2>
    <div class="school-icon"></div> 
    <p>Total Schools: <a href="{{ route('admin.schools') }}">{{ $total_schools }}</a></p>
<p>Total Departments: <a href="{{ route('admin.departments') }}">{{ $total_departments }}</a></p>

</div>


@endsection

<style>
   :root {
        --user-image-url: url('http://[::1]:4000/resources/scss/image/user.png');
        --approve-icon-url: url('http://[::1]:4000/resources/scss/image/approve.png');
        --pending-icon-url: url('http://[::1]:4000/resources/scss/image/pending.png');
        --reject-icon-url: url('http://[::1]:4000/resources/scss/image/reject.png');
        --school-icon-url: url('http://[::1]:4000/resources/scss/image/school.png')

    }


    .user-container {
        position: relative;
        float: left;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 80%;
        margin: 20px auto;
        margin-right: 30px;
        font-family: 'Montserrat', sans-serif;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.5);
        text-align: center; /* Center align the user entities */
        margin-left: 348px;

    }

    .dashboard-stats {
        display: flex;
        justify-content: space-around;
        width: 100%; /* Adjust the width as needed */
    }

    .stat {
        text-align: center;
    }

    .user-image {
        width: 100px;
        height: 100px;
        border-radius: 50%; /* Make the image circular */
        margin: 0 auto 10px; /* Center align the image */
        background-size: cover;
        background-position: center;
        background-image: var(--user-image-url);
    }

    .excuse-container {
    FONT-WEIGHT: 600;
    position: relative;
    float: left;
    text-align: right;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 738px;
    border-collapse: collapse;
    background-color: rgba(255, 255, 255, 0.5);
    text-align: center;
    margin-left: 348px;
    font-family: 'Montserrat', sans-serif;



    }

    .excuse-stat {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 10px 0;
    }

    .status-icon {
        width: 50px;
        height: 50px;
        margin-right: 5px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    .approve-icon {
        background-image: var(--approve-icon-url);
    }

    .pending-icon {
        background-image: var(--pending-icon-url);
    }

    .reject-icon {
        background-image: var(--reject-icon-url);
    }

    .school-container {
        position: relative;
        float: left;
        text-align: right;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 40%;
        margin-left: 20px; /* Adjust margin as needed */
        font-family: 'Montserrat', sans-serif;
        background-color: rgba(255, 255, 255, 0.5);
        text-align: center;
        align-items: center;
        display: array_multisort;
        align-items: center;
        justify-content: center;
        position: relative; 



    }

    .school-icon {
    width: 80px;
    height: 80px;
    background-image: var(--school-icon-url);
    background-size: contain;
    background-repeat: no-repeat;
    position: absolute;
    left: 200;
}

</style>