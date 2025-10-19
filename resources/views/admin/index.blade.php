<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Bảng điều kiển - Nội Thất Uy Tín Hường Điệp</title>
  <link rel="icon" type="image/png" href="{{ asset('favico.png') }}">
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  {{--
  <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" /> --}}

  <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/admin/plugins.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/admin/kaiadmin.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/admin/admin.css')}}">
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}" />

</head>

<body>
  <div class="wrapper">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')
    <!-- End Sidebar -->

    <div class="main-panel">
      @include('admin.partials.header')

      <div class="container">
        @yield('content')
      </div>

    </div>

  </div>
  <!--   Core JS Files   -->
  <script src="{{ asset('js/jquery.min.js')}}"></script>
  <script src="{{ asset('js/admin/popper.min.js')}}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>


  <!-- jQuery Scrollbar -->
  <script src="{{ asset('js/admin/jquery.scrollbar.min.js')}}"></script>

  <!-- jQuery Sparkline -->
  <script src="{{ asset('js/admin/jquery.sparkline.min.js')}}"></script>

  <!-- Bootstrap Notify -->
  <script src="{{ asset('js/admin/bootstrap-notify.min.js')}}"></script>

  <!-- Sweet Alert -->
  <script src="{{ asset('js/sweetalert2.min.js')}}"></script>

  <script src="{{ asset('js/admin/chartjs/dist/chart.umd.min.js')}}"></script>
  <!-- Kaiadmin JS -->
  <script src="{{ asset('js/admin/kaiadmin.min.js')}}"></script>
  <script src="{{ asset('js/helper.js')}}"></script>
  <script src="{{ asset('ckeditor/ckeditor.js')}}"></script>

  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      customClass: {
        popup: 'custom-toast',
        confirmButton: 'my-confirm-button-class',
      },
    });

    function formatVND(value) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
    }
  </script>

  @yield('scripts')

</body>

</html>