<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-<YOUR-SHA-HASH>" crossorigin="anonymous" />
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
            <a href="#"><i class="fas fa-home"></i> </a>

            <form action="{{ route('user.logout') }}" method="post" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">
                <div class="circle-icon"></div><i>Logout</i>
            </button>
        </form></div>
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
        <div class="profile-name">Admin</div>
    </div>
    <div class="divider"></div>
    <div class="divider"></div>
    <div class="navmenu"><ul>
        <li><span>DASHBOARD</span></li>
     
    </ul></div>    </div>
    
    @yield('content')   

</body>
<style>
    .nav-right {
    font-family: '', sans-serif; /* Replace 'YourFont' with the actual font you want to use */
}

/* Optionally, you can specify a font size, weight, and other styles */
.nav-right i {
    font-size: 16px;
    font-weight: bold;
    color: wheat;
    /* Add more styles as needed */
}
 
</style>

@section('head')
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endsection