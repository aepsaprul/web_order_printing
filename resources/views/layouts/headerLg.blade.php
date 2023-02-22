<div id="header-wrapper" class="w-full h-14 border-b bg-white sticky top-0 z-20 lg:flex justify-center hidden">
  <div class="w-4/5 flex justify-between items-center">
    <div class="flex">
      <div>
        <img src="{{ asset('assets/logo.png') }}" alt="logo" class="w-16">
      </div>
      <div class="ml-10">
        <a href="{{ url('/') }}" class="font-semibold mx-2">Home</a>
        <a href="{{ route('produk') }}" class="font-semibold mx-2">Produk</a>
        <a href="#" class="font-semibold mx-2">Cara Pesan</a>
        <a href="#" class="font-semibold mx-2">Konfirmasi Bayar</a>
      </div>
    </div>
    <div class="flex">
      <div>
        <i class="fa fa-shopping-cart text-xl"></i>
      </div>
      <div class="flex ml-10">
        <a href="#">Register</a>
        <div class="border-l mx-4"></div>
        <a href="#">Login</a>
      </div>
    </div>
  </div>
</div>