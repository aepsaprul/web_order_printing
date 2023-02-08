@extends('layouts.app')

@section('content')
<div class="w-full h-12 bg-white border-b flex justify-between items-center">
  <div class="mx-3"><a href="{{ url('/') }}"><i class="fas fa-arrow-left text-lg text-indigo-600 mr-3"></i></a> <span class="font-bold">Masuk</span></div>
  <div class="mx-3"><a href="{{ route('register') }}" class="text-indigo-600 font-bold">Daftar</a></div>
</div>
<div class="mt-10">
  <form action="{{ route('login.auth') }}" method="post">
    @csrf
    <div class="m-4">
      <input type="email" name="email" id="email" class="w-full h-10 pl-3 border rounded-sm outline-0 @error('email') is-invalid @enderror" placeholder="Email">
      @error('email') {{ $message }} @enderror
    </div>
    <div class="m-4">
      <input type="password" name="password" id="password" class="w-full h-10 pl-3 border rounded-sm outline-0" placeholder="Password">
    </div>
    <div class="mx-4 my-5">
      <label for="remember" class="flex items-center">
        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 mr-2 outline-0"> <span>Ingat Saya</span>
      </label>
    </div>
    <div class="m-4">
      <button type="submit" class="w-full p-2 rounded-md bg-indigo-600 text-white font-bold uppercase">masuk</button>
    </div>
  </form>
</div>
<div class="fixed bottom-0 right-0 left-0">
  <div class="h-12 bg-indigo-100 text-center flex items-center justify-center">
    <p>Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-800 font-semibold">Daftar</a></p>
  </div>
</div>
@endsection