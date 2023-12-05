@extends('layout.master')

@section('content')
<style>
.container {
    display: flex;
    justify-content: center;
}
</style>
<div class="cardhome">
    
    <nav class="card-search">
        <form class="form-inline">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </nav>
    <div class="card-container">
        @forelse ($menu as $item)
        <div class="card">
            <img src="{{asset('image/' . $item->gambar)}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$item->nama}}</h5>
                <p class="card-text">{{ number_format($item->harga, 0, ',', '.') }}</p>
              <div>&nbsp;</div> 
                <div class="container">
                   <a href="" class="btn btn-primary">Tambah</a>  
                </div>
               
            </div>
        </div>
    @empty
        <p>No cafes found</p>
    @endforelse
    
    </div>
</div>
@endsection