@extends('template.template')
@section('content')
<div class="main p-3">
    <div class="page-header">
      {{-- <h3 class="fw-bold mb-3">DataTables.Net</h3> --}}
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="/dasboard">
            <i class="icon-home"></i>
          </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">Users</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="">All User</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title me-auto">Users</h4>
                <a type="button" class="btn btn-primary ms-auto" href="/vaddus">
                    Add User
                </a>
            </div>
          </div>
            <div class="table-responsive pt-3">
              <table id="add-row" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Is Active</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tfoot>

                  <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Is Active</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                    @foreach ($users as $key => $item)
                    <tr>
                      <td>{{$item->full_name}}</td>
                      <td>{{$item->username}}</td>
                      <td>{{$item->email}}</td>
                      <td>{{$item->phone_number}}</td>
                      <td>{{$item->role}}</td>
                      <td>{{$item->is_active}}</td>
                      <td>
                        <div class="form-button-action">
                            <a href="javascript:void(0)" class="btn btn-link btn-primary btn-lg" onclick="editItem({{ $item->id }})">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-link btn-danger" onclick="deleteItem({{ $item->id }})">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
         function editItem(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to edit this user?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, edit it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the edit page
                window.location.href = '/veditus/' + id;
            }
        });
    }

    // Function to confirm deletion
    function deleteItem(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this deletion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the delete route
                window.location.href = '/user/delete/' + id;
            }
        });
    }

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
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
        });
    @endif
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    @endif
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



@endsection
