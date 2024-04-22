@extends('layout.master')

@section('content')

<div class="cardhome">
    
    <form class="form-inline my-3" action="/search/{{ $cafe }}" method="GET">
        @csrf
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
    </form>

      </nav>
    <div class="container">
        <div class="row">
        @forelse ($menu as $item)
        <div class="col-md-4 my-3">
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
    </div>
    @empty
        <p>No menu found</p>
    @endforelse
    </div>
        
    
    </div>
</div>
@endsection