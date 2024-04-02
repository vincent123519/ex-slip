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
            <span class="yellow">Sis</span>
            <span class="yellow">Slip</span>
            <span class="White">Excuse</span>
            <span class="Whites">Slip</span>
            <span class="Whitess">System</span>

            <div class="nav-right">
                <a href="#"><i class="fas fa-home"></i></a>
                <form action="{{ route('user.logout') }}" method="post" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">
                <div class="circle-icon"></div><i>Logout</i>
            </button>
        </form>
                
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
        <div class="profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>

    </div>
    <div class="divider"></div>
    <div class="divider"></div>
    <div class="navmenu"><ul>
        <li><span>DASHBOARD</span></li>
        <li>AttendanceSlip</li>
    </ul></div>    </div>
    
    @yield('content')   

</body>

@section('head')
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endsection

<style>
        .sis .White {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-left: -156px;
    font-family: 'Montserrat', sans-serif;

}
.sis .Whites {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-left: 4px;
    font-family: 'Montserrat', sans-serif;

}
.sis .Whitess {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-left: 4px;
    font-family: 'Montserrat', sans-serif;

}
.sis .yellow {
        color: #FFD700;
        font-weight: bold;
        padding: 1px;
        font-size: xx-large;
        margin-top: -59px;
        font-family: "Montserrat", sans-serif;
        margin-left: -4px;
    }
</style>