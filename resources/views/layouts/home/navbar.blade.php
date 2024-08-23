<!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white flex-column border-0 fixed-top">
    <div class="container-fluid">
        <div class="w-100">
            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <!-- Logo-->
                <a class="navbar-brand fw-bold fs-3 m-0 p-0 flex-shrink-0 order-0" href="{{ route('home') }}">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('bundle1/assets/images/spirit.png') }}" alt="" width="100">
                    </div>
                </a>
                <!-- / Logo-->

                <!-- Navbar Icons-->
                <ul class="list-unstyled mb-0 d-flex align-items-center order-1 order-lg-2 collapse nav-sidelinks">

                    <!-- Navbar Search-->
                    <li class=" d-sm-block">
                        <span class="nav-link text-body search-trigger cursor-pointer">Search</span>
                        <!-- Search navbar overlay-->
                        <div class="navbar-search d-none">
                            <div class="input-group py-3 px-3">
                                <form action="{{ route('search') }}" class="d-flex w-100">
                                    <input name="keyword" type="text" class="form-control border-0"
                                        placeholder="enter keyword search.." aria-label="enter keyword search.."
                                        aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary border-0" type="submit"><i
                                            class="ri-search-line ri-lg"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="search-overlay"></div>
                        <!-- / Search navbar overlay-->
                    </li>
                    <!-- /Navbar Search-->
                    <!-- Mobile Nav Toggler-->
                    <li class="d-lg-none">
                        <span class="nav-link text-body d-flex align-items-center cursor-pointer"
                            data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><i
                                class="ri-menu-line ri-lg me-1"></i> Menu</span>
                    </li>
                    <!-- /Mobile Nav Toggler-->
                </ul>
                <!-- Navbar Icons-->

                <!-- Main Navigation-->
                <div class="flex-shrink-0 collapse navbar-collapse navbar-collapse-light w-auto flex-grow-1 order-2 order-lg-1"
                    id="navbarNavDropdown">
                    <!-- Menu-->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Catalog
                            </a>
                            <!-- Menswear dropdown menu-->
                            <div class="dropdown-menu dropdown-megamenu">
                                <div class="container-fluid">
                                    <div class="row g-0 g-lg-3">
                                        <!-- Menswear Dropdown Menu Links Section-->
                                        <div class="col col-lg-12 py-lg-5">
                                            <div class="row py-0 py-lg-0 flex-wrap gx-4 gy-4">
                                                <!-- menu row-->
                                                @foreach ($category->take(4) as $kategori)
                                                    <div class="col">
                                                        <h6 class="dropdown-heading">{{ $kategori->nama }}</h6>
                                                        <ul class="list-unstyled">
                                                            @foreach ($kategori->subcategories->take(3) as $subkategori)
                                                                <li class="dropdown-list-item">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('home.product-subcategories', ['id' => $subkategori->id]) }}">
                                                                        {{ $subkategori->nama }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                            <li class="dropdown-list-item">
                                                                <a class="dropdown-item fw-bold"
                                                                    href="/product-categories/{{ $kategori->id }}">
                                                                    View All
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endforeach

                                                <!-- / menu row-->
                                            </div>
                                        </div>
                                        <!-- /Menswear Dropdown Menu Links Section-->
                                    </div>
                                </div>
                                <!-- / Menswear dropdown menu-->
                        </li>
                        <!-- HOMEPAGE-->
                        <li class="nav-item dropdown">
                            <a class="nav-link " href="/" type="button">Home
                            </a>
                        </li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Pages
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/">Homepage</a></li>
                                <li><a class="dropdown-item" href="#">About</a></li>
                                <li><a class="dropdown-item" href="#">Product</a></li>
                                <li><a class="dropdown-item" href="/">Cart</a></li>
                                <li><a class="dropdown-item" href="/">Checkout</a></li>
                            </ul>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Category
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($category as $kategori)
                                    <li><a class="dropdown-item"
                                            href="/product-categories/{{ $kategori->id }}">{{ $kategori->nama }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <!-- Navbar Login-->
                        <li class="d-lg-inline-block nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                href="#">
                                account
                            </a>
                            @if (Auth::check())
                                @if (auth()->user()->role == 'member')
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('profil') }}">Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('orderlist') }}">Orders</a></li>
                                        <li><a class="dropdown-item" href="{{ route('auth.logout') }}"
                                                onclick="return confirm('Apakah Anda yakin ingin logout?')">Logout</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('auth.forgot-password') }}">Forgotten
                                                Password</a></li>
                                    </ul>
                                @else
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/login">Login</a></li>
                                        <li><a class="dropdown-item" href="{{ route('auth.register') }}">Register</a>
                                        </li>
                                        <li><a class="dropdown-item" href="/forgot-password">Forgotten Password</a></li>
                                    </ul>
                                @endif
                            @else
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/login">Login</a></li>
                                    <li><a class="dropdown-item" href="{{ route('auth.register') }}">Register</a>
                                    </li>
                                    <li><a class="dropdown-item" href="/forgot-password">Forgotten Password</a></li>
                                </ul>
                            @endif
                        </li>
                        <!-- /Navbar Login-->
                        <!-- Navbar Cart Icon-->
                        <li class="d-lg-inline-block nav-item dropdown-cart">
                            <a class="nav-link me-0 disable-child-pointer" href="{{ route('cart') }}"
                                type="button">
                                Cart
                            </a>
                        </li>
                        <!-- /Navbar Cart Icon-->
                        <!-- chat Icon-->
                        <li class="d-lg-inline-block nav-item dropdown">
                            <a class="nav-link me-0 disable-child-pointer" href="/chat" type="button">
                                Chat
                            </a>
                        </li>
                        <!-- /Navbar Cart Icon-->
                        <!-- / Menu-->
                    </ul>
                </div>
                <!-- / Main Navigation-->

            </div>
        </div>
    </div>
</nav>
<!-- / Navbar--> <!-- / Navbar-->
