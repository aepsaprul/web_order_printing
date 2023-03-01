<div id="header-wrapper" class="w-full h-14 border-b bg-white sticky top-0 z-20 lg:flex justify-center hidden">
  <div class="w-4/5 flex justify-between items-center">
    <div class="flex">
      <div>
        <img src="{{ asset('assets/logo.png') }}" alt="logo" class="w-16">
      </div>
      <div class="ml-10 flex items-center">
        <a href="{{ url('/') }}" class="font-semibold mx-2">Home</a>
        <a href="{{ route('produk') }}" class="font-semibold mx-2">Produk</a>
        <a href="#" class="font-semibold mx-2">Cara Pesan</a>
        <a href="#" class="font-semibold mx-2">Konfirmasi Bayar</a>
      </div>
    </div>
    <div class="flex">
      <div>
        <a href="{{ route('keranjang') }}"><i class="fa fa-basket-shopping text-xl"></i></a>
      </div>
      <div class="flex ml-10 items-center">
        @auth
          <a href="#" class="font-bold text-sm text-slate-700"><i class="fa fa-comment-dots"></i> Chat</a>
          <div class="border-l h-full mx-4 border-slate-300"></div>
          <a href="{{ route('akun') }}" class="font-bold text-sm text-slate-700"><i class="fa fa-user"></i> Akun</a>
        @else
          <a href="{{ route('register') }}" class="font-bold text-sm text-slate-700">Register</a>
          <div class="border-l h-full mx-4 border-slate-300"></div>
          <a href="{{ route('login') }}" class="font-bold text-sm text-slate-700">Login</a>
        @endauth
      </div>
    </div>
  </div>
</div>