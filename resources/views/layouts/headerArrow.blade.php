<div id="header-wrapper" class="w-full h-12 border-b flex justify-center items-center bg-white sticky top-0 lg:hidden z-20">
  <div class="bg-white w-full flex justify-between items-center">
    <a href="{{ url('/') }}"><i class="fa fa-arrow-left pl-3 text-xl text-slate-500"></i></a>
    <div class="relative mx-1">
      <input type="text" name="cari" id="cari" placeholder="Cari produk" class="h-8 w-64 pl-3 border rounded-3xl text-sm">
      <i class="fa fa-search absolute right-3 top-1.5 text-slate-400 text-sm"></i>
    </div>
    <div class="relative w-10 h-10">
      <div class="w-8 h-10 flex items-center">
        <a href="{{ route('keranjang') }}"><i class="fa fa-basket-shopping text-2xl"></i></a>
      </div>
      <div class="bg-red-600 absolute h-6 w-6 top-0 right-0 rounded-full flex items-center justify-center font-semibold text-white text-xs">
        <span class="py-2 px-2">1</span>
      </div>
    </div>
    <i id="menu" class="fa fa-bars mr-2 text-xl"></i>
  </div>
</div>