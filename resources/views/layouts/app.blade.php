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
<body>
  <div class="pb-16">
    <div id="header-wrapper" class="w-full h-12 border-b flex justify-center items-center bg-white sticky top-0">
      <div class="w-full flex justify-between items-center">
        <div class="relative mx-1">
          <input type="text" name="cari" id="cari" placeholder="Cari produk" class="h-8 w-52 pl-3 border rounded-3xl text-sm">
          <i class="fa fa-search absolute right-3 top-1.5 text-slate-400 text-sm"></i>
        </div>
        <i class="fa fa-envelope mx-1 text-xl"></i>
        <i class="fa fa-bell mx-1 text-xl"></i>
        <i class="fa fa-bars mr-2 text-xl"></i>
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
      <i class="fa fa-list"></i>
      <span class="text-xs">Transaksi</span>
    </a>
    <a href="#" class="flex flex-col text-center w-full">
      <i class="fa fa-sign-in"></i>
      <span class="text-xs">Login</span>
    </a>
    <a href="#" class="flex flex-col text-center w-full">
      <i class="fa fa-user-plus"></i>
      <span class="text-xs">Register</span>
    </a>
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
  </script>
</body>
</html>