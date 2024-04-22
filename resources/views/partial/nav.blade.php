<nav class="navbar navbar-light ">
    <a class="navbar-brand" href="#">
        <img src="/img/img.png" height="15" class="d-inline-block align-top" alt="">
    </a>

    <ul class="nav justify-content-end">
        @if (Auth::check())
            <li class="nav-item">
                <div class="dropdown">

                    <button id="dLabel" type="button" class="btn btn-primary" data-bs-toggle="dropdown">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span
                            class="badge bg-danger">{{ count((array) session('cart')) }}</span>
                    </button>

                    <div class="dropdown-menu dropdown-cart" aria-labelledby="dLabel">

                        <div class="row total-header-section">
                            @php $total = 0 @endphp
                            @foreach ((array) session('cart') as $id => $details)
                                @php
                                    $price = is_numeric($details['price']) ? $details['price'] : 0;
                                    $quantity = is_numeric($details['quantity']) ? $details['quantity'] : 0;

                                    $total += $price * $quantity;
                                @endphp
                            @endforeach
                            <div class="col-lg-12 col-sm-12 col-12 total-section text-right">
                                <p class="text-left mb-0 total-text">Total: <span
                                        class="text-black">Rp{{ $total }}</span></p>
                            </div>
                        </div>
                        @if (session('cart'))
                            @foreach (session('cart') as $id => $details)
                                <div class="row cart-detail my-3">
                                    <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                        <img src="{{ asset('image') }}/{{ $details['photo'] }}"
                                            class="img-fluid cart-img" alt="Product Image" />
                                    </div>
                                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                        <p class="total-text">{{ $details['menu_name'] }}</p>
                                        <span class="price text-success"> Rp{{ $details['price'] }}</span>
                                        <span class="count total-text"> Quantity:{{ $details['quantity'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if ($total > 0)
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                    <a href="{{ route('cart') }}" class="btn btn-primary btn-block">View all</a>
                                </div>
                            </div>
                        @else
                        @endif

                    </div>


                </div>

            </li>
        @endif
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                @if (Auth::check())
                    {{ Auth::user()->name }}
                @else
                    Guest
                @endif

            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                @if (Auth::check())
                    @if (Auth::user()->role == 'admin' || (Auth::user()->role == 'developer' && Auth::user()->status == 'approved'))
                        <a class="dropdown-item" href="/table-cafe">Setting</a>
                    @else
                        {{-- CRUD USER --}}
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a class="dropdown-item" href="/login">Login</a>
                @endif


            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/cafe">CAFE</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/favorite">FAVORITE</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about">ABOUT</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contact">CONTACT</a>
        </li>


    </ul>

</nav>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
