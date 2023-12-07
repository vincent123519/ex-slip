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
                    <a href="http://127.0.0.1:8000/student/dashboard"><i class="fas fa-arrow-left"></i> Back</a>
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
        <div class="profile-name">Student:{{ Auth::user()->name }}</div>
    </div>
    <div class="divider"></div>
    <div class="divider"></div>
    <div class="navmenu">
        <ul>
            <li><span>DASHBOARD</span></li>
            <li>YOU MAY REQUEST FOR EXCUSE SLIP</li>
        </ul>
    </div>
</div>

@yield('content')

</body>
</html>
<style>
    body {
    font-family: 'Arial', sans-serif;
}

.nav-right a {
    text-decoration: none;
    color: #fff;
    margin-right: 10px;
    font-size: 16px;
    transition: color 0.3s;
}

.nav-right a:hover {
    color: #ffd700; /* Change to the desired hover color */
}

.nav-right i {
    margin-right: 5px;
}
    </style>