@extends('layouts.app')

@section('title') {{ 'Login' }} @endsection

@section('content')
<div class="lg:flex lg:justify-center lg:items-center lg:min-h-screen">
  <div class="bg-white lg:w-1/4 lg:border lg:border-slate-200 lg:rounded">
    <div class="w-full h-12 bg-white border-b flex justify-between items-center">
      <div class="mx-3"><a href="{{ url('/') }}"><i class="fas fa-arrow-left text-lg text-sky-600 mr-3"></i></a> <span class="font-bold">Masuk</span></div>
      <div class="mx-3"><a href="{{ route('register') }}" class="text-sky-600 font-bold">Daftar</a></div>
    </div>
    <div class="mt-5">
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
          <button type="submit" class="w-full p-2 rounded-md bg-sky-600 text-white font-bold uppercase">masuk</button>
        </div>
      </form>
    </div>
    <div class="fixed lg:static bottom-0 right-0 left-0">
      <div class="h-12 bg-sky-100 text-center flex items-center justify-center">
        <p class="lg:text-xs">Belum punya akun? <a href="{{ route('register') }}" class="text-sky-800 font-semibold">Daftar</a></p>
      </div>
    </div>
  </div>
</div>
@endsection