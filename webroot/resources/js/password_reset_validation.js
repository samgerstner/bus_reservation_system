$(document).ready(function() {
    $('#password').on('input', function() { checkPassword(); });
    $('#password_confirm').on('input', function() { checkConfirmPassword(); });
    $('#submitbtn').click(function() {
        if(!checkPassword() && !checkConfirmPassword())
        {
            $('#message').html(`<div class="alert alert-warning">Please fill out all required fields.</div>`);
        }
        else if(!checkPassword() || !checkConfirmPassword())
        {
            $('#message').html(`<div class="alert alert-warning">Please fill out all required fields.</div>`);
        }
        else
        {
            $('#message').html('');
            var form = $('#reset-form')[0];
            var data = new FormData(form);
            $.ajax({
               type: "POST",
               url: "reset-password.php",
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