<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
        @vite(['resources/css/app.css', 'resources/scss/login.scss', 'resources/js/app.js'])

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
            </nav>
        </div>
        <nav class="yellow-navbar">
</ul>

</header>
    <div class="container">
        @yield('content')
    </div>
</body>


</html>
<style>
.reg {
    color: yellow;
    /* padding: 2px 4px; */
    /* background: yellow; */
    text-decoration: none;
    font-style: italic;
    font-family: "Trirong", serif;
}
    .createbtn{
        background: yellow;
    border-radius: 6px;
    margin: 9px;
    color:yellow;
    font-style: italic;
    }
    .sis {
    display: flex;
    font-size: larger;
    align-items: center;
    /* background-color: rgba(13, 62, 32, 0.98); */
    padding: 39px 155px;
}
.sis .White {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-left: -156px;
}
.sis .Whites {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-left: 4px;
}
.sis .Whitess {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-left: 4px;
}
    .logo{
    background-image: url(http://[::1]:4000/resources/scss/image/usjr_trans.png);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    margin-top: -14px;
    margin-left: 10px;
    position: absolute;
    height: 105px;
    width: 102px;
    z-index: 1;
    padding: 21px 22px;
    }
    .sis{
        display: flex;
    font-size: larger;
    align-items: center;
    /* background-color: rgba(13, 62, 32, 0.98); */
    padding: 39px 174px;
    }
    .login-container button[type=submit] {
    height: 31px;
    padding: 0px 7px;
    width: 99%;
    cursor: pointer;
    border: 2px solid #a2a194;
    color: yellow;
    float: center;
    background-color: green;
    transition: background-color 0.3s ease, transform 0.2s ease;
    margin: 10px;
    border-radius: 76px;
}
.createbtn {
    background: yellow;
    border-radius: 6px;
    margin: 7px;
    height: 31px;
    color: green;
}

</style>

@section('head')
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endsection

