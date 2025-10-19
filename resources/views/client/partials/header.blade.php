{{-- navbar --}}
<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-lg">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand mt-2 mt-lg-0" href="{{ route('home')}}">
                <img src="/storage/images/config/{{ $configs['logo'] ?? '' }}" height="30" alt="MDB Logo"
                    loading="lazy" />
            </a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach ($menus as $menu)
                    @if ($menu->position == 'main' && $menu->parent == 0)

                        <li class="nav-item">
                            <a class="nav-link" href="{{ $menu->alias}}">{{$menu->name}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <form class="input-group w-auto my-auto d-none d-sm-flex" action="{{ route('client.product')}}" method="GET">
                <input autocomplete="off" type="search" class="form-control rounded" placeholder="Search"
                    style="min-width: 125px;" name="search"  value="{{ request('search')}}"/>
                <button class="input-group-text border-0 d-none d-lg-flex" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="d-flex align-items-center">
            <div>
                <a class="text-reset me-3 text-decoration-none" href="{{ route('client.cart')}}">
                    <i class="bi bi-bag"></i>
                    <span class="badge rounded-pill badge-notification bg-danger count cart-count">{{ $cartCount }}</span>
                </a>
            </div>
            <!-- Avatar -->
            <div class="dropdown">
                <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar"
                    role="button" aria-expanded="false" data-bs-toggle="dropdown">
                    <img src="{{ (Auth::check() && Auth::user()->avatar) ? Auth::user()->avatar_url : asset('images/icon-user.png') 
                        }}" class="rounded-circle" height="25" alt="Black and White Portrait of a Man"
                        loading="lazy" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if (Auth::check())
                        <li>
                            <a class="dropdown-item" href="#">{{ Auth::check() ? Auth::user()->username : 'User' }}</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Đơn hàng</a>
                        </li>
                        <li>
                            <form action="{{ route('logout')}}" method="post">
                                @csrf
                                <button class="dropdown-item" type="submit" class="w-100 btn-login mt-2 border-0">Đăng
                                    xuất</button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item" href="{{ route('client.login')}}">Đăng nhập</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('client.register')}}">Đăng ký</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- <div class="header-main">
    <div class="container-md">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 d-flex justify-content-center justify-content-md-start py-2">
                <a href="{{ route('home')}}" class="header-logo">
                    <img src="/storage/images/config/{{ $configs['logo'] ?? '' }}" alt="logo" width="100%"
                        style="max-width: 200px" />
                </a>
            </div>

            <div class="col-lg-7 col-md-8 col-sm-8 d-flex align-items-center">
                <div class="header-search-container w-100">
                    <form action="{{ route('client.product')}}" method="GET">
                        <input type="search" name="search" class="search-field" placeholder="Tìm kiếm sản phẩm..."
                            value="{{ request('search')}}" />
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-2 d-flex justify-content-end align-items-center d-none d-lg-flex">
                <div class="header-user-actions">
                    <div class="action-btn border-0" tabindex="0">
                        <img src="{{ (Auth::check() && Auth::user()->avatar) ? Auth::user()->avatar_url : asset('images/icon-user.png') 
                        }}" alt="avatar" width="35px" style="border-radius: 50%" />
                        <div class="account">
                            @if (Auth::check())
                            <p class="info-user">{{ Auth::check() ? Auth::user()->username : 'User' }}</p>
                            <a href="#" class="option-account">Đơn hàng</a>
                            <form action="{{ route('logout')}}" method="post">
                                @csrf
                                <button type="submit" class="w-100 btn-login mt-2 border-0">Đăng xuất</button>
                            </form>
                            @else
                            <a href="{{ route('client.login')}}" class="w-100 btn-login mb-2">Đăng nhập</a>
                            <a href="{{ route('client.register')}}" class="w-100 btn-register mb-1">Đăng ký</a>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('client.cart')}}" class="action-btn border-0">
                        <img src="{{ asset('images/icon-cart.png')}}" alt="" width="35px" />
                        <span class="count cart-count">{{ $cartCount }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <nav class="desktop-navigation-menu py-3 d-none d-lg-block sticky-top">
    <div class="container">
        <ul class="desktop-menu-category-list">
            @foreach ($menus as $menu)
            @if ($menu->position == 'main' && $menu->parent == 0)
            <li class="menu-category">
                <a href="{{ $menu->alias}}" class="menu-title">{{$menu->name}}</a>

                @php
                $hasChild = $menus->firstWhere('parent', $menu->id);
                @endphp

                @if ($hasChild)
                <ul class="dropdown-list">
                    @foreach ($menus as $menu_dropdown)
                    @if ($menu->id == $menu_dropdown->parent)
                    <li class="dropdown-item">
                        <a href="{{ $menu_dropdown->alias}}">{{$menu_dropdown->name}}</a>
                    </li>
                    @endif
                    @endforeach
                </ul>
                @endif
            </li>
            @endif
            @endforeach
        </ul>
    </div>
</nav> --}}
{{-- <div class="mobile-bottom-navigation d-lg-none">
    <button class="action-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
        aria-controls="offcanvasExample">
        <img src="{{ asset('images/icon-menu.png')}}" alt="" width="30px" />
    </button>

    <a class="action-btn" href="{{ route('home')}}">
        <img src="{{ asset('images/icon-home.png')}}" alt="" width="33px" />
    </a>

    <a class="action-btn" href="{{route('client.cart')}}">
        <img src="{{ asset('images/icon-cart.png')}}" alt="" width="33px" />
        <span class="count cart-count">{{ $cartCount }}</span>
    </a>

    <div class="action-btn" tabindex="0">
        <img src="{{ (Auth::check() && Auth::user()->avatar) ? Auth::user()->avatar_url : asset('images/icon-user.png') }}"
            alt="avatar" width="33px" style="border-radius: 50%" />

        <div class="account-mobile">
            @if (Auth::check())
            <p class="info-user">{{ Auth::check() ? Auth::user()->username : 'User' }}</p>
            <a href="#" class="option-account">Đơn hàng</a>

            <form action="{{ route('logout')}}" method="post">
                @csrf
                <button type="submit" class="w-100 btn-login mt-2 border-0">Đăng xuất</button>
            </form>
            @else
            <a href="{{ route('client.login')}}" class="w-100 btn-login mb-2">Đăng nhập</a>
            <a href="{{ route('client.register')}}" class="w-100 btn-register">Đăng ký</a>
            @endif

        </div>
    </div>
</div> --}}
{{-- <nav class="mobile-navigation-menu has-scrollbar offcanvas offcanvas-start d-lg-none" tabindex="10"
    id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="menu-top">
        <h2 class="menu-title">
        <img src="/storage/images/config/{{ $configs['logo'] ?? '' }}" alt="" width="110px" />
        </h2>

        <button class="menu-close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="bi bi-x"></i>
        </button>
    </div>

    <ul class="mobile-menu-category-list">

        @foreach ($menus as $menu)
        @if ($menu->position == 'main' && $menu->parent == 0)
        @php
        $hasChild = $menus->firstWhere('parent', $menu->id);
        @endphp
        @if ($hasChild)
        <li class="menu-category">
            <div class="accordion-menu" data-accordion-btn>
                <a href="{{$menu->alias}}" class="menu-title">{{$menu->name}}</a>
                <div>
                    <i class="bi bi-plus add-icon"></i>
                    <i class="bi bi-dash remove-icon"></i>
                </div>
            </div>

            <ul class="submenu-category-list" data-accordion>
                @foreach ($menus as $menu_dropdown)
                @if ($menu->id == $menu_dropdown->parent)
                <li class="submenu-category">
                    <a href="{{$menu_dropdown->alias}}" class="submenu-title">{{$menu_dropdown->name}}</a>
                </li>
                @endif
                @endforeach
            </ul>
        </li>
        @else
        <li class="menu-category">
            <a href="{{$menu->alias}}" class="menu-title">{{$menu->name}}</a>
        </li>
        @endif
        @endif
        @endforeach
    </ul>
</nav> --}}