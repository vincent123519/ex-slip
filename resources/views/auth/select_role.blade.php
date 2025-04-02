@extends('components.signlayout')

@section('title', 'Select Your Role')

@section('content')
<div id="roleSelectionModal" class="modal">
    <div class="modal-content">
        <h3>Select Your Role</h3>
        <ul id="role-list">
            @foreach($users as $user)
                <li>
                    <button class="role-btn" onclick="selectRole('{{ $user->user_id }}', '{{ $user->role_id }}', '{{ $user->username }}')">
                        {{ $user->role->role_name }} - {{ $user->username }}
                    </button>
                </li>
            @endforeach
        </ul>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>
    function selectRole(userId, roleId, username) {
    console.log("Selected userId: " + userId);
    console.log("Selected roleId: " + roleId);

    fetch("{{ route('selectRoleLogin') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({
            user_id: userId, // Send the selected user ID
            role_id: roleId, // Send the selected role ID
            username: username, // Send the selected username
            redirect_url: getRedirectUrl(roleId)  // Generate the correct dashboard URL
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response data:", data);  // Check if the response contains the correct redirect_url
        if (data.redirect_url) {
            window.location.href = data.redirect_url; // Redirect to the correct dashboard
        } else {
            alert('Error: ' + data.error);  // Show error message if no URL is provided
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
    });
}


    function getRedirectUrl(roleId) {
        switch (roleId) {
            case 1: return "{{ route('admin.dashboard') }}";
            case 2: return "{{ route('teacher.dashboard') }}";
            case 3: return "{{ route('student.dashboard') }}";
            case 4: return "{{ route('counselor.dashboard') }}";
            case 5: return "{{ route('dean.dashboard') }}";
            default: return "{{ route('admin.dashboard') }}"; // Default case
        }
    }

    function closeModal() {
        document.getElementById('roleSelectionModal').style.display = 'none';
    }
</script>

@endsection
