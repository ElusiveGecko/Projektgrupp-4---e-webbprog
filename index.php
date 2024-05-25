<?php session_start(); 
$_SESSION['userID'] = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

    <div class="header-container">
        <nav class="header">
            <h1 id="header-logo">Blocket-ish</h1>
            <div class="header-btns">
                <div class="header-btns"><button class="login-module-btn" id="header-btns">Login</button></div>
            </div>
        </nav>
    </div>

    <div class="home">
        <div class="home-container">
            <div class="home-content">
                <div class="home-text">
                    <h1>Placeholder</h1>
                    <p>Placeholding place Placeholding place place Placeholding place  Placeholding place Placeholding place!</p>
                </div>
                <div class="btn-container">
                    <button class="register-module-btn" id="account-btn">Get Started Today!</button>
                </div>
            </div>
            <div class="home-img-container"><img src="images/home_img.svg" id="home-img"></div>
        </div>
    </div>

    <div class="login-module" id="login-module-id">
        <div class="module-content">
            <span class="login-close-btn">&times;</span>
            <form action="login.php" method="POST" class="login-form" id="login-form-id">
                <div class="form-validation">
                    <input type="text" class="module-input" id="login-username" name="username" placeholder="Enter your username">
                    <p>Error Message</p>
                </div>
                <div class="form-validation">
                    <input type="password" class="module-input" id="login-password" name="password" placeholder="Enter your password">
                    <p>Error Message</p>
                </div>
                <input type="submit" class="login-input-btn" value="Login">
            </form>
        </div>
    </div>

    <div class="register-module" id="register-module-id">
        <div class="module-content">
            <span class="register-close-btn">&times;</span>
            <form action="register.php" method="POST" class="register-form" id="register-form-id">
                <div class="form-validation">
                    <input type="text" class="module-input" id="register-username" name="username" placeholder="Enter your username">
                    <p>Error Message</p>
                </div>
                <div class="form-validation">
                    <input type="text" class="module-input" id="register-email" name="email" placeholder="Enter your email">
                    <p>Error Message</p>
                </div>
                <div class="form-validation">
                    <input type="password" class="module-input" id="register-password" name="password" placeholder="Enter your password">
                    <p>Error Message</p>
                </div>
                <div class="form-validation">
                    <input type="password" class="module-input" id="register-password-conf" name="password-confirm" placeholder="Confirm your password">
                    <p>Error Message</p>
                </div>
                <div class="g-recaptcha" data-sitekey="6LcETuYpAAAAAJQSYwpU2nkdbGc_8hTF740s3QYu"></div>
                <input type="submit" class="register-input-btn" value="Sign Up">
            </form>
        </div>
    </div>

    <script>

        //Module-utility
        const loginModule = document.getElementById('login-module-id')
        const openLogin = document.querySelector('.login-module-btn')
        const closeLogin = document.querySelector('.login-close-btn')
        const registerModule = document.getElementById('register-module-id')
        const openRegister = document.querySelector('.register-module-btn')
        const closeRegister = document.querySelector('.register-close-btn')


        openLogin.addEventListener('click', (e) => {
            loginModule.style.display = 'block'
        })

        closeLogin.addEventListener('click', (e) => {
            loginModule.style.display = 'none'
        })

        openRegister.addEventListener('click', (e) => {
            registerModule.style.display = 'block'
        })

        closeRegister.addEventListener('click', (e) => {
            registerModule.style.display = 'none'
        })

        window.addEventListener('click', (e) => {
            if (e.target === loginModule || e.target === registerModule) {
                loginModule.style.display = 'none'
                registerModule.style.display = 'none'
            }
        })

        //Validerar input
        const loginForm = document.getElementById('login-form-id')
        const registerForm = document.getElementById('register-form-id')
        const usernameInput = document.getElementById('register-username');
        const emailInput = document.getElementById('register-email');
        const passwordInput = document.getElementById('register-password');
        const passwordConfInput = document.getElementById('register-password-conf');
        const loginUsernameInput = document.getElementById('login-username');
        const loginPasswordInput = document.getElementById('login-password');

        function showError(input, message) {
            const formValidation = input.parentElement;
            formValidation.className = 'form-validation error';
        
            const errorMessage = formValidation.querySelector('p');
            errorMessage.innerText = message;
        }
        
        function showValid(input){
            const formValidation = input.parentElement;
            formValidation.className = 'form-validation valid';
        }
        
        function checkRequired(inputArr){
            inputArr.forEach(function(input){
                if(input.value.trim() === '') {
                    showError(input, `${getFieldName(input)} is required`);
                }
            })
        }
        
        function checkEmail(input) {
            const emailRegex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
            if(!emailRegex.test(input.value)){
                showError(input, "Invalid email");
            }
        }
        
        function checkPassword(pass) {
            const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
            if(!passwordRegex.test(pass.value)) {
                showError(pass, "Invalid password");
            } else {
                showValid(pass)
            }
        }

        function checkConfPassword(pass, conf) {
            if(pass.value !== conf.value) {
                showError(conf, "Passwords does not match");
            } else if (conf.value.length > 0) {
                showValid(conf);
            } else {
                showError(conf, "Password confirmation is required");
            }
        }
        
        function getFieldName (input){
            return input.name.charAt(0).toUpperCase() + input.name.slice(1);  
        }

        const formValidations = document.querySelectorAll('.form-validation');

        registerForm.addEventListener('submit', (e) => {

            checkRequired([usernameInput, emailInput, passwordInput, passwordConfInput]);
            checkEmail(emailInput);
            checkPassword(passwordInput);
            checkConfPassword(passwordInput, passwordConfInput);

            formValidations.forEach(formValidation => {
                if (formValidation.classList.contains('error')) {
                    e.preventDefault();
                    }
                });
        })

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();

            checkRequired([loginUsernameInput, loginPasswordInput]);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'login.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        window.location.href = 'main.php';
                    } else {
                        if (response.type === 'password') {
                            showError(loginPasswordInput, response.message);
                        } else if (response.type === 'username') {
                            showError(loginUsernameInput, response.message);
                        }
                        

                        formValidations.forEach(formValidation => {
                            if (formValidation.classList.contains('error')) {
                                e.preventDefault();
                            }
                        })
                    }
                }
            };
            const formData = new FormData(loginForm);
            xhr.send(new URLSearchParams(formData));
        });

        usernameInput.addEventListener('input', (e) => {
            const username = usernameInput.value.trim();
            if (username !== '') {
                checkUsernameAvailability(username)
            } else {
                showError(usernameInput, "Username is required");
            }
        })

        emailInput.addEventListener('input', (e) => {
            const email = emailInput.value.trim();
            if (email !== '') {
                checkEmailAvailability(email, emailInput);
            } else {
                showError(emailInput, "Email is required");
            }
        })

        passwordInput.addEventListener('input', (e) => {
            const password = passwordInput.value.trim();
            if (password !== '') {
                checkPassword(passwordInput);
            } else {
                showError(passwordInput, "Password is required");
            }
        })

        passwordConfInput.addEventListener('input', (e) => {
            if (passwordConfInput !== '') {
                checkConfPassword(passwordInput, passwordConfInput);
            } else {
                showError(passwordConfInput, "Password confirmation is required");
            }
        })

        function checkUsernameAvailability(username) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'check_username.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'error') {
                            showError(usernameInput, response.message);
                        } else {
                            showValid(usernameInput);
                        }
                    }
                };
                xhr.send(`username=${encodeURIComponent(username)}`);
            }

        function checkEmailAvailability(email) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'check_email.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'error') {
                        showError(emailInput, response.message);
                    } else {
                        showValid(emailInput);
                    }
                }
            };
            xhr.send(`email=${encodeURIComponent(email)}`);
        }
    </script>
</body>
</html>