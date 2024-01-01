@extends('layout.master')

@section('content')
<style>
.container {
    display: flex;
    justify-content: center;
}
</style>
<div class="cardhome">
    
    <form class="form-inline" action="/search/{{ $cafe }}" method="GET">
        @csrf
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
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
                    <p class="btn-holder"><a href="{{ route('add_to_cart', $item->id) }}" class="btn btn-primary btn-block text-center" role="button">Add to cart</a> </p>   
                </div>
            </div>
        </div>
    @empty
        <p>No menu found</p>
    @endforelse
    
    </div>
</div>
@endsection