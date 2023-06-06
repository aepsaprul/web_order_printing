<div id="header-wrapper" class="w-full h-12 border-b flex justify-center items-center bg-white z-10 sticky top-0 lg:hidden">
  <div class="bg-white w-full flex justify-between items-center">
    <div class="{{ request()->is(['/', 'home', 'home/*']) ? 'hidden' : '' }}">
      <a href="{{ url('/') }}"><i class="fa fa-arrow-left pl-3 text-xl text-slate-500"></i></a>
    </div>
    <!-- <div class="relative mx-1">
      <input type="text" name="cari" placeholder="Cari produk" class="cari h-8 w-64 pl-3 border rounded-3xl text-sm focus:outline-none" autocomplete="off">
      <i class="fa fa-search absolute right-3 top-1.5 text-slate-400 text-sm"></i>
    </div> -->
    <div class="2xl:w-full">
      <div class="relative mx-1">
        <input type="text" name="cari" placeholder="Cari produk" class="cari h-8 w-44 2xl:w-full pl-3 border border-slate-500 rounded-3xl text-sm focus:outline-none" autocomplete="off">
        <i class="fa fa-search absolute right-3 top-1.5 text-slate-400 text-sm"></i>
      </div>
      <div class="hidden cari-autocomplete absolute bg-white w-72 mx-1 rounded p-1 mt-1 shadow border-t"></div>
    </div>
    <div class="relative w-10 h-10">
      <div class="w-8 h-10 flex items-center">
        <a href="{{ route('keranjang') }}"><i class="fa fa-basket-shopping text-2xl"></i></a>
      </div>
      <div class="notif-keranjang hidden">
        <div class="bg-red-600 absolute h-6 w-6 top-0 right-0 rounded-full flex items-center justify-center font-semibold text-white text-xs">
          <span class="notif-keranjang-jml py-2 px-2">1</span>
        </div>
      </div>
    </div>
    <!-- <div class="{{ request()->is([
      'produk', 
      'produk/*', 
      'kategori', 
      'kategori/*', 
      'akun', 
      'akun/*',
      'mAkun',
      'mAkun/*'
      ]) ? 'hidden' : '' }}">
      <i class="fa fa-bell mr-1 text-2xl"></i>
    </div> -->
    @auth
        <div class="relative w-10 h-10">
          <div class="w-8 h-10 flex items-center">
            <a href="#" class="notifikasi"><i class="fa fa-bell text-2xl"></i></a>
          </div>
          <div class=" 
            @if ($boot_notif)
              {{ count($boot_notif) > 0 ? "" : "hidden" }}
            @else
              hidden
            @endif
            ">
            <div class="bg-red-600 absolute h-6 w-6 top-0 right-0 rounded-full flex items-center justify-center font-semibold text-white text-xs">
              <span class="py-2 px-2">
                @if ($boot_notif)
                  {{ count($boot_notif) > 0 ? count($boot_notif) : "" }}                  
                @endif
              </span>
            </div>
          </div>
          <div class="notif-list hidden absolute bg-white w-72 -ml-56 rounded mt-1 shadow border-t"></div>      
        </div>
      @endauth
    <i id="menu" class="fa fa-bars mr-2 text-2xl"></i>
  </div>
</div>

{{-- header lg --}}
<div id="header-wrapper" class="w-full h-14 border-b bg-white sticky top-0 z-20 lg:flex justify-center hidden">
  <div class="w-10/12 2xl:w-4/5 flex justify-between items-center">
    <div class="flex 2xl:w-full">
      <div>
        <img src="{{ asset('assets/logo.png') }}" alt="logo" class="w-16">
      </div>
      <div class="ml-10 flex items-center">
        <a href="{{ url('/') }}" class="font-semibold mx-2">Home</a>
        <a href="{{ route('produk') }}" class="font-semibold mx-2">Produk</a>
        <!-- <a href="#" class="font-semibold mx-2">Cara Pesan</a> -->
        <a href="{{ route('konfirmasi_bayar') }}" class="font-semibold mx-2">Konfirmasi Bayar</a>
      </div>
    </div>
    <div class="2xl:w-full">
      <div class="relative mx-1">
        <input type="text" name="cari" placeholder="Cari produk" class="cari h-8 w-72 2xl:w-full pl-3 border border-slate-500 rounded-3xl text-sm focus:outline-none" autocomplete="off">
        <i class="fa fa-search absolute right-3 top-1.5 text-slate-400 text-sm"></i>
      </div>
      <div class="hidden cari-autocomplete absolute bg-white w-72 mx-1 rounded p-1 mt-1 shadow border-t"></div>
    </div>
    <div class="flex justify-end 2xl:w-2/4">
      <div class="relative w-10 h-10">
        <div class="w-8 h-10 flex items-center">
          <a href="{{ route('keranjang') }}"><i class="fa fa-basket-shopping text-2xl"></i></a>
        </div>
        <div class="notif-keranjang hidden">
          <div class="bg-red-600 absolute h-6 w-6 top-0 right-0 rounded-full flex items-center justify-center font-semibold text-white text-xs">
            <span class="notif-keranjang-jml py-2 px-2"></span>
          </div>
        </div>
      </div>
      @auth
        <div class="relative w-10 h-10 ml-3">
          <div class="w-8 h-10 flex items-center">
            <a href="#" class="notifikasi"><i class="fa fa-bell text-2xl"></i></a>
          </div>
          <div class=" 
            @if ($boot_notif)
              {{ count($boot_notif) > 0 ? '' : 'hidden' }}
            @else
              hidden
            @endif
            ">
            <div class="bg-red-600 absolute h-6 w-6 top-0 right-0 rounded-full flex items-center justify-center font-semibold text-white text-xs">
              <span class="py-2 px-2">
                @if ($boot_notif)
                  {{ count($boot_notif) > 0 ? count($boot_notif) : "" }}                  
                @endif
              </span>
            </div>
          </div>
          <div class="notif-list hidden absolute bg-white w-72 -ml-56 rounded mt-1 shadow border-t"></div>      
        </div>
      @endauth
      <div class="flex ml-10 items-center">
        @auth
          <a href="https://api.whatsapp.com/send/?phone=6285726269500&text=Assalamu%27alaikum+&app_absent=0" target="_blank" class="font-bold text-sm text-slate-700"><i class="fa fa-comment-dots"></i> Chat</a>
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

<script type="module">
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    $('.cari').on('focus', function () {
      let formData = {
        cari: "focus"
      }
      $.ajax({
        url: "{{ URL::route('home.cari') }}",
        type: "post",
        data: formData,
        success: function(response) {
          let val = ``;
          $.each(response.kategori, function (index, item) {
            val += `<a href="{{ url('kategori/${item.id}/show') }}"><div class="capitalize p-1 hover:bg-slate-100">${item.nama}</div></a>`;
          })
          $('.cari-autocomplete').html(val);
          $('.cari-autocomplete').removeClass('hidden');
        }
      })
    })
    $('.cari').on('blur', function () {
      setTimeout(() => {
        $('.cari-autocomplete').addClass('hidden');              
      }, 200);
    })
    $('.cari').on('keyup', function () {
      const inputCari = $(this).val();
      
      let formData = {
        cari: "keyup",
        kategori: inputCari
      }
      $.ajax({
        url: "{{ URL::route('home.cari') }}",
        type: "post",
        data: formData,
        success: function(response) {
          if (response.kategori.length > 0 || response.produk.length > 0) {
            let val = ``;
            $.each(response.produk, function (index, item) {
              val += `<a href="{{ url('produk/${item.id}/show') }}"><div class="capitalize p-1 hover:bg-slate-100">${item.nama}</div></a>`;
            })
            $.each(response.kategori, function (index, item) {
              val += `<a href="{{ url('kategori/${item.id}/show') }}"><div class="capitalize p-1 hover:bg-slate-100">${item.nama}</div></a>`;
            })
            $('.cari-autocomplete').html(val);
            $('.cari-autocomplete').removeClass('hidden');            
          } else {
            $('.cari-autocomplete').addClass('hidden');
          }
        }
      })
    })

    // notifikasi
    $('.notifikasi').on('click', function (e) {
      e.preventDefault();
      
      $.ajax({
        url: "{{ URL::route('notif.list') }}",
        type: "get",
        success: function (response) {
          if (response.notif.length > 0) {
            let val = ``;
            $.each(response.notif, function (index, item) {
              val += `
              <a href="{{ url('${item.link}') }}">
                <div class="text-sm bg-emerald-200 rounded p-2 m-1">
                  ${item.deskripsi}
                </div>
              </a>
              `;
            })
            val += `
              <div class="text-center my-2">
                <a href="#" class="notif-tandai-sudah-dibaca text-sky-500">Tandai sudah dibaca</a>
              </div>
            `;
            $('.notif-list').html(val);
            $('.notif-list').removeClass('hidden');
          }
        }
      })
    })
    $('.notifikasi').on('blur', function () {
      setTimeout(() => {
        $('.notif-list').addClass('hidden');        
      }, 200);
    })
    
    $('body').on('click', '.notif-tandai-sudah-dibaca', function (e) {
      e.preventDefault();
      $.ajax({
        url: "{{ URL::route('notif.tandai') }}",
        success: function (response) {
          window.location.reload();
        }
      })
    })
  })
</script>