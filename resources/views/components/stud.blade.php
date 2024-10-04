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
        <form action="{{ route('student.dashboard') }}" method="get" style="display: inline;">
            @csrf
            <button type="submit" class="home-btn">
           <div class="home-icon"></div>
            </button>
        </form>
       

        @if(auth()->user()->role_id == 4)

        <form action="{{ route('counselor.dashboard') }}" method="get" style="display: inline;">
        @csrf
        <button type="submit" class="home-btn">
        <div class="home-icon"><i style="
            color: beige;
            font-weight: bold;
        "> </i></div>
        </button>
        </form>
@endif


            <form action="{{ route('user.logout') }}" method="post" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">
                <div class="circle-icon"></div><i style="
                color: beige;
                font-weight: bold;
            "></i>
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
        <div class="profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
        
    </div>
    <div class="role-name">Student</div>
    <!-- <div class="divider"></div>
    <div class="divider"></div> -->
    <!-- <div class="profile-name">{{ Auth::user()->role->role_name }}</div> -->

    <a href="{{ route('change-password') }}" class="stat">CHANGE PASSWORD</a>
    
    <div class="navmenus"><ul>
        
        <li><span>DASHBOARD</span></li>
       

        

    </ul></div>    </div>
    
    
    @yield('content')   

</body>

<style>


    </style>


@section('head')
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endsection





