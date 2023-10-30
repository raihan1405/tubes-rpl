@extends('layout.master')

@section('content')
<div class="cardhome">
    
    <nav class="card-search">
        <form class="form-inline">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </nav>
    <div class="card-container">
        @forelse ($cafe as $item)
        <div class="card">
            <img src="{{asset('image/' . $item->gambar)}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$item->nama}}</h5>
                <p class="card-text">{{$item->alamat}}</p>
                <a href="/info" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        @empty
        
    @endforelse
    </div>
    
    
</div>
@endsection