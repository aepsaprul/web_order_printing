<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="{{ asset('assets/logo-daun.png') }}" type="image/x-icon">
  <title>@yield('title')</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('swiper/swiper.css') }}">

  @yield('style')
</head>
<body class="font-sans bg-slate-100">
  <div class="">
    <div id="menu_id" class="w-0 min-h-screen fixed z-30 top-0 overflow-x-hidden bg-white transition-all delay-150 duration-700">
      <div id="btn_close" class="text-right mt-5">
        <span class="text-2xl m-3 px-4 py-2 rounded-full border-b">X</span>
      </div>
      <div class="border-b p-3">
        <a href="{{ route('konfirmasi_bayar') }}"><i class="fa fa-money-bill-wave w-8 text-center text-slate-500"></i> Konfirmasi Pembayaran</a>
      </div>
    </div>
    @yield('content')
  </div>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-9C884C8201"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-9C884C8201');
  </script>

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
  </script>

  <script type="module">
    
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

    // notif keranjang
    var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
    if (loggedIn) {
      notifKeranjang();      
    }
    function notifKeranjang() {
      $.ajax({
        url: "{{ URL::route('keranjang.ajaks') }}",
        type: "get",
        success: function (response) {
          const jml_keranjang = response.keranjang.length;
          if (jml_keranjang > 0) {
            $('.notif-keranjang').removeClass('hidden');
            $('.notif-keranjang-jml').html(jml_keranjang);            
          }
        }
      })
    }
  </script>

  @yield('script')
</body>
</html>