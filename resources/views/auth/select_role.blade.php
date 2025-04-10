@extends('components.signlayout')

@section('title', 'Select Your Role')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        height: 100vh;
        display: inline-table;
        justify-content: center;
        align-items: center;
    }

    .modal {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        width: 400px;
        max-width: 90%;
        padding: 30px;
        text-align: center;
        animation: fadeIn 0.3s ease-in-out;
        margin-right: 0px;
        margin-left: 750px;
        border-bottom-width: 11px;
        border-top-style: solid;
        margin-top: 166px;
        border-top-width: 0px;
        margin-bottom: 0px;
            }

    .modal h3 {
        margin-bottom: 20px;
        color: #fec039;
        font-size: 22px;
    }

    .modal ul {
        list-style: none;
        padding: 0;
        margin: 0 0 20px;
    }

    .modal li {
        margin-bottom: 15px;
    }

    .role-btn {
        background-color: #041f05;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
        width: 100%;
    }

    .role-btn:hover {
        background-color: #fec039;
    }

    .cancel-btn {
        background-color: #ccc;
        color: #333;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .cancel-btn:hover {
        background-color: #aaa;
    }

    @keyframes fadeIn {
        from {
            transform: scale(0.95);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<div id="roleSelectionModal" class="modal">
    <!-- Profile Section -->
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
                       background-color: #fec039;
                       margin-bottom: 10px;
                       background-size: cover;
                       background-position: center;">
            <div class="profile-name" style="font-weight: bold; margin-bottom: 10px;">
                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
            </div>
        </div>
    </div>

    <!-- Role Selection -->
    <h3>Login As</h3>
    <ul id="role-list">
        @foreach($users as $user)
            <li>
                <button class="role-btn" onclick="selectRole('{{ $user->user_id }}', '{{ $user->role_id }}', '{{ $user->username }}')">
                    {{ $user->role->role_name }} - {{ $user->username }}
                </button>
            </li>
        @endforeach
    </ul>
    <button onclick="closeModal()" class="cancel-btn">Cancel</button>
</div>


<script>
    function selectRole(userId, roleId, username) {
        fetch("{{ route('selectRoleLogin') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({
                user_id: userId,
                role_id: roleId,
                username: username,
                redirect_url: getRedirectUrl(roleId)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        });
    }

    function getRedirectUrl(roleId) {
        switch (parseInt(roleId)) {
            case 1: return "{{ route('admin.dashboard') }}";
            case 2: return "{{ route('teacher.dashboard') }}";
            case 3: return "{{ route('student.dashboard') }}";
            case 4: return "{{ route('counselor.dashboard') }}";
            case 5: return "{{ route('dean.dashboard') }}";
            default: return "{{ route('admin.dashboard') }}";
        }
    }

    function closeModal() {
        document.getElementById('roleSelectionModal').style.display = 'none';
    }
</script>
@endsection
