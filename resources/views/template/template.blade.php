<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
          google: { families: ["Public Sans:300,400,500,600,700"] },
          custom: {
            families: [
              "Font Awesome 5 Solid",
              "Font Awesome 5 Regular",
              "Font Awesome 5 Brands",
              "simple-line-icons",
            ],
            urls: ["{{ asset('assets/css/fonts.min.css') }}"],
          },
          active: function () {
            sessionStorage.fonts = true;
          },
        });
      </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->

</head>
<body>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="fw-bold fs-2 text-white">
                ADMIN
              {{-- <img
                src="{{asset('assets/img/kaiadmin/logo_light.svg')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              /> --}}
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
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                  <a
                    href="/dasboard"
                  >
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                  </a>

                </li>
                <li class="nav-item">
                  <a data-bs-toggle="collapse" href="#base">
                    <i class="fas fa-address-card"></i>
                    <p>User Management</p>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse" id="base">
                    <ul class="nav nav-collapse">
                      <li>
                        <a href="/users">
                          <span class="sub-item">All User</span>
                        </a>
                      </li>
                      <li>
                        <a href="/dtadmin">
                          <span class="sub-item">Admin</span>
                        </a>
                      </li>
                      <li>
                        <a href="/dtassesor">
                          <span class="sub-item">Assesor</span>
                        </a>
                      </li>
                      <li>
                        <a href="/dtstudent">
                          <span class="sub-item">Student</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="nav-item">
                  <a data-bs-toggle="collapse" href="#forms">
                    <i class="fas fa-pen-square"></i>
                    <p>Majors Management</p>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse" id="forms">
                    <ul class="nav nav-collapse">
                      <li>
                        <a href="majors">
                          <span class="sub-item">Kelola Majors</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="nav-item">
                  <a  href="/admin/standars">
                    <i class="fas fa-clipboard"></i>
                    <p>Standar Competency</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a data-bs-toggle="collapse" href="#laporan">
                    <i class="fas fa-clipboard-list"></i>
                    <p>Laporan</p>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse" id="laporan">
                    <ul class="nav nav-collapse">
                      <li>
                        <a href="/hasil-ujian">
                          <span class="sub-item">Hasil Ujian</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header " data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="{{asset('assets/img/kaiadmin/logo_light.svg')}}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
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
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" style="background-color: #1A2035;">
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                {{-- <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div> --}}
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="text-dark">
                    {{-- <h1>hallo</h1> --}}
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="{{asset('assets/img/profile.jpg')}}"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7 text-white">Hi,</span>
                      <span class="fw-bold text-white">{{Auth::user()->full_name}}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="{{asset('assets/img/profile.jpg')}}"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>{{Auth::user()->full_name}}</h4>
                            <p class="text-muted">{{Auth::user()->email}}</p>
                            <a
                              href="/profile/admin"
                              class="btn btn-xs btn-secondary btn-sm"
                              >View Profile</a
                            >
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </div>
        <div class="container">
            @yield('content')
        </div>

    </div>

      <!-- Custom template | don't include it in your project! -->

      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    {{-- <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script> --}}

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
  </body>
</html>
