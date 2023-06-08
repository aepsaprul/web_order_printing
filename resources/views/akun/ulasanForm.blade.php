@extends('akun.index')

@section('title') {{ 'Ulasan Form' }} @endsection

@section('content_akun')

<div class="bg-white p-3 rounded border flex justify-between">
  <div class="font-bold text-lg">Ulasan</div>
  <div><a href="{{ url()->previous() }}" class="bg-rose-500 rounded text-white text-sm px-3 py-2"><i class="fa fa-arrow-left"></i> Kembali</a></div>
</div>
<div class="p-3 mt-1 border rounded bg-white flex justify-center">
  <form class="flex justify-center">
    <div class="flex w-3/4">
      <div class="w-1/3">
        <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $produk->gambar) }}" alt="gambar produk" class="w-full">
        <div class="mt-2 text-center">{{ $produk->nama }}</div>
      </div>
      <div class="w-2/3 p-3">
        <input type="hidden" name="keranjang_id" id="keranjang_id" value="{{ $keranjang->id }}">
        <input type="hidden" name="produk_id" id="produk_id" value="{{ $keranjang->produk_id }}">
        <div>
          <div class="stars text-slate-300 text-2xl">
            <i class="fas fa-star cursor-pointer" data-id="1"></i>
            <i class="fas fa-star cursor-pointer" data-id="2"></i>
            <i class="fas fa-star cursor-pointer" data-id="3"></i>
            <i class="fas fa-star cursor-pointer" data-id="4"></i>
            <i class="fas fa-star cursor-pointer" data-id="5"></i>
          </div>
          <em class="error-star text-rose-500 text-sm"></em>
          <input type="hidden" id="star_val" value="0">
        </div>
        <div class="mt-4">
          <textarea name="catatan" id="catatan" rows="3" placeholder="Catatan" class="border w-full p-2 rounded outline-none"></textarea>
        </div>
        <div class="mt-3 flex justify-end">
          <div class="w-32 rounded relative flex items-center justify-center">
            <div id="loading_kirim" class="hidden absolute">
              <div class="flex items-center">
                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-slate-100 animate-spin mr-3">
                  <div class="h-2 w-2 rounded-full bg-white"></div>
                </div>
                <span class="text-xs">Loading. . .</span>
              </div>
            </div>
            <button id="ulasan_btn_kirim" class="w-44 bg-sky-500 border rounded text-white text-sm font-bold py-2"><i class="fa fa-paper-plane"></i> Kirim</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Select all elements with the "i" tag and store them in a NodeList called "stars"
    const stars = document.querySelectorAll(".stars i");

    // Loop through the "stars" NodeList
    stars.forEach((star, index1) => {
      // Add an event listener that runs a function when the "click" event is triggered
      star.addEventListener("click", () => {
        const star_id = $(star).attr('data-id');
        $('#star_val').val(star_id);
        
        // Loop through the "stars" NodeList Again
        stars.forEach((star, index2) => {
          // Add the "active" class to the clicked star and any stars with a lower index
          // and remove the "active" class from any stars with a higher index
          index1 >= index2 ? star.classList.add("text-yellow-500") : star.classList.remove("text-yellow-500");
        });
      });
    });

    // ulasan btn kirim
    $(document).on('click', '#ulasan_btn_kirim', function (e) {
      e.preventDefault();
      const keranjang_id = $('#keranjang_id').val();
      const produk_id = $('#produk_id').val();
      const keterangan = $('#catatan').val();
      const rating = Number($('#star_val').val());

      if (rating == 0) {     
        let val = `Pilih Bintang terlebih dahulu`;
        $('.error-star').html(val);
      } else {
        let formData = {
          keranjang_id: keranjang_id,
          produk_id: produk_id,
          keterangan: keterangan,
          rating: rating
        }
  
        $.ajax({
          url: "{{ URL::route('akun.ulasan.store') }}",
          type: "post",
          data: formData,
          beforeSend: function () {
            $('#loading_kirim').removeClass('hidden');
            $('#ulasan_btn_kirim').removeClass('bg-sky-500');
          },
          success: function (response) {
            $('#notif').removeClass('hidden');
            window.location.href = "{{ URL::route('akun.ulasan') }}";
  
            setTimeout(() => {
              $('#loading_kirim').addClass('hidden');
              $('#ulasan_btn_kirim').addClass('bg-sky-500');
            }, 1000);
          }
        })
      }
    })
  })
</script>
@endsection