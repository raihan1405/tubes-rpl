@extends('layout.master')

@section('content')
<style>
    *{
    margin: 0;
    padding: 0;
}
.card-body{

    background-color: white;
    margin-right: 100px;
    margin-bottom: 50px;
    color: black
}
.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    opacity: 0;
    cursor: pointer;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
.btn{

}
</style>
<div class="cardcafe ">
    <main class="container py-3">

        <div class="row">
            <div class="col-6">
                    <h1>{{$cafe->nama}}</h1>
                    <p>{{$cafe->alamat}}</p>
            </div>
            <div class="col-6">
                    <h1>About this cafe</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <img src="{{asset('image/' . $cafe->gambar)}}" alt="Cafe Image" class="besar">
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <p>{{$cafe->content}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="d-flex">
                            <a type="button" class="btn btn-outline-primary mt-5 me-1" href="/cafe">Menu</a>
                        </div>
                    </div>
                </div>

                {{-- jika user adalah pemilik cafe makan akan mendapat akses edit & delete --}}
                @if (Auth::user()->role == "admin" && $cafe->user_id == Auth::user()->id)
                <div class="row">
                    <div class="col-4">
                        <div class="d-flex">
                            <a type="button" class="btn btn-danger mt-5 " href="/cafe">Edit</a>
                            <a type="button" class="btn btn-warning mt-5" href="/cafe">Delete</a>
                        </div>
                    </div>
                </div>
                @endif

                
            </div>
            
        </div>

        <div class="row">
            <div class = "col-6">
                
                <h3>Users Reviews</h3>
                @forelse ($reviews as $item)
                <div class="card-body">
                    <p >By {{$item->user->name}}</p>
                    <p >{{$item->user->email}}</p>

                    <?php
                        $count = 0;
                        while($count < $item->rating){?>
                            <span>&#9733;</span>
                    <?php $count++;} ?>
                    
                    <p >{{$item->komentar}}</p>
                    <p >{{$item->created_at}}</p>
                </div>
                    
               
                @empty
                <p><b>Review are not available for this cafe</b></p>
                @endforelse
            </div>
            <div class="col-6">
               <h3>Write a Review</h3>
                <form method="POST" action="/ratings" name="ratingForm" id="formRating">
                    @csrf
                    <div class="row col-6 my-3">
                        <div class="rate">
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>
                    </div>
                    <div class="form-group " >
                        <div class="row col-6">
                            <label >Your Review *</label> 
                        </div>
                        <div class="row col-6">
                            <textarea name="review" style="width: 300px; height:50px;"></textarea>
                        </div>
                    </div>
                    {{-- <div>&nbsp;</div> --}}
                    <div class="form-group">
                        <input type="submit" name="Submit" >

                    </div>
                      
                </form>
            </div>
        </div>   
    </main>
</div>


@endsection