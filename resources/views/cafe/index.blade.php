@extends('layout.master')

@section('content')
<title>CoffeSkuy</title>
<div class="cardhome">
    <form class="form-inline" action="/cafes/search" method="GET">
        @csrf
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    
    <div class="card-container">
        @forelse ($cafes as $cafe)
        <div class="card">
            <img src="{{asset('image/' . $cafe->gambar)}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$cafe->nama}}</h5>
                <p class="card-text">{{$cafe->alamat}}</p>
                @if (!empty($cafe->averageRating))
                    <?php
                        $count = 1;
                        while($count <=  $cafe->averageRating ){?>
                            <span>&#9733;</span>
                    <?php $count++;} ?>
                    ({{ number_format($cafe->averageRating, 1) }})
                @else
                    <p>No reviews yet</p>
                @endif
              <div>&nbsp;</div> 
                <a href="/cafe/{{$cafe->id}}" class="btn btn-primary">Detail</a>
            </div>
        </div>
    @empty
        <p>No cafes found</p>
    @endforelse
    
    </div>
</div>
@endsection