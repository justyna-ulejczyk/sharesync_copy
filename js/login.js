document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById('password');
    const registrationForm = document.getElementById("registrationForm");

    registrationForm.addEventListener('submit', function (event) {
        const password = passwordInput.value;
        const specialCharacterRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        const uppercaseCharacterRegex = /[A-Z]+/;

        if (!specialCharacterRegex.test(password)) {
            event.preventDefault();
            showPopupMessage("Password must contain at least one special character.");
        } else if (password.length < 8) {
            event.preventDefault();
            showPopupMessage("Password must be at least 8 characters long.")
        } else if (!uppercaseCharacterRegex.test(password)) {
            event.preventDefault();
            showPopupMessage("Password must contain at least one uppercase character.")
        }
        else {
            registrationForm.submit();
        }
    });
});

function showPopupMessage(message) {
    alert(message);
}

function checkUsernameAvailability(username) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/check_username.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("usernameAvailability").innerHTML = xhr.responseText;
            if (xhr.responseText == "Username already taken") {
                document.getElementById("registerSubmit").setAttribute("disabled", "disabled");
            } else {
                document.getElementById("registerSubmit").removeAttribute("disabled");
            }
        }
    };
    xhr.send("username=" + username);
}

function loginProcess(event) {
    event.preventDefault();
    var username = document.getElementById("loginUsername").value;
    var password = document.getElementById("loginPassword").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText == "") {
                window.location.href = "Home.php";
            }
            document.getElementById("loginMessage").innerHTML = xhr.responseText;
            console.log(xhr.responseText);
        }
    };
    xhr.send("username=" + username + "&password=" + password);
}