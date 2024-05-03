@extends('components.stud')

@section('content')

<div class ="change-pass-user">
<div class="logocp"></div>
    <h2>Change Password</h2>

    <form action="{{ route('change-password') }}" method="POST">
        @csrf
        
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password" required>

        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <input type="submit" value="Change Password">
    </form>
</div>


@endsection
<style>
         .logocp {
    background-image: url(http://[::1]:4000/resources/scss/image/ExcUseSlip.png);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    margin-top: -6px;
    margin-left: 470px;
    position: absolute;
    height: 50px;
    width: 102px;
    z-index: 1;
    padding: 21px 22px;
}
        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    border-top: 7px;
    border-radius: 0px;
    border-right: 0;
    border-left: 0;
}

        input[type=submit] {
            width: 100%;
            background-color: #274829;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #fec039;
        }

        .change-pass-user {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
    width: 58%;
    margin: auto;
    margin-top: 50px;
    font-family: 'Montserrat', sans-serif;
    border-left: 1px solid yellow;
    border-right: 1px solid yellow;
    border-bottom: 5px solid #fec039;
    border-top: 1px solid yellow;
}

h2 {
    margin-top: 92px;
    margin-left: 432px;
}
    </style>