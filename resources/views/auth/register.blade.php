<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register</title>
</head>
<body>
  <form action="{{ route('register.store') }}" method="POST">
    @csrf
    <input type="text" name="nama_lengkap" id="nama_lengkap" class="@error('nama_lengkap') is-invalid @enderror" placeholder="Nama" autofocus required>
    <input type="email" name="email" id="email" class="@error('email') is-invalid @enderror" placeholder="Email" required>
    <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror" placeholder="Password" required>
    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" placeholder="Konfirmasi Password">
    <button type="submit">Daftar</button>
  </form>
</body>
</html>