<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <script src="../js/login.js"></script>
    <link rel="stylesheet" href="../css/Login.css">
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>

    <section id="loginSection">
        <!-- Title/Logo -->
        <div>
            <h1>ShareSync</h1>
            <h1>Login</h1>
        </div>

        <!-- Login Part -->

        <form action="../php/login.php" method="post" id="loginForm">
            <div>
                <div class="login-inputs">
                    <div>
                        <img src="../images/icons/login/user-svgrepo-com.svg" alt="">
                        <input id="loginUsername" type="text" name="username" placeholder="Username" required="">
                    </div>
                    <div>
                        <img src="../images/icons/login/lock-keyhole-minimalistic-svgrepo-com.svg" alt="">
                        <input id="loginPassword" type="password" name="password" placeholder="Password" required="">
                    </div>
                </div>
                <div>
                    <a href="update_password.php">Forgot password?</a>
                    <div class="option2">
                        <p>New to this website? </p>
                        <a class="to-signup-change-screen">Sign Up</a>
                    </div>
                </div>
            </div>
            <div>
                <span id="loginMessage"></span>
                <input id="loginSubmit" type="submit" name="login" value="Login">
            </div>
        </form>

        <script>
            document.getElementById("loginForm").addEventListener("keypress", function (event) {
                // Check if Enter key is pressed
                if (event.keyCode === 13) {
                    event.preventDefault(); // Prevent default form submission
                    loginProcess(); // Call your login process function
                }
            });

            function loginProcess() {
                // Implement your login process here
                // This function will be called when the form is submitted
                // You can collect form data and send it to the server for processing
                // For example:
                document.getElementById("loginForm").submit(); // Submit the form
            }
        </script>

    </section>

    <section id="registerSection">
        <div class='title'>
            <span>ShareSync</span>
            <span>Register</span>
        </div>
        <div class="terms">
            <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
            <label for="agreeTerms">I agree to the <a href="tc.html">Terms and Conditions</a></label><br>
        </div>
        <form action="../php/register.php" method="post" id="registrationForm">
            <div class='enter-info'>
                <label for="name">Full name:</label>
                <input id="name" name="name" type="text" />
                <label for="username">Username:</label>
                <input id="username" name="username" required="" type="text"
                    oninput="checkUsernameAvailability(this.value)" />
                <span id="usernameAvailability"></span><br>
                <label for="email">Email:</label>
                <input id="email" name="email" required="" type="email" />
                <label for="password">Password:</label>
                <input id="password" name="password" required="" type="password" />
                <p>Account type:</p>
                <div class='account-type-options'>
                    <input type="radio" id="student" name="account_type" value="student">
                    <label for="student">Student</label><br>
                    <input type="radio" id="artist" name="account_type" value="artist">
                    <label for="artist">Artist</label><br>
                </div>
                <div class="option2">
                    <p>Already a Member?</p>
                    <a class="to-login-change-screen">Login</a>
                </div>
            </div>
            <div>

                <input id="registerSubmit" name="register" type="submit" value="register" onload="" />
            </div>
        </form>
    </section>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const registerSection = document.querySelector("section:nth-child(2)");
            const loginSection = document.querySelector("#loginSection");
            registerSection.style.visibility = "hidden";
            loginSection.style.visibility = "visible";

            document.querySelector(".to-login-change-screen").addEventListener("click", function () {
                registerSection.style.zIndex = "0";
                registerSection.style.visibility = "hidden";
                loginSection.style.visibility = "visible";
            });

            document.querySelector(".to-signup-change-screen").addEventListener("click", function () {
                registerSection.style.zIndex = "2";
                registerSection.style.visibility = "visible";
                loginSection.style.visibility = "hidden";
            });
        });
    </script>



</body>


</html>