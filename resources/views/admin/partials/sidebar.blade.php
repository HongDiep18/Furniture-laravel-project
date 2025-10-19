<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        {{-- <!-- Logo Header --> --}}
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="/storage/images/config/{{ $configs['logo'] ?? '' }}" alt="navbar brand" class="navbar-brand" width="80%" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        {{-- <!-- End Logo Header --> --}}
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                @foreach ($menus as $item)
                    @if (isset($item['section']))
                        <!-- Section Title -->
                        <li class="nav-section">
                            <span class="sidebar-mini-icon"><i class="bi bi-three-dots"></i></span>
                            <h4 class="text-section">{{ $item['section'] }}</h4>
                        </li>
                    @elseif (isset($item['submenu']))
                        <!-- Menu có sub-items -->
                        <li class="nav-item {{ request()->routeIs($item['active']) ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#{{ Str::slug($item['name']) }}">
                                {!! $item['icon'] !!}
                                <p>{{ $item['name'] }}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->routeIs($item['active']) ? 'show' : '' }}"
                                id="{{ Str::slug($item['name']) }}">
                                <ul class="nav nav-collapse">
                                    @foreach ($item['submenu'] as $subItem)
                                        <li class="{{ request()->routeIs($subItem['active']) ? 'active' : '' }}">
                                            <a href="{{ route($subItem['route']) }}"
                                                class="{{ request()->routeIs($subItem['active']) ? 'active' : '' }}">
                                                <span class="sub-item">{{ $subItem['name'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        <!-- Menu đơn -->
                        <li class="nav-item {{ request()->routeIs($item['active']) ? 'active' : '' }}">
                            <a href="{{ route($item['route']) }}">
                                {!! $item['icon'] !!}
                                <p>{{ $item['name'] }}</p>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>