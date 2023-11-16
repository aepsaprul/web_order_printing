@extends('layouts.app')
@section('title') {{ 'Beranda' }} @endsection
@section('content')

<div>{{ $landing->pixel_1 }}</div>
<div class="flex justify-center bg-white">
  <div>
    <div><img src="{{ url(env('APP_URL_ADMIN') . '/img_landing/' . $landing->img_1) }}" alt="img" class="w-full"></div>
    <div class="bg-black text-white text-center font-bold text-xl my-2">{{ $landing->teks_1 }}</div>
    <div><img src="{{ url(env('APP_URL_ADMIN') . '/img_landing/' . $landing->img_2) }}" alt="img" class="w-full"></div>
    <div class="bg-black text-white text-center font-bold text-xl my-2">{{ $landing->teks_2 }}</div>
    <div><img src="{{ url(env('APP_URL_ADMIN') . '/img_landing/' . $landing->img_3) }}" alt="img" class="w-full"></div>
    <div><img src="{{ url(env('APP_URL_ADMIN') . '/img_landing/' . $landing->img_4) }}" alt="img"></div>
    <div>
      <a href="https://api.whatsapp.com/send/?phone={{ $landing->telepon }}&text={{ $landing->teks_wa }}+&app_absent=0" target="_blank" class="font-bold text-sm text-slate-700"><img src="{{ url(env('APP_URL_ADMIN') . '/img_landing/' . $landing->img_5) }}" alt="img"></a>
    </div>
    <div class="line-through">{{ $landing->teks_3 }}</div>
    <div class="text-center">{{ $landing->teks_4 }}</div>
    <div><img src="{{ url(env('APP_URL_ADMIN') . '/img_landing/' . $landing->img_6) }}" alt="img" class="w-full"></div>
  </div>
</div>

@endsection

@section('script')

@endsection