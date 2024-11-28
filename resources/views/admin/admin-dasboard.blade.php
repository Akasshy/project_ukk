@extends('template/template')
@section('content')
@if (session('user_name'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Selamat Datang',
        text: 'Selamat datang, {{ session('user_name') }}',
    });
</script>
@endif
    <div class="page-inner">
      <div
        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
      >
        <div>
          <h3 class="fw-bold mb-3">Dashboard</h3>
        </div>

      </div>
      <div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div
                    class="icon-big text-center icon-primary bubble-shadow-small"
                  >
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">All User</p>
                    <h4 class="card-title">{{ $ju }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div
                    class="icon-big text-center icon-info bubble-shadow-small"
                  >
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Assessor</p>
                    <h4 class="card-title">{{ $ja }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div
                    class="icon-big text-center icon-secondary bubble-shadow-small"
                  >
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Student</p>
                    <h4 class="card-title">{{ $jst }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-success bubble-shadow-small"
                    >
                      <i class="fas fa-luggage-cart"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Major</p>
                      <h4 class="card-title">{{ $mjr }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="row">

      </div>
    </div>
    <script src="{{ asset('js/no-back.js') }}"></script>
    <script>
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
        setTimeout("noBack()", 0);

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
