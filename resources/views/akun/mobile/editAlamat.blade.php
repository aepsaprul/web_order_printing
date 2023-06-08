@extends('layouts.app')

@section('title') {{ 'Ubah Alamat' }} @endsection

@section('content')

@include('layouts.header')

<div class="p-3 rounded">
  <div class="font-bold text-lg text-center">Ubah Alamat</div>
</div>
<div class="mx-3 mb-20 p-5 border rounded-lg bg-white">
  <form action="{{ route('mUbahAlamatUpdate') }}" method="post">
    @csrf
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="provinsi" class="mb-2 text-slate-500 font-bold">Provinsi</label>
        <select name="select_provinsi" id="select_provinsi" data-te-select-init data-te-select-filter="true">
          <option value="0">Pilih Provinsi</option>
          @foreach ($provinsi as $item)
            <option value="{{ $item->id }}" {{ $item->id == $customer->provinsi ? 'selected' : '' }}>{{ $item->provinsi }}</option>
          @endforeach
        </select>       
      </div>
    </div>
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="kota" class="mb-2 text-slate-500 font-bold">Kabupaten/Kota</label>
        <select name="select_kota" id="select_kota" data-te-select-init data-te-select-filter="true">
          <option value="0">Pilih Kabupaten/Kota</option>
          @foreach ($kota as $item)
            <option value="{{ $item->id }}" {{ $item->id == $customer->kabupaten ? 'selected' : '' }}>{{ $item->kabupaten }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="kecamatan" class="mb-2 text-slate-500 font-bold">Kecamatan</label>
        <select name="select_kecamatan" id="select_kecamatan" data-te-select-init data-te-select-filter="true">
          <option value="0">Pilih kecamatan</option>
          @foreach ($kecamatan as $item)
            <option value="{{ $item->id }}" {{ $item->id == $customer->kecamatan ? 'selected' : '' }}>{{ $item->kecamatan }}</option>
          @endforeach
        </select>       
      </div>
    </div>
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="alamat" class="mb-2 text-slate-500 font-bold">Alamat</label>
        <textarea name="alamat" id="alamat" class="w-full h-20 border rounded-md p-3">{{ $customer->alamat }}</textarea>
      </div>
    </div>
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="kodepos" class="mb-2 text-slate-500 font-bold">Kodepos</label>
        <input type="text" name="kodepos" id="kodepos" value="{{ $customer->kodepos }}" class="border py-1 px-2 outline-none rounded-md">
      </div>
    </div>
    <div class="mb-3">
      <button type="submit" class="rounded w-full my-3 py-2 text-white font-bold bg-sky-500 ring-1 ring-sky-500 ring-offset-2">Perbaharui</button>
    </div>
  </form>
</div>

@include('layouts.navBawah')

<script>
  /* Storing user's device details in a variable*/
  let details = navigator.userAgent;
  
  /* Creating a regular expression
  containing some mobile devices keywords
  to search it in details string*/
  let regexp = /android|iphone|kindle|ipad/i;
  
  /* Using test() method to search regexp in details
  it returns boolean value*/
  let isMobileDevice = regexp.test(details);
  
  if (!isMobileDevice) {
    window.location.href = "{{ route('akun') }}";
  }
</script>

@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // ubah alamat
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
          let data_kota = `<option value="0">Pilih Kota</option>`;

          $.each(response.kota, function (index, item) {
            data_kota += `<option value="` + item.id + `">` + item.kabupaten + `</option>`;
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
  })
</script>
@endsection