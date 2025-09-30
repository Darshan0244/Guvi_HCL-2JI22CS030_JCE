$(document).ready(function() {
    const userSession = JSON.parse(localStorage.getItem('userSession'));
    
    if (!userSession) {
        alert('Please login first');
        window.location.href = 'login.html';
        return;
    }
    
    // This is to Load user data
    $('#username').val(userSession.username);
    $('#email').val(userSession.email);
    
    // For Load profile data
    $.ajax({
        url: 'php/profile.php',
        type: 'GET',
        dataType: 'json',
        data: { userId: userSession.userId, sessionToken: userSession.sessionToken },
        success: function(response) {
            if (response.success && response.profile) {
                $('#age').val(response.profile.age || '');
                $('#dob').val(response.profile.dob || '');
                $('#contact').val(response.profile.contact || '');
                $('#address').val(response.profile.address || '');
            }
        }
    });
    
    // Updating the profile
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        
        const profileData = {
            userId: userSession.userId,
            sessionToken: userSession.sessionToken,
            age: $('#age').val(),
            dob: $('#dob').val(),
            contact: $('#contact').val(),
            address: $('#address').val()
        };
        
        $.ajax({
            url: 'php/profile.php',
            type: 'POST',
            dataType: 'json',
            data: profileData,
            success: function(response) {
                if (response.success) {
                    alert('Profile updated successfully!');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Profile update failed. Please try again.');
            }
        });
    });
    
    // Logout Button
    $('#logoutBtn').on('click', function() {
        localStorage.removeItem('userSession');
        window.location.href = 'login.html';
    });
});