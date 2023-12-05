<nav class="navbar navbar-light ">
        <a class="navbar-brand" href="#">
            <img src="/img/img.png" height="15" class="d-inline-block align-top" alt="">
        </a>
        <ul class="nav justify-content-end" >
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              
              @if(Auth::check())
                  {{ Auth::user()->name }}
               @else
                  Guest
              @endif

            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            
          @if(Auth::check())
              <h5 class="dropdown-item" >Role : {{ Auth::user()->role }}</h5>
              @if (Auth::user()->role == "admin")
                      {{-- user sudah memiliki cafe --}}
                  @if (Auth::user()->cafes->count() > 0)
                      @php $cafeId = Auth::user()->cafes->first()->id; @endphp
                      <a class="dropdown-item" href="/cafe/{{$cafeId}}">Your Cafe</a>
                  @else
                      <!-- User belum memiliki kafe -->
                      <a class="dropdown-item" href="/cafe/create">Tambah Cafe</a>
                  @endif
              @endif
              <a class="dropdown-item" href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
          @else
              <a class="dropdown-item" href="/login">login</a>
          @endif
                
                     
            </div>
        </li>
            <li class="nav-item" >
              <a class="nav-link " href="/">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">SPOT</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/about">ABOUT</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">CONTACT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" ><img src="/img/Component.png" alt="" height="30"></a>
              </li>
          </ul>
    </nav>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
