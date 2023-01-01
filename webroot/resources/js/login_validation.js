$(document).ready(function() {
    $('#username').on('input', function() { checkUsername(); });
    $('#password').on('input', function() { checkPassword(); });
    $('#submitbtn').click(function() {
        if(!checkUsername() && !checkPassword())
        {
            $('#message').html(`<div class="alert alert-warning">Please correct input errors before proceeding.</div>`);
        }
        else if(!checkUsername() || !checkPassword())
        {
            $('#message').html(`<div class="alert alert-warning">Please correct input errors before proceeding.</div>`);
        }
        else
        {
            var form = $('#login-form')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "login.php",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                beforeSend: function() {
                    $('#submitbtn').html('<i class="fa-solid fa-spinner fa-spin"></i>');
                    $('#submitbtn').attr('disabled', true);
                    $('#submitbtn').css({ "border-radius": "50%" });
                },
                success: function(data) {
                    $('#message').html(data);
                },
                complete: function() {
                    setTimeout(function() {
                        $('#register-form').trigger("reset");
                        $('#submitbtn').html('Login');
                        $('#submitbtn').attr('disabled', false);
                        $('#submitbtn').css({ "border-radius": "4px" });
                    }, 50000);
                }
            })
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
    var password = $('#password').val();

    if(password == "")
    {
        $('#password-error').html('Password cannot be empty.');
        return false;
    }
    else
    {
        $('#password-error').html("");
        return true;
    }
}

function postUsernameError()
{
    $('#message').html('<span class="error" id="message">Username not found.</span>');
}

function postPasswordError()
{
    $('#message').html('<span class="error" id="message">Invalid password.</span>');
}