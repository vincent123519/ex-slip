<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/scss/home.scss', 'resources/js/app.js'])
    @yield('styles')
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
                <a href="#"><i class="fas fa-home"></i></a>
                <a href="http://127.0.0.1:8000/" onclick="event.preventDefault();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                
            </div>
            

                        
                    </div>
            </nav>
        </div>
        <nav class="yellow-navbar">
</ul>

</header>
<div class="sidebar">
    <div class="profile-container">
        <div class="profile-image"></div>
        <div class="profile-name">Andro O. Rat</div>
    </div>
    <div class="divider"></div>
    <div class="divider"></div>
    <div class="navmenu"><ul>
        <li><span>menu</span></li>
        <li>AttendanceSlip</li>
    </ul></div>    </div>
    
    @yield('content')   

</body>
