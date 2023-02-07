<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Selamat Datang</title>

  @vite('resources/css/app.css')
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
  {{-- navigasi bawah --}}
  <div class="w-full fixed bottom-0 bg-white flex justify-between border-t py-2">
    <a href="{{ url('/') }}" class="flex flex-col text-center w-full">
      <i class="fa fa-home"></i>
      <span class="text-xs">Home</span>
    </a>
    <a href="#" class="flex flex-col text-center w-full">
      <i class="fa-solid fa-rectangle-list"></i>
      <span class="text-xs">Transaksi</span>
    </a>
    @auth
      <a href="#" class="flex flex-col text-center w-full">
        <i class="fa fa-comment-dots"></i>
        <span class="text-xs">Chat</span>
      </a>
      <a href="{{ route('akun') }}" class="flex flex-col text-center w-full">
        <i class="fa fa-user"></i>
        <span class="text-xs">Akun</span>
      </a>
    @else
      <a href="{{ route('login') }}" class="flex flex-col text-center w-full">
        <i class="fa fa-sign-in"></i>
        <span class="text-xs">Login</span>
      </a>
      <a href="{{ route('register') }}" class="flex flex-col text-center w-full">
        <i class="fa fa-user-plus"></i>
        <span class="text-xs">Register</span>
      </a>
    @endauth
  </div>

  {{-- swiper --}}
  <script src="{{ asset('swiper/swiper.js') }}"></script>

  @yield('script')
  
  <script>
    // slider
    var swiper = new Swiper(".gambarSlider", {
      pagination: {
        el: ".swiper-pagination",
        clickable: true
      },
      loop: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });

    window.onscroll = function() {
      myFunction();
    };
    
    // header sticky
    var header = document.getElementById("header-wrapper");
    var sticky = header.offsetTop;

    function myFunction() {
      if (window.pageYOffset >= sticky) {
        header.classList.add("sticky")
      } else {
        header.classList.remove("sticky");
      }
    }

    // menu
    document.getElementById('menu').onclick = function() {
      bukaNavigasi();
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
  </script>
</body>
</html>