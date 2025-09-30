$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        const loginData = {
            email: $('#email').val(),
            password: $('#password').val()
        };
        
        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            dataType: 'json',
            data: loginData,
            success: function(response) {
                if (response.success) {
                    localStorage.setItem('userSession', JSON.stringify({
                        userId: response.userId,
                        username: response.username,
                        email: response.email,
                        sessionToken: response.sessionToken
                    }));
                    window.location.href = 'profile.html';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Login failed. Please try again.');
            }
        });
    });
});