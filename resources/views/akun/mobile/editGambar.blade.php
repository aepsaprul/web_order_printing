@extends('layouts.app')

@section('title') {{ 'Ubah Foto Profil' }} @endsection

@section('content')

@include('layouts.header')

<div class="p-3 rounded">
  <div class="font-bold text-lg text-center">Ubah Foto Profil</div>
</div>
<div class="m-3 p-3 border rounded-lg bg-white flex justify-center">
  <form id="form_gambar" method="post" enctype="multipart/form-data">
    {{-- data hidden --}}
    <input type="hidden" name="akun_id" id="akun_id" value="{{ Auth::user()->id }}">
    <input type="file" name="gambar" id="gambar" class="w-full border text-sm rounded bg-cover">
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

<script type="module">
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // upload image
    $(document).on('change', '#gambar', function () {
      let formData = new FormData($('#form_gambar')[0]);

      $.ajax({
        url: "{{ URL::route('mUbahGambarUpdate') }}",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          window.location.href = "{{ URL::route('mAkun') }}";
        }
      })
    })
  });
</script>

@endsection