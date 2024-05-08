<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/scss/home.scss', 'resources/js/app.js','resources/scss/actors-css/excuse.scss'])
    @yield('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@latest/dist/katex.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">    
</head>
<body class="bg-image">
<script src="https://cdn.jsdelivr.net/npm/katex@latest/dist/katex.min.js"></script>
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

    </style>

@section('head')
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endsection