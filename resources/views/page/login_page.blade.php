<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://kit.fontawesome.com/8b6c8483e0.js" crossorigin="anonymous"></script>
    <style>
        .form-login {
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .form-login.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Style untuk ikon mata */
        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 37%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
        }

        .password-toggle:hover {
            color: #333;
        }
    </style>
</head>

<body>

    <div class="container-kiri">
        <img src="{{ asset('assets/fotos/1.png') }}" alt="">
    </div>
    <div class="container-kanan">
        <div class="form-login active" id="login-form">
            <h2 class="Judul">Welcome</h2>
            <div class="form">
                <form method="POST" action="{{ route('prosseslogin') }}">
                    @csrf
                    <input type="text" id="login-email" name="email" placeholder="Masukkan email Anda" required>
                    <div class="password-container">
                        <input type="password" id="login-password" name="password"
                            placeholder="Masukkan Kata Sandi Anda" required>
                        <span class="password-toggle" onclick="togglePassword('login-password')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <a href="/" class="LP">Lupa Kata Sandi?</a>
                    <input type="submit" value="Masuk">
                    <div class="line-container">
                        <span class="line"></span>
                        <span class="text">OR</span>
                        <span class="line"></span>
                    </div>
                    <div class="header">
                        <img src="{{ asset('assets/fotos/Logo_Google.png') }}" alt="Google Logo">
                        <p>Masuk Menggunakan Google</p>
                    </div>
                    <p>Belum punya akun ? <a href="#" onclick="toggleForm('register-form', 'login-form')">Daftar
                            disini</a></p>
                </form>
            </div>
        </div>
        <!-- Register Form -->
        <div class="form-login" id="register-form" style="display: none;">
            <h2 class="Judul">Welcome</h2>
            <div class="form">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="text" id="register-username" name="username" placeholder="Username" required>
                    <input type="email" id="register-email" name="email" placeholder="Email" required
                        style="margin-bottom: 14px">
                    <div class="password-container">
                        <input type="password" id="register-password" name="password" placeholder="Password" required>
                        <span class="password-toggle" onclick="togglePassword('register-password')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <input type="text" id="register-full_name" name="full_name" placeholder="Full Name" required>
                    <input type="text" id="register-address" name="address" placeholder="Address" required>
                    <input type="submit" value="Register">
                    <div class="line-container">
                        <span class="line"></span>
                        <span class="text">OR</span>
                        <span class="line"></span>
                    </div>
                    <div class="header">
                        <img src="{{ asset('assets/fotos/Logo_Google.png') }}" alt="Google Logo">
                        <p>Register Using Google</p>
                    </div>
                    <p>Sudah punya akun ? <a href="#" onclick="toggleForm('login-form', 'register-form')">Login
                            disini</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleForm(formToShow, formToHide) {
            var formToHideElement = document.getElementById(formToHide);
            formToHideElement.classList.remove('active');
            setTimeout(function() {
                formToHideElement.style.display = 'none';
                var formToShowElement = document.getElementById(formToShow);
                formToShowElement.style.display = 'block';
                setTimeout(function() {
                    formToShowElement.classList.add('active');
                }, 100);
            }, 300);
        }

        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);
            var passwordToggleIcon = passwordInput.nextElementSibling.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggleIcon.classList.remove('fa-eye');
                passwordToggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggleIcon.classList.remove('fa-eye-slash');
                passwordToggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
