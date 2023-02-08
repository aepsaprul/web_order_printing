@extends('layouts.app')

@section('content')

@include('layouts.header')

<div>
  <h1 class="text-center font-bold my-5 text-xl text-slate-500">Kategori {{ $kategori->nama }}</h1>
  <ul id="paginated-list" class="grid grid-cols-2 gap-2 m-2">
    @foreach ($produk as $item)
      <li>
        <div>
          <img src="{{ $item->gambar }}" alt="gambar" class="w-48">
        </div>
        <div class="text-sm text-center">{{ $item->nama }}</div>
        <div class="text-sm text-center">{{ $item->harga }}</div>
      </li>
    @endforeach
  </ul>  
  <nav class="pagination-container">  
    <div id="pagination-numbers" class="text-center">  
    </div>
  </nav>
</div>

@include('layouts.navBawah')

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