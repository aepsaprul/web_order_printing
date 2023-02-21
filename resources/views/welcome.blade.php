@extends('layouts.app')

@section('content')

@include('layouts.header')
@include('layouts.headerLg')

<div class="flex justify-center w-full">
  <div class="swiper gambarSlider lg:w-4/5">
    <div class="swiper-wrapper">
      @foreach ($slide as $item)
        <div class="swiper-slide">
          <img src="{{ url('http://localhost/abata_web_order_admin/public/img_slide/' . $item->gambar) }}" alt="slide">
        </div>            
      @endforeach
    </div>
  </div>
</div>
<div class="lg:flex lg:justify-center">
  <div class="lg:w-4/5">
    <h1 class="text-center font-bold my-5 text-xl lg:text-2xl text-slate-500">Kategori Produk</h1>
    <div class="grid grid-cols-4 gap-3 m-2 lg:m-0">
      @foreach ($kategori as $item)
        <a href="{{ route('kategori.show', $item->id) }}">
          <div>
            <div class="flex justify-center">
              <img src="{{ url('http://localhost/abata_web_order_admin/public/img_kategori/' . $item->gambar) }}" alt="kategori" class="w-20 lg:w-full">
            </div>
            <div class="text-center font-semibold mt-2 lg:text-xl">{{ $item->nama }}</div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</div>
<div class="lg:flex lg:justify-center">
  <div class="lg:w-4/5">
    <h1 id="produk" class="text-center font-bold my-5 text-xl lg:text-2xl text-slate-500">Produk</h1>
    <div>
      <ul id="paginated-list" class="grid grid-cols-2 lg:grid-cols-5 2xl:grid-cols-6 gap-2 m-2 lg:m-0">
        @foreach ($produk as $item)
          <li>
            <a href="{{ route('produk.show', [$item->id]) }}">
              <div>
                <img src="{{ $item->gambar }}" alt="gambar" class="w-48 lg:w-full 2xl:w-full">
              </div>
              <div class="text-sm text-center">{{ $item->nama }}</div>
              <div class="text-sm text-center">{{ $item->harga }}</div>
            </a>
          </li>
        @endforeach
      </ul>  
      <nav class="pagination-container">  
        <div id="pagination-numbers" class="text-center">  
        </div>
      </nav>
    </div>
  </div>
</div>
<div class="lg:flex lg:justify-center">
  <div class="lg:w-4/5">
    <h1 class="text-center font-bold my-5 text-xl lg:text-2xl text-slate-500">Cara Pesan</h1>
    <div class="lg:flex lg:justify-between">
      <div class="lg:w-2/4 lg:flex lg:justify-center">
        <img src="{{ url('http://localhost/abata_web_order_admin/public/img_cara_pesan_gambar/' . $cara_pesan_gambar->gambar) }}" alt="gambar cara pesan" class="hidden lg:block lg:w-3/4 2xl:block">
      </div>
      <div class="lg:w-2/4 lg:flex lg:items-center lg:justify-center">
        <div class="lg:w-4/5">
          @foreach ($cara_pesan as $key => $item)
            <div class="bg-slate-600 text-white m-3 p-2 rounded-sm"><p>{{ $key + 1 }}. {{ $item->nama }}</p></div>
          @endforeach          
        </div>
      </div>
    </div>
  </div>
</div>

@include('layouts.navBawah')
@include('layouts.footer')

@endsection

@section('script')
<script>
  // slider
  var swiper = new Swiper(".gambarSlider", {
    pagination: {
      el: ".swiper-pagination",
      clickable: true
    },
    loop: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false
    }
  });

  window.onscroll = function() {
    myFunction();
  };
  
  // header sticky
  var header = document.getElementById("header-wrapper");
  var sticky = header.offsetTop;

  function myFunction() {
    if (window.pageYOffset >= sticky) {
      header.classList.add("sticky")
    } else {
      header.classList.remove("sticky");
    }
  }

  // pagination
  const paginationNumbers = document.getElementById("pagination-numbers");
  const paginatedList = document.getElementById("paginated-list");
  const listItems = paginatedList.querySelectorAll("li");

  const paginationLimit = 10;
  const pageCount = Math.ceil(listItems.length / paginationLimit);
  let currentPage = 1;

  const appendPageNumber = (index) => {
    const pageNumber = document.createElement("button");
    pageNumber.className = "pagination-number px-3 m-0.5 border border-slate-600";
    pageNumber.innerHTML = index;
    pageNumber.setAttribute("page-index", index);
    pageNumber.setAttribute("aria-label", "Page " + index);

    paginationNumbers.appendChild(pageNumber);
  };

  const getPaginationNumbers = () => {
    for (let i = 1; i <= pageCount; i++) {
      appendPageNumber(i);
    }
  };

  const handleActivePageNumber = () => {
    document.querySelectorAll(".pagination-number").forEach((button) => {
      button.classList.remove("active", "bg-yellow-400");
      const pageIndex = Number(button.getAttribute("page-index"));
      if (pageIndex == currentPage) {
        button.classList.add("active", "bg-yellow-400");
      }
    });
  };

  const setCurrentPage = (pageNum) => {
    currentPage = pageNum;
    handleActivePageNumber();

    const prevRange = (pageNum - 1) * paginationLimit;
    const currRange = pageNum * paginationLimit;

    listItems.forEach((item, index) => {
      item.classList.add("hidden");
      if (index >= prevRange && index < currRange) {
        item.classList.remove("hidden");
      }
    });
  };

  window.addEventListener("load", () => {
    getPaginationNumbers();
    setCurrentPage(1);

    document.querySelectorAll(".pagination-number").forEach((button) => {
      const pageIndex = Number(button.getAttribute("page-index"));

      if (pageIndex) {
        button.addEventListener("click", () => {
          setCurrentPage(pageIndex);
        });
      }
    });
  });

  const btn_page = document.getElementById('pagination-numbers').onclick = function() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  };

</script>
@endsection