<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Selamat Datang</title>

  @vite('resources/css/app.css')
  <link rel="stylesheet" href="{{ asset('swiper/swiper.css') }}">
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
    <div>
      <div class="swiper gambarSlider">
        <div class="swiper-wrapper">
          @foreach ($slide as $item)
            <div class="swiper-slide">
              <img src="{{ url('http://localhost/abata_web_order_admin/public/img_slide/' . $item->gambar) }}" alt="slide">
            </div>            
          @endforeach
        </div>
      </div>
    </div>
    <div>
      <h1 class="text-center font-bold my-5 text-xl text-slate-500">Kategori Produk</h1>
      <div class="grid grid-cols-4 gap-3">
        @foreach ($kategori as $item)
          <a href="#">
            <div>
              <div class="flex justify-center">
                <img src="{{ url('http://localhost/abata_web_order_admin/public/img_kategori/' . $item->gambar) }}" alt="kategori" class="w-20">
              </div>
              <div class="text-center font-semibold mt-2">{{ $item->nama }}</div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
    <div>
      <h1 class="text-center font-bold my-5 text-xl text-slate-500">Produk</h1>
      <div class="grid grid-cols-2 gap-1">
        @foreach ($produk as $item)
          <div class="m-2">
            <div>
              <img src="{{ $item->gambar }}" alt="gambar" class="w-48">
            </div>
            <div class="text-sm text-center">{{ $item->nama }}</div>
            <div class="text-sm text-center">{{ $item->harga }}</div>
          </div>
        @endforeach
      </div>
    </div>
    <div>
      <h1 class="text-center font-bold my-5 text-xl text-slate-500">Cara Pesan</h1>
      <div><img src="{{ url('http://localhost/abata_web_order_admin/public/img_cara_pesan_gambar/' . $cara_pesan_gambar->gambar) }}" alt="gambar cara pesan" class="hidden"></div>
      <div>
        @foreach ($cara_pesan as $key => $item)
          <div class="bg-slate-600 text-white m-3 p-2 rounded-sm"><p>{{ $key + 1 }}. {{ $item->nama }}</p></div>
        @endforeach
      </div>
    </div>
  </div>
  {{-- navigasi bawah --}}
  <div class="w-full fixed bottom-0 bg-white flex justify-between border-t py-2">
    <div class="flex flex-col text-center w-full">
      <i class="fa fa-home"></i>
      <span class="text-xs">Home</span>
    </div>
    <div class="flex flex-col text-center w-full">
      <i class="fa fa-list"></i>
      <span class="text-xs">Transaksi</span>
    </div>
    <div class="flex flex-col text-center w-full">
      <i class="fa fa-sign-in"></i>
      <span class="text-xs">Login</span>
    </div>
    <div class="flex flex-col text-center w-full">
      <i class="fa fa-user-plus"></i>
      <span class="text-xs">Register</span>
    </div>
  </div>

  {{-- swiper --}}
  <script src="{{ asset('swiper/swiper.js') }}"></script>

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