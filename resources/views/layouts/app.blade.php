<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="{{ asset('assets/logo-daun.png') }}" type="image/x-icon">
  <title>Selamat Datang</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('swiper/swiper.css') }}">

  @yield('style')
</head>
<body class="font-sans">
  <div class="">
    <div id="menu_id" class="w-0 min-h-screen fixed z-30 top-0 overflow-x-hidden bg-white transition-all delay-150 duration-700">
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

  <script>
    function afRupiah(nominal) {
      var	number_string = nominal.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
      if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
      return rupiah;
    }
    // menu
    if (document.getElementById('menu')) {
      document.getElementById('menu').onclick = function() {
        bukaNavigasi();
      }      
    }
    document.getElementById('btn_close').onclick = function() {
      tutupNavigasi();
    }
  
    function bukaNavigasi() {
      document.getElementById("menu_id").style.width = "100%";
    }
  
    function tutupNavigasi() {
      document.getElementById("menu_id").style.width = "0%";
    }

    // header sticky
    var header = document.getElementById("header-wrapper");
    if (header) {
      var sticky = header.offsetTop;      
    }

    function myFunction() {
      if (window.pageYOffset >= sticky) {
        header.classList.add("sticky")
      } else {
        header.classList.remove("sticky");
      }
    }
  </script>

  @yield('script')
</body>
</html>