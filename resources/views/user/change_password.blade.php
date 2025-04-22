@extends('components.changepass')

@section('content')

@if (Auth::check() && Auth::user()->first_time_login == 1)
<!-- Modal on First Login -->
<div id="firstLoginModal" class="modal-overlay">
    <div class="modal-box">
        <h3>Welcome to Exsisslip</h3>
        <p>Default password needs to be changed.</p>
        <button onclick="closeModal()">Proceed</button>
    </div>
</div>

<script>
    window.onload = function () {
        document.getElementById("firstLoginModal").style.display = "flex";
    };

    function closeModal() {
        document.getElementById("firstLoginModal").style.display = "none";
    }
</script>
@endif


<div class="change-pass-container">
    <div class="change-pass-card">

        <div class="logo-area"></div>

        <form action="{{ route('change-password') }}" method="POST">
            @csrf

            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Change Password</button>
        </form>
    </div>
</div>

@endsection

<style>
/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-box {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    max-width: 400px;
    width: 80%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    font-family: 'Montserrat', sans-serif;
}

.modal-box h3 {
    margin-bottom: 15px;
    font-size: 22px;
    color: #274829;
}

.modal-box button {
    background-color: #274829;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.modal-box button:hover {
    background-color: #fec039;
}

/* Center container vertically and horizontally */
.change-pass-container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

/* Card-like form */
.change-pass-card {
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    font-family: 'Montserrat', sans-serif;
}

/* Optional logo area */
.logo-area {
    width: 60px;
    height: 60px;
    margin: 0 auto 20px auto;
    background: url('/your-logo.png') no-repeat center;
    background-size: contain;
}

/* Heading */
.change-pass-title {
    text-align: left;
    margin-bottom: 30px;
    font-size: 24px;
    font-weight: 600;
    color: #333;
}

/* Inputs */
.change-pass-card input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 14px;
}

/* Submit button */
.change-pass-card button {
    width: 100%;
    background-color: #274829;
    color: white;
    padding: 14px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.change-pass-card button:hover {
    background-color: #fec039;
}

/* Labels */
.change-pass-card label {
    font-size: 14px;
    color: #555;
    font-weight: 500;
}
</style>

<script>
    window.onload = function () {
        document.getElementById("firstLoginModal").style.display = "flex";
    };

    function closeModal() {
        document.getElementById("firstLoginModal").style.display = "none";
    }
</script>
