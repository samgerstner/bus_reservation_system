$(document).ready(function() {
    $('#username').on('input', function() { checkUsername(); });
    $('#password').on('input', function() { checkPassword(); });
    $('#password_confirm').on('input', function() { checkConfirmPassword(); });
    $('#submitbtn').click(function() {
        if(!checkUsername() && !checkPassword() && !checkConfirmPassword())
        {
            $('#message').html(`<div class="alert alert-warning">Please fill out all required fields.</div>`);
        }
        else if(!checkUsername() || !checkPassword() || !checkConfirmPassword())
        {
            $('#message').html(`<div class="alert alert-warning">Please fill out all required fields.</div>`);
        }
        else
        {
            $('#message').html("");
            var form = $('#register-form')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "process.php",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                beforeSend: function() {
                    $('#submitbtn').html('<i class="fa-solid fa-spinner fa-spin"></i>');
                    $('#submitbtn').attr("disabled", true);
                    $('#submitbtn').css({ "border-radius": "50%" });
                },
                success: function(data) {
                    $('#message').html(data);
                },
                complete: function() {
                    setTimeout(function() {
                        $('#register-form').trigger("reset");
                        $('#submitbtn').html('Submit');
                        $('#submitbtn').attr("disabled", false);
                        $('#submitbtn').css({ "border-radius": "4px" });
                    }, 50000);
                }
            });
        }
    });
});

function checkUsername()
{
    var pattern = /^(?:[A-Za-z0-9])(?:[A-Za-z0-9_]+)(?:[A-Za-z0-9])$/;
    var username = $('#username').val();
    var validUsername = pattern.test(username);

    if($('#username').val().length < 8)
    {
        $('#username-error').html('Username is too short. Usernames must be at least 8 characters.');
        return false;
    }
    else if($('#username').val().length > 20)
    {
        $('#username-error').html('Username is too long. Usernames can be up to 20 characters.');
        return false;
    }
    else if(!validUsername)
    {
        $('#username-error').html('Incorrect username format. Usernames can only contain alphanumeric characters and underscores.');
        return false;
    }
    else
    {
        $('#username-error').html('');
        return true;
    }
}

function checkPassword()
{
    var pattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,25}$/;
    var password = $('#password').val();
    var validPassword = pattern.test(password);

    if(password == "")
    {
        $('#password-error').html('Password cannot be empty.');
        return false;
    }
    else if(!validPassword)
    {
        $('#password-error').html('Passwords must be between 8 and 25 characters and contain 1 number, 1 letter and one special character.');
        return false;
    }
    else
    {
        $('#password-error').html("");
        return true;
    }
}

function checkConfirmPassword()
{
    var password = $('#password').val();
    var confirmPass = $('#password_confirm').val();

    if(confirmPass == "")
    {
        $('#confirm-password-error').html('Confirm Password cannot be empty.');
        return false;
    }
    else if(password != confirmPass)
    {
        $('#confirm-password-error').html('Passwords do not match.');
        return false;
    }
    else
    {
        $('#confirm-password-error').html('');
        return true;
    }
}