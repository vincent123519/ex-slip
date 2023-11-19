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
            <span class="White">Sis</span>
            <span class="yellow">Slip</span>
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
    

</style>

