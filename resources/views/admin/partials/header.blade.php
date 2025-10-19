<div class="main-header">
  <div class="main-header-logo">
    {{-- <!-- Logo Header --> --}}
    <div class="logo-header" data-background-color="dark">
      <a href="index.html" class="logo">
  <img src="{{ asset('storage/images/config/' . ($configs['logo'] ?? '')) }}" alt="navbar brand" class="navbar-brand" height="20" />
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
  {{-- <!-- Navbar Header --> --}}
  <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">

      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <li class="nav-item topbar-user dropdown hidden-caret">
          <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
            <div class="avatar-sm">
              <img src="{{ Auth::user()->avatar_url ?? asset('images/admin-avatar.png') }}" alt="..." class="avatar-img rounded-circle" />
            </div>
            <span class="profile-username">
              <span class="op-7">Hi,</span>
              <span class="fw-bold">Admin</span>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">

              <li>
                <a class="dropdown-item" href="{{ route('admin.password.change', ['adminId' => Auth::user()->id])}}">Đổi mật khẩu</a>
                <form action="{{ route('logout')}}" method="post">
                  @csrf
                  <button type="submit" class="dropdown-item">Đăng xuất</button>
                </form>
              </li>
            </div>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</div>