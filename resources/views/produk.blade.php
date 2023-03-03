@extends('layouts.app')

@section('content')

@include('layouts.header')
@include('layouts.headerLg')

<div class="lg:flex lg:justify-center mt-4">
  <div class="lg:w-4/5 2xl:w-3/5">
    <h1 id="produk" class="text-center font-bold my-5 text-xl lg:text-2xl text-slate-500"></h1>
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

@include('layouts.navBawah')
@include('layouts.footer')

@endsection

@section('script')
<script>
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