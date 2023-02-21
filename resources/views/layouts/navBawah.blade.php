<div class="w-full fixed bottom-0 bg-white flex justify-between border-t py-2 lg:hidden">
  <a href="{{ url('/') }}" class="flex flex-col text-center w-full">
    <i class="fa fa-home"></i>
    <span class="text-xs">Home</span>
  </a>
  <a href="#" class="flex flex-col text-center w-full">
    <i class="fa-solid fa-rectangle-list"></i>
    <span class="text-xs">Transaksi</span>
  </a>
  @auth
    <a href="#" class="flex flex-col text-center w-full">
      <i class="fa fa-comment-dots"></i>
      <span class="text-xs">Chat</span>
    </a>
    <a href="{{ route('akun') }}" class="flex flex-col text-center w-full">
      <i class="fa fa-user"></i>
      <span class="text-xs">Akun</span>
    </a>
  @else
    <a href="{{ route('login') }}" class="flex flex-col text-center w-full">
      <i class="fa fa-sign-in"></i>
      <span class="text-xs">Login</span>
    </a>
    <a href="{{ route('register') }}" class="flex flex-col text-center w-full">
      <i class="fa fa-user-plus"></i>
      <span class="text-xs">Register</span>
    </a>
  @endauth
</div>