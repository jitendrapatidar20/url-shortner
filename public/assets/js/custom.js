$("#login").validate({
    ignore: [],
    rules: {
        email: { required: true, email: true },
        password: { required: true },
    },
    messages: {
        email: "Please enter a valid email address",
        password: {
            required: "Please provide a password"
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") == "password") {
            error.insertAfter($(element).parents('.input-field').after());
        } else {
            element.after(error);
        }
    },
    submitHandler: function (form) {
        // Show loader
        $('.loading').show();
        $("#login-btn").attr("disabled", true);

        var formData = new FormData($('#login')[0]);

        // Send AJAX login request
        $.ajax({
            type: "POST",
            url: BASEURL + '/post-login',
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            data: formData,
            success: function (response) {
                $('.loading').hide();
                $('.error').remove();
                $("#login")[0].reset();
                $("#login-btn").removeAttr("disabled");
                showMesseage('success', response.message);
                setTimeout(function () {
                    window.location.href = response.redirect.startsWith("http")
                        ? response.redirect
                        : BASEURL + "/" + response.redirect;
                }, 2000);
            },
            error: function (request, status, error) {
                $('.loading').hide();
                $("#login-btn").removeAttr("disabled");
                if (request.status == 401) {
                    var response = JSON.parse(request.responseText);
                    showMesseage('error', response.error);
                } else {
                    showMesseage('error', "Login failed. Please try again.");
                }
                return false;
            }
        });
    }
});

function timeComvert(times) {
    var res = times.split(":");
    return res[0] + res[1];
}

function encodeBase64(element) {
    var fileName = $(element).parent().children('.first').children().attr("class");
    var extension_allow_string = $(element).parent().children('.first').children().attr("data-extension");
    var extension_allow = extension_allow_string.split(",");
    var filesize_allow = $(element).parent().children('.first').children().attr("data-size");

    var file = element.files[0];
    var filename = file.name;
    var extension = filename.substring(filename.lastIndexOf('.') + 1, filename.length) || filename;

    if ($.inArray(extension, extension_allow) > -1) {
        $("." + fileName + "_error").html("");
    } else {
        $("." + fileName + "_error").html("This file extension not allowed.");
    }

    var filesize = file.size / 1024;
    if (filesize_allow < filesize) {
        $("." + fileName + "_error_size").html("File size only " + filesize_allow + " KB allowed.");
    } else {
        $("." + fileName + "_error_size").html("");
    }

    $("." + fileName).val(filename);
    var reader = new FileReader();
    reader.onloadend = function () {};
    reader.readAsDataURL(file);
}

// Password show/hide logic
const forms = document.querySelector(".forms"),
    pwShowHide = document.querySelectorAll(".eye-icon"),
    links = document.querySelectorAll(".link");

pwShowHide.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        let pwFields = eyeIcon.parentElement.parentElement.querySelectorAll(".password");
        pwFields.forEach(password => {
            if (password.type === "password") {
                password.type = "text";
                eyeIcon.classList.replace("bx-hide", "bx-show");
                return;
            }
            password.type = "password";
            eyeIcon.classList.replace("bx-show", "bx-hide");
        });
    });
});
