<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Alumni Sans' rel='stylesheet'>
    <title>@yield('title')</title>
        @vite(['resources/css/app.css', 'resources/scss/login.scss', 'resources/js/app.js'])

</head>
<body class="bg-image">
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

.sis .White {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-top: 28px;
    margin-left: -194px;
    /* font-style: oblique; */
}

.sis .Whites {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-left: 4px;
    margin-top: 28px;
    font-family: "Montserrat", sans-serif;
    /* font-style: oblique; */

}
.sis .Whitess {
    color: whitesmoke;
    font-weight: bold;
    padding: 0px;
    font-size: large;
    margin-left: 4px;
    margin-top: 28px;
    font-family: "Montserrat", sans-serif;
    /* font-style: oblique; */

    .login-card {
    width: 300px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 0;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
}
</style>

@section('head')
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endsection

