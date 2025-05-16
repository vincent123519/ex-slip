<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/scss/home.scss', 'resources/js/app.js','resources/scss/actors-css/student.scss'])
    @yield('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-image">
<header>
        <nav class="inline-navbar">
 <ul> 
        <div class="logo"></div>
        <div class="sis">
        <span class="yellow">Ex</span>
            <span class="yellow">Sis</span>
            <span class="yellow">Slip</span>
            <span class="White">Excuse</span>
            <span class="Whites">Slip</span>
            <span class="Whitess">System</span>

         <div class="nav-right">
 


            

                @if(auth()->user()->role_id == 6)
                    <form action="{{ route('admin.dashboard') }}" method="get" style="display: inline;">
                        
                        <button type="submit" class="logout-btn">

                            <div class="circle-icon"><i style="color: beige; font-weight: bold;"></i></div>
                        </button>
                    </form>
                @endif

                @if(auth()->user()->role_id == 4)
                    <form action="{{ route('counselor.dashboard') }}" method="get" style="display: inline;">
                        
                        <button type="submit" class="home-btn">

                            <div class="circle-icon"><i style="color: beige; font-weight: bold;"></i></div>
                        </button>
                    </form>
                @endif

                @if(auth()->user()->role_id == 3)
                    <form action="{{ route('student.dashboard') }}" method="get" style="display: inline;">
                        
                        <button type="submit" class="logout-btn">

                            <div class="circle-icon"><i style="color: beige; font-weight: bold;"></i></div>
                        </button>
                    </form>
                @endif
                
                @if(auth()->user()->role_id == 2)
                    <form action="{{ route('teacher.dashboard') }}" method="get" style="display: inline;">
                        
                        <button type="submit" class="logout-btn">

                            <div class="circle-icon"><i style="color: beige; font-weight: bold;"></i></div>
                        </button>
                    </form>
                @endif



                @if(auth()->user()->role_id == 5)
                    <form action="{{ route('dean.dashboard') }}" method="get" style="display: inline;">
                        
                        <button type="submit" class="logout-btn">

                            <div class="circle-icon"><i style="color: beige; font-weight: bold;"></i></div>
                        </button>
                    </form>
                @endif

               
            </div>
            

                        
    </div>
            </nav>
        </div>
        <nav class="yellow-navbar">
</ul>

</header>
<div class="sidebar">
    <div class="profile-container">
    @php
    $imagePath = Auth::user()->image ? 'storage/user_image/' . Auth::user()->image : 'storage/user_image/user.png';
    @endphp
    <img src="{{ asset($imagePath) }}"
     alt="image"
     style="width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #fff;
            margin-bottom: 10px;
            background-size: cover;
            background-position: center;">
          @if (Auth::user()->role_id !== 6) <!-- Admin role check -->
        <div class="profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
    @endif
        
    </div>
    <div class="role-name">
    @switch(auth()->user()->role_id)
        @case(2)
            Teacher
            @break

        @case(3)
            Student
            @break

        @case(4)
            Counselor
            @break

        @case(5)
            Dean
            @break

        @case(6)
            Admin
            @break

        @default
            Unknown Role
    @endswitch
</div>
    <!-- <div class="divider"></div>
    <div class="divider"></div> -->
    <!-- <div class="profile-name">{{ Auth::user()->role->role_name }}</div> -->

    <a href="{{ route('change-password') }}" class="stat">CHANGE PASSWORD</a>
    
    <div class="divider"></div>
    <div class="divider"></div>
    <div class="navmenu">
    <ul>
    @if (auth()->user()->role_id !== 6) <!-- Admin role -->
    <li><span>DASHBOARD</span><a class="links" href=""></a></li>
    @endif


    @if (auth()->user()->role_id == 6) <!-- Admin role -->
    <li><span>DASHBOARD</span><a class="links" href="{{ route('admin.dashboard') }}"></a></li>
    @endif

    @if (auth()->user()->role_id == 6) <!-- Admin role -->
            <li><a class="links" href="{{ route('admin.school_years.index') }}">SCHOOL YEAR</a></li>
            <li><a class="links" href="{{ route('admin.course_offerings_and_courses') }}">COURSE</a></li>
            <li><a class="links" href="{{ route('admin.import.index') }}">IMPORT DATA</a></li>
            <li><a class="links" href="{{ route('manage-users') }}">MANAGE USER ACCOUNTS</a></li>
            <li><a class="links" href="{{ route('admin.excuseslip.index') }}">EXCUSE SLIPS</a></li>
        @endif

        @if (auth()->user()->role_id == 3) <!-- student role -->
            <li><a class="links" href="{{ route('student.dashboard') }}">Home</a></li>
        @endif

        @if (auth()->user()->role_id == 2) <!-- teacher role -->
            <li><a class="links" href="{{ route('teacher.dashboard') }}">Home</a></li>
        @endif

        @if (auth()->user()->role_id == 5) <!-- dean role -->
            <li><a class="links" href="{{ route('dean.dashboard') }}">Home</a></li>
        @endif
        

</ul>
        </div>
    </div>
    
    @yield('content')   

</body>

<style>
    /* Your existing styles */
    .years{
        font-weight: bold;
        text-decoration: none;

    }
    .profile-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
    margin-top: 66px;
}
    .sis {
    display: flex;
    font-size: larger;
    align-items: center;
    /* background-color: rgba(13, 62, 32, 0.98); */
    padding: 39px 155px;
}



    .sis{
        display: flex;
    font-size: larger;
    align-items: center;
    /* background-color: rgba(13, 62, 32, 0.98); */
    padding: 39px 174px;
    }
    .links
    {
        text-decoration: none;
    color: rgba(13, 62, 32, 0.98);
    font-weight: bold;
    padding: 0px 10px;
    }
    .navmenu{
        font-family: 'Montserrat', sans-serif;            

    }

    .navmenu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            
        }
        
        .navmenu li {
            display: inline-block;
            padding: 2px;
            border-bottom: 1px solid rgba(13,62,32,0.98);
            border-top: none;
            width: 250px;
        }
        
        .navmenu li span {
            padding: 10px;
            cursor: pointer;
        }
        
        .navmenu .dropdown {
            display: none;
            position: absolute;
            background-color: #fec039;
            width: 250px;
            box-shadow: 2px 8px 16px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(13,62,32,0.98);
            font-family: 'Montserrat', sans-serif;            
        }
        
        .navmenu .dropdown li {
            display: block;
        }
        
        .dropdown-li:focus .dropdown {
            display: block;
        }
        
        .dropdown-li {
            position: relative;
            
        }
    
        #schoolYearButton {
            cursor: pointer;
            color: rgba(13, 62, 32, 0.98);
    
        }
    
        .dropdown {
            display: none;
            position: absolute;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
    
        .dropdown li {
            display: block;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: rgba(13, 62, 32, 0.98);
            
    
        }
    
        .dropdown li:last-child {
            border-bottom: none;
        }
    
        .dropdown a {
            text-decoration: none;
            display: block;
        }
    
        .dropdown a:hover {
            background-color: #f5f5f5; /* Hover background color for options */
        }
        .course-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Roboto', sans-serif;
    margin-top: 15px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.course-table th,
.course-table td {
    padding: 12px 16px;
    border: 1px solid #dee2e6;
    text-align: left;
    vertical-align: middle;
}

.course-table th {
    background-color: #f8f9fa;
    color: #333;
    font-weight: 600;
}

.course-table tr:nth-child(even) {
    background-color: #fdfdfd;
}

.course-table tr:hover {
    background-color: #f1f7ff;
}

.course-table input[type="checkbox"] {
    transform: scale(1.2);
    cursor: pointer;
}

</style>


@section('head')
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endsection





