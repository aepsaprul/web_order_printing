<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
</head>
<body>
  <form action="{{ route('login.auth') }}" method="post">
    @csrf
    <input type="email" name="email" id="email" class="@error('email') is-invalid @enderror" placeholder="Email">
    @error('email') {{ $message }} @enderror
    <input type="password" name="password" id="password">
    <input type="checkbox" name="remember" id="remember"> Ingat Saya
    <button type="submit">masuk</button>
  </form>
</body>
</html>