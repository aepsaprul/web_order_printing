@extends('layouts.app')

@section('content')

@include('layouts.header')
@include('layouts.headerLg')


{{-- <div class="bg-gray-200 w-32 h-32 flex justify-center items-center">
  <div class="flex min-h-screen w-full items-center justify-center bg-gray-200"> --}}
    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-slate-100 animate-spin">
      <div class="h-3 w-3 rounded-full bg-white"></div>
    </div>
  {{-- </div>
</div> --}}

@include('layouts.navBawah')
@include('layouts.footer')

@endsection