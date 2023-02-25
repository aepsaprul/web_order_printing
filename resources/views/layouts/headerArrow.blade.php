<div id="header-wrapper" class="w-full h-12 border-b flex justify-center items-center bg-white sticky top-0 lg:hidden z-20">
  <div class="bg-white w-full flex justify-between items-center">
    <a href="{{ url('/') }}"><i class="fa fa-arrow-left pl-3 text-xl text-slate-500"></i></a>
    <div class="relative mx-1">
      <input type="text" name="cari" id="cari" placeholder="Cari produk" class="h-8 w-64 pl-3 border rounded-3xl text-sm">
      <i class="fa fa-search absolute right-3 top-1.5 text-slate-400 text-sm"></i>
    </div>
    <a href="{{ route('keranjang') }}"><i class="fa fa-basket-shopping mx-1 text-xl"></i></a>
    <i id="menu" class="fa fa-bars mr-2 text-xl"></i>
  </div>
</div>

<script>
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