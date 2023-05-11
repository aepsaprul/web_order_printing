@extends('akun.index')

@section('content_akun')

<div class="bg-white p-3 rounded border flex justify-between">
  <div class="font-bold text-lg">Data Diri</div>
  <div>
    @if (Auth::user()->segmen == "member")
      <div class="capitalize font-bold text-emerald-500 rounded-full shadow px-2"><i class="fas fa-ribbon"></i> {{ Auth::user()->segmen }}</div>
    @else
      <button class="bg-emerald-600 text-white text-sm font-semibold rounded py-1 px-3">Daftar Member</button>
    @endif
  </div>
</div>
<div class="p-3 mt-1 border rounded bg-white flex">
  <div class="w-1/3">
    <div class="p-3 rounded-lg border shadow-md">
      <div class="w-60 h-60 bg-sky-400">
        @if (Auth::user()->gambar)
          <img src="{{ asset('img_customer/' . Auth::user()->gambar) }}" alt="img" class="object-cover h-full w-full">
        @else
          <img src="{{ asset('assets/1665988705.jpg') }}" id="preview_image" alt="img" class="object-cover h-full w-full">
        @endif
      </div>
      <div class="my-4">
        <p class="text-sm">Ganti Foto</p>
        <form id="form_gambar" method="post" enctype="multipart/form-data">
          {{-- data hidden --}}
          <input type="hidden" name="akun_id" id="akun_id" value="{{ Auth::user()->id }}">
          <input type="file" name="gambar" id="gambar" class="w-full border text-sm rounded bg-cover">
        </form>
      </div>
      <div>
        <p class="text-sm text-center mt-3">Gambar maksimal 3Mb, Tipe gambar JPG, JPEG, PNG</p>
      </div>
    </div>
  </div>
  <div class="px-5 w-2/3">
    <div class="mb-5">
      <div class="flex">
        <div class="w-44 text-slate-700">Nama Lengkap</div>
        <div class="mr-5 text-slate-700 capitalize">{{ Auth::user()->nama_lengkap }}</div>
        <div>
          <a href="#" id="ubah_nama_lengkap" class="text-sm text-sky-500"
            data-te-toggle="modal"
            data-te-target="#exampleModalCenter"
            data-te-ripple-init
            data-te-ripple-color="light">ubah</a>
        </div>
      </div>
      
    </div>
    <div class="mb-5">
      <div class="flex">
        <div class="w-44 text-slate-700">Tanggal Lahir</div>
        <div class="mr-5 text-slate-700">
          @php
            $date = Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->locale('id');
            $date->settings(['formatFunction' => 'translatedFormat']);
          @endphp
          {{ Auth::user()->tanggal_lahir ? $date->format('d F Y') : '-' }}
        </div>
        <div>
          <a href="#" id="ubah_tanggal_lahir" class="text-sm text-sky-500"
            data-te-toggle="modal"
            data-te-target="#exampleModalCenter"
            data-te-ripple-init
            data-te-ripple-color="light">ubah</a>
        </div>
      </div>            
    </div>
    <div class="mb-5">
      <div class="flex">
        <div class="w-44 text-slate-700">Jenis Kelamin</div>
        <div class="mr-5 text-slate-700 capitalize">{{ Auth::user()->jenis_kelamin ? Auth::user()->jenis_kelamin : '-' }}</div>
        <div>
          <a href="#" id="ubah_jenis_kelamin" class="text-sm text-sky-500"
            data-te-toggle="modal"
            data-te-target="#exampleModalCenter"
            data-te-ripple-init
            data-te-ripple-color="light">ubah</a>
        </div>
      </div>            
    </div>
    <div class="mb-5">
      <div class="flex">
        <div class="w-44 text-slate-700">Email</div>
        <div class="mr-5 text-slate-700">{{ Auth::user()->email }}</div>
      </div>            
    </div>
    <div class="mb-5">
      <div class="flex">
        <div class="w-44 text-slate-700">Nomor HP</div>
        <div class="mr-5 text-slate-700">{{ Auth::user()->telepon }}</div>
      </div>            
    </div>
    <div class="mt-5">
      <h5 class="font-semibold">Alamat</h5>
      <div>
        <p class="text-sm uppercase">{{ Auth::user()->alamat ? Auth::user()->alamat : '-' }}, Kecamatan {{ Auth::user()->kecamatan ? Auth::user()->dataKecamatan->kecamatan : '-' }}, Kabupaten/Kota {{ Auth::user()->kabupaten ? Auth::user()->dataKabupaten->kabupaten : '-' }}, Provinsi {{ Auth::user()->provinsi ? Auth::user()->dataProvinsi->provinsi : '-' }}, Kodepos {{ Auth::user()->kodepos ? Auth::user()->kodepos : '-' }}</p>
        <div>
          <a href="#" id="ubah_alamat" class="text-sm text-sky-500"
            data-te-toggle="modal"
            data-te-target="#modalAlamat"
            data-te-ripple-init
            data-te-ripple-color="light">ubah</a>
        </div>
      </div>
    </div>
    <div class="mt-5">
      <a class="border py-2 px-7 rounded-lg font-bold text-sm" href="{{ route('akun.ubahPassword') }}">Ubah Kata Sandi</a>
    </div>
  </div>
</div>

{{-- modal --}}
<div
  data-te-modal-init
  class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
  id="exampleModalCenter"
  data-te-backdrop="static"
  data-te-keyboard="false"
  tabindex="-1"
  aria-labelledby="exampleModalCenterTitle"
  aria-modal="true"
  role="dialog">
  <div
    data-te-modal-dialog-ref
    class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
    <div
      class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-2xl shadow-sky-900 outline-none">
      <div
        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4">
        <h5
          class="modal-title text-xl font-medium leading-normal text-neutral-800"
          id="exampleModalScrollableLabel">
          Modal title
        </h5>
        <button
          type="button"
          class="btn_close box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
          data-te-modal-dismiss
          aria-label="Close">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="relative p-4">
        <p class="modal-content">This is a vertically centered modal.</p>
      </div>
      <div
        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4">
        <div class="relative flex items-center justify-center">
          <div id="loading" class="hidden absolute">
            <div class="flex items-center justify-center">
              <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                <div class="h-2 w-2 rounded-full bg-white"></div>
              </div>
            </div>
          </div>
          <button
            type="button"
            class="btn-simpan ml-1 inline-block rounded border border-sky-600 bg-primary px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out">
            Simpan
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- modal alamat --}}
<div class="flex justify-center">
  <div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="modalAlamat"
    data-te-backdrop="static"
    data-te-keyboard="false"
    tabindex="-1"
    aria-labelledby="modalAlamatLabel"
    aria-modal="true"
    role="dialog">
    <div
      data-te-modal-dialog-ref
      class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
      <div
        class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-2xl shadow-sky-900 outline-none">
        <div
          class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4">
          <h5
            class="modal-alamat-title text-xl font-medium leading-normal text-neutral-800"
            id="exampleModalScrollableLabel">
            Modal title
          </h5>
          <button
            type="button"
            class="-my-2 -mr-2 ml-auto box-content h-4 w-4 rounded-none border-none p-2 hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
            data-te-modal-dismiss
            aria-label="Close">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 16 16"
              fill="currentColor">
              <path
                d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z" />
            </svg>
          </button>
        </div>
        <div class="relative flex-auto p-2" data-te-modal-body-ref>
          <select
            id="select_provinsi"
            data-te-select-init
            data-te-container="#modalAlamat"
            data-te-select-filter="true" required>              
          </select>
        </div>
        <div class="relative flex-auto p-2" data-te-modal-body-ref>
          <select
            id="select_kota"
            data-te-select-init
            data-te-container="#modalAlamat"
            data-te-select-filter="true" required>
          </select>
        </div>
        <div class="relative flex-auto p-2" data-te-modal-body-ref>
          <select
            id="select_kecamatan"
            data-te-select-init
            data-te-container="#modalAlamat"
            data-te-select-filter="true" required>      
          </select>
        </div>
        <div class="relative flex-auto p-2" data-te-modal-body-ref>
          <textarea name="alamat" id="alamat" rows="3" class="w-full border border-slate-300 rounded p-2 outline-0" placeholder="Ketikkan alamat lengkap" required></textarea>
        </div>
        <div class="relative flex-auto p-2" data-te-modal-body-ref>
          <input type="text" name="kodepos" id="kodepos" class="w-full border border-slate-300 rounded px-2 py-1 outline-0" placeholder="Ketikkan kodepos" required>
        </div>
        <div
          class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4">
          <div class="relative flex items-center justify-center">
            <div id="modal_alamat_loading" class="hidden absolute">
              <div class="flex items-center justify-center">
                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                  <div class="h-2 w-2 rounded-full bg-white"></div>
                </div>
              </div>
            </div>
            <button
              type="button"
              class="modal-alamat-btn-simpan ml-1 inline-block rounded border border-sky-600 bg-primary px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out">
              Simpan
            </button>
          </div>
        </div>
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

    // akun id
    const akun_id = $('#akun_id').val();

    // upload image
    $('#gambar').on('change', function () {
      let formData = new FormData($('#form_gambar')[0]);

      $.ajax({
        url: "{{ URL::route('akun.updateGambar') }}",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          window.location.reload();
        }
      })
    })

    // ubah nama
    $('#ubah_nama_lengkap').on('click', function () {
      $('.modal-title').html('Ubah Nama Lengkap');
      $('.btn-simpan').prop('id', 'btn_simpan_nama');

      let url = '{{ route("akun.editDataDiri", ":id") }}';
      url = url.replace(':id', akun_id);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          const input_nama = '<input type="text" id="nama_lengkap" value="' + response.customer.nama_lengkap + '" class="border w-full p-2 rounded outline-0">';
          $('.modal-content').html(input_nama);
        }
      })
    })
    $(document).on('click', '#btn_simpan_nama', function () {
      const nama = $('#nama_lengkap').val();

      let formData = {
        id: akun_id,
        title: "nama_lengkap",
        nama: nama
      }

      $.ajax({
        url: "{{ URL::route('akun.updateDataDiri') }}",
        type: "post",
        data: formData,
        beforeSend: function (response) {
          $('#loading').removeClass('hidden');
          $('.btn-simpan').removeClass('bg-primary');
        },
        success: function (response) {
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      })
    })

    // ubah tanggal
    $('#ubah_tanggal_lahir').on('click', function () {
      $('.modal-title').html('Ubah Tanggal Lahir');
      $('.btn-simpan').prop('id', 'btn_simpan_tanggal_lahir');

      let url = '{{ route("akun.editDataDiri", ":id") }}';
      url = url.replace(':id', akun_id);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          const input_tanggal_lahir = '<input type="date" id="tanggal_lahir" value="' + response.customer.tanggal_lahir + '" class="border w-full p-2 rounded outline-0">';
          $('.modal-content').html(input_tanggal_lahir);
        }
      })
    })
    $(document).on('click', '#btn_simpan_tanggal_lahir', function () {
      const tanggal_lahir = $('#tanggal_lahir').val();

      let formData = {
        id: akun_id,
        title: "tanggal_lahir",
        tanggal_lahir: tanggal_lahir
      }

      $.ajax({
        url: "{{ URL::route('akun.updateDataDiri') }}",
        type: "post",
        data: formData,
        beforeSend: function (response) {
          $('#loading').removeClass('hidden');
          $('.btn-simpan').removeClass('bg-primary');
        },
        success: function (response) {
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      })
    })

    // ubah jenis kelamin
    $('#ubah_jenis_kelamin').on('click', function () {
      $('.modal-title').html('Ubah Jenis Kelamin');
      $('.btn-simpan').prop('id', 'btn_simpan_jenis_kelamin');

      let url = '{{ route("akun.editDataDiri", ":id") }}';
      url = url.replace(':id', akun_id);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          const input_jenis_kelamin = `
            <div class="flex justify-center">
              <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                <input
                  class="relative float-left mt-0.5 mr-1 -ml-[1.5rem] h-5 w-5 appearance-none rounded-full border-2 border-solid border-[rgba(0,0,0,0.25)] bg-white before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:bg-white after:content-[''] checked:border-primary checked:bg-white checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:bg-white checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                  type="radio"
                  name="inlineRadioOptions"
                  id="inlineRadio1"
                  value="pria"
                  ` + (response.customer.jenis_kelamin == "pria" ? 'checked' : "") + ` />
                <label class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer" for="inlineRadio1">Pria</label>
              </div>
              <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                <input
                  class="relative float-left mt-0.5 mr-1 -ml-[1.5rem] h-5 w-5 appearance-none rounded-full border-2 border-solid border-[rgba(0,0,0,0.25)] bg-white before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:bg-white after:content-[''] checked:border-primary checked:bg-white checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:bg-white checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                  type="radio"
                  name="inlineRadioOptions"
                  id="inlineRadio2"
                  value="wanita"
                  ` + (response.customer.jenis_kelamin == "wanita" ? 'checked' : "") + ` />
                <label class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer" for="inlineRadio2">Wanita</label>
              </div>
            </div>`;

          $('.modal-content').html(input_jenis_kelamin);
        }
      })
    })
    $(document).on('click', '#btn_simpan_jenis_kelamin', function () {
      const jenis_kelamin = $('input[name="inlineRadioOptions"]:checked').val();
      
      let formData = {
        id: akun_id,
        title: "jenis_kelamin",
        jenis_kelamin: jenis_kelamin
      }

      $.ajax({
        url: "{{ URL::route('akun.updateDataDiri') }}",
        type: "post",
        data: formData,
        beforeSend: function (response) {
          $('#loading').removeClass('hidden');
          $('.btn-simpan').removeClass('bg-primary');
        },
        success: function (response) {
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      })
    })

    // ubah alamat
    $('#ubah_alamat').on('click', function () {
      $('.modal-alamat-title').html('Ubah Alamat');
      $('.modal-alamat-btn-simpan').prop('id', 'btn_simpan_alamat');

      let url = '{{ route("akun.editAlamat", ":id") }}';
      url = url.replace(':id', akun_id);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          let data_provinsi = `<option value="0">Pilih Provinsi</option>`;

          $.each(response.provinsi, function (index, item) {
            data_provinsi += `<option value="` + item.id + `">` + item.provinsi + `</option>`;
          })

          $('#select_provinsi').html(data_provinsi);
        }
      })
    })
    $(document).on('change', '#select_provinsi', function () {
      const val = $(this).val();
      $('#select_kota').html('<option value="0">Pilih Kota</option>');
      $('#select_kecamatan').html('<option value="0">Pilih Kecamatan</option>');
      
      let url = '{{ route("akun.editAlamatKota", ":id") }}';
      url = url.replace(':id', val);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          console.log(response)
          let data_kota = `<option value="0">Pilih Kota</option>`;

          $.each(response.kota, function (index, item) {
            data_kota += `<option value="` + item.id + `">` + item.type + ` ` + item.kabupaten + `</option>`;
          })

          $('#select_kota').html(data_kota);
        }
      })
    })
    $(document).on('change', '#select_kota', function () {
      const val = $(this).val();
      $('#select_kecamatan').html('<option value="0">Pilih Kecamatan</option>');
      
      let url = '{{ route("akun.editAlamatKecamatan", ":id") }}';
      url = url.replace(':id', val);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          let data_kecamatan = `<option value="0">Pilih Kecamatan</option>`;

          $.each(response.kecamatan, function (index, item) {
            data_kecamatan += `<option value="` + item.id + `">` + item.kecamatan + `</option>`;
          })

          $('#select_kecamatan').html(data_kecamatan);
        }
      })
    })
    $(document).on('click', '#btn_simpan_alamat', function () {
      const provinsi = $('#select_provinsi').val();
      const kabupaten = $('#select_kota').val();
      const kecamatan = $('#select_kecamatan').val();
      const alamat = $('#alamat').val();
      const kodepos = $('#kodepos').val();

      let formData = {
        id: akun_id,
        title: "alamat",
        provinsi: provinsi,
        kabupaten: kabupaten,
        kecamatan: kecamatan,
        alamat: alamat,
        kodepos: kodepos
      }

      $.ajax({
        url: "{{ URL::route('akun.updateDataDiri') }}",
        type: "post",
        data: formData,
        beforeSend: function (response) {
          $('#modal_alamat_loading').removeClass('hidden');
          $('.modal-alamat-btn-simpan').removeClass('bg-primary');
        },
        success: function (response) {
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      })
    })
  })
</script>
@endsection