@extends('layout.master')

@section('content')
    <div class="cardcafe">
        <main class="container">

            <div class="row">
                <div class="col-md-6">
                    <h1>{{ $cafe->nama }}</h1>
                    <p>{{ $cafe->alamat }}</p>
                    <img src="{{ asset('image/' . $cafe->gambar) }}" alt="Cafe Image" class="besar">

                </div>
                <div class="col-md-6">
                    <h1>About this cafe</h1>
                    <p>
                        @if (!empty($avgRatings))
                            <?php
                                $count = 1;
                                while($count <=  $avgRatings ){?>
                            <span class="gold-star">&#9733;</span>
                            <?php $count++;} ?>
                            ({{ number_format($avgRatings, 1) }})
                        @else
                            <p>No reviews yet</p>
                        @endif
                    </p>
                    <p>{{ $cafe->content }}</p>
                </div>
            </div>


            <div class="row">
                <div class = "col-md-6 review-wrapper">
                    <h6>Users Reviews</h6>
                    @forelse ($reviews as $item)
                        <p>By {{ $item->user->name }}</p>
                        <?php
                            $count = 0;
                            while($count < $item->rating){?>
                        <span class="gold-star">&#9733;</span>
                        <?php $count++;} ?>

                        <?php
                        $created_at = new DateTime($item->created_at);
                        $now = new DateTime();
                        $interval = $now->diff($created_at);
                        echo '<span>' . $interval->days . ' days ago</span>';
                        ?>
                        <p>{{ $item->komentar }}</p>

                    @empty
                        <p><b>Review are not available for this cafe</b></p>
                    @endforelse

                </div>
                <div class="col-md-6">

                    <div class="row">
                        <a type="button" class="btn btn-outline-primary buttonCafeMenu"
                            href="/menu/{{ $cafe->id }}">Menu</a>
                        <div class="saveWrapper ">
                            <a href="" class="fa-regular fa-heart"></a>
                        </div>
                    </div>


                    <div class="mt-4">
                        <h3>Write a Review</h3>
                        <form method="POST" action="/ratings" name="ratingForm" id="formRating">
                            @csrf
                            <input type="hidden" name="cafe_id" value="{{ $cafe->id }}">
                            <div class="row my-3">
                                <div class=" rate">
                                    <input type="radio" id="star5" name="rate" value="5" />
                                    <label for="star5" title="5 Stars">5 stars</label>
                                    <input type="radio" id="star4" name="rate" value="4" />
                                    <label for="star4" title="4 Stars">4 stars</label>
                                    <input type="radio" id="star3" name="rate" value="3" />
                                    <label for="star3" title="3 Stars">3 stars</label>
                                    <input type="radio" id="star2" name="rate" value="2" />
                                    <label for="star2" title="2 Stars">2 stars</label>
                                    <input type="radio" id="star1" name="rate" value="1" />
                                    <label for="star1" title="1 Stars">1 star</label>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row col-6">
                                    <label>Your Review *</label>
                                </div>
                                <div class="row col-6">
                                    <textarea name="review" style="width: 300px; height:50px;"></textarea>
                                </div>
                            </div>
                            {{-- <div>&nbsp;</div> --}}
                            <div class="form-group">
                                <input type="submit" name="Submit" class="btn btn-primary" value="submit">
                            </div>

                        </form>
                    </div>

                </div>

            </div>


            <div class="row">
                <div class="col-6">
                    <h3>Location</h3>
                    <div id="map"></div>
                </div>
            </div>
    </div>

    </div>
    </main>
    </div>
@endsection

@section('scripts')
    <script>
        var latitude = {{ $cafe->latitude }};
        var longitude = {{ $cafe->longitude }};

        var leafletMap = L.map('map', {
            fullscreenControl: true,

            fullscreenControl: {
                pseudoFullscreen: false
            },
            minZoom: 2
        }).setView([latitude, longitude], 13);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(leafletMap);

        L.marker([latitude, longitude]).addTo(leafletMap)
            .bindPopup('Lokasi Cafe: ' + latitude + ', ' + longitude)
            .openPopup();
    </script>
@endsection
