<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Selamat Datang</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('swiper/swiper.css') }}">

  @yield('style')
</head>
<body class="font-sans">
  <div class="pb-16">
    <div id="menu_id" class="w-0 min-h-screen fixed z-10 top-0 overflow-x-hidden bg-white transition-all delay-150 duration-700">
    {{-- <div id="menu_id" class="w-full fixed min-h-screen z-10 top-0 bg-slate-50 transition-all delay-150 duration-700"> --}}
      <div id="btn_close" class="text-right mt-5">
        <span class="text-2xl m-3 px-4 py-2 rounded-full border-b">X</span>
      </div>
      <div class="mt-5 border-b p-3">
        <a href="{{ route('kategori') }}"><i class="fa fa-folder-tree w-8 text-center text-slate-500"></i> Kategori</a>
      </div>
      <div class="border-b p-3">
        <a href="#"><i class="fa fa-list w-8 text-center text-slate-500"></i> Transaksi</a>
      </div>
      <div class="border-b p-3">
        <a href="#"><i class="fa fa-money-bill-wave w-8 text-center text-slate-500"></i> Konfirmasi Pembayaran</a>
      </div>
    </div>
    @yield('content')
  </div>

  {{-- swiper --}}
  <script src="{{ asset('swiper/swiper.js') }}"></script>

  @yield('script')
</body>
</html>