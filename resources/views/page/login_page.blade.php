<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <div class="container-kiri">
        <img src="{{ asset('assets/fotos/1.png') }}" alt="">
    </div>
    <div class="container-kanan">
        <div class="form-login">
            <h2 class="Judul">Welcome</h2>
            <div class="form">
                <form action="/action_page.php">
                    <input type="text" id="phone_number_or_email" name="phone_number_or_email"
                        placeholder="Masukkan nomor telepon atau email Anda" required>
                    <input type="text" id="password" name="password" placeholder="Masukkan Kata Sandi Anda"
                        required>
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
                </form>
            </div>
        </div>
    </div>
</body>

</html>
