<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/scss/home.scss', 'resources/js/app.js'])
    @yield('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
</head>
<body class="bg-image">
<header>
        <nav class="inline-navbar">
 <ul> 
        <div class="logo"></div>
        <div class="sis">
            <span class="yellow">Ex</span>
            <span class="White">Sis</span>
            <span class="yellow">Slip</span>
            

            <div class="nav-right">
            <a href="#"><i class="fas fa-home"></i> </a>

            <form action="{{ route('user.logout') }}" method="post" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">
                <div class="circle-icon"></div><i>Logout</i>
            </button>
        </form></div>
            

                        
                    </div>
            </nav>
        </div>
        <nav class="yellow-navbar">
</ul>

</header>
<div class="sidebar">
    <div class="profile-container">
        <div class="profile-image"></div>
        <div class="profile-name">Counselor:{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>

    </div>
    <div class="divider"></div>
    <div class="divider"></div>
    <div class="navmenu">
            <ul>
                <li><span>DASHBOARD</span></li>
                <li class="dropdown-li">
                    <span id="schoolYearButton"><i class="fas fa-caret-down"></i> SCHOOL YEAR</span>
                    <ul class="dropdown" id="schoolYearDropdown">
                        <!-- Add your school year options here -->
                        <li><a href="#">SY 2021-2022</a></li>
                        <li><a href="#">SY 2022-2023</a></li>
                        <li><a href="#">SY 2023-2024</a></li>
                        <!-- Add more options as needed -->
                    </ul>
                </li>
            </ul>
        </div>    </div>
    
    @yield('content')   

</body>
@section('head')
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var schoolYearButton = document.getElementById('schoolYearButton');
        var schoolYearDropdown = document.getElementById('schoolYearDropdown');

        schoolYearButton.addEventListener('click', function () {
            schoolYearDropdown.style.display = (schoolYearDropdown.style.display === 'block') ? 'none' : 'block';
        });
    });
</script>
    

<style>
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
</style>