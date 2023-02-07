<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>

  @vite('resources/css/app.css')
</head>
<body>
  <div class="w-full h-12 bg-white border-b flex justify-between items-center">
    <div class="mx-3"><a href="{{ url('/') }}"><i class="fas fa-arrow-left text-lg mr-3"></i></a> <span class="font-bold">Login</span></div>
    <div class="mx-3"><a href="{{ route('register') }}" class="text-indigo-600 font-bold">Register</a></div>
  </div>
  <div class="mt-10">
    <form action="{{ route('login.auth') }}" method="post">
      @csrf
      <div class="m-4">
        <input type="email" name="email" id="email" class="w-full h-10 pl-3 border rounded-sm @error('email') is-invalid @enderror" placeholder="Email">
        @error('email') {{ $message }} @enderror
      </div>
      <div class="m-4">
        <input type="password" name="password" id="password" class="w-full h-10 pl-3 border rounded-sm" placeholder="Password">
      </div>
      <div class="mx-4 my-5">
        <label for="remember" class="flex items-center">
          <input type="checkbox" name="remember" id="remember" class="w-4 h-4 mr-2"> <span>Ingat Saya</span>
        </label>
      </div>
      <div class="m-4">
        <button type="submit" class="w-full p-2 rounded-md bg-indigo-600 text-white font-bold uppercase">masuk</button>
      </div>
    </form>
  </div>
</body>
</html>