<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
</head>
<body>
    <h1>Halo, {{ $user->name }}</h1>
    <p>
        Terima kasih telah mendaftar di {{ config('app.name') }}. 
        Klik tombol di bawah untuk memverifikasi email Anda:
    </p>
    <a href="{{ $verificationUrl }}" style="background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;">
        Verifikasi Email
    </a>
    <p>Jika Anda tidak mendaftar, abaikan email ini.</p>
</body>
</html>
