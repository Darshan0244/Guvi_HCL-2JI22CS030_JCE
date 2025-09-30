$(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        
        const userData = {
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val()
        };
        
        $.ajax({
            url: 'php/register.php',
            type: 'POST',
            dataType: 'json',
            data: userData,
            success: function(response) {
                if (response.success) {
                    alert('Registration successful! Please login.');
                    window.location.href = 'login.html';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Registration failed. Please try again.');
            }
        });
    });
});