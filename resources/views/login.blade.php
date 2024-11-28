<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <style>
        body {
            background: linear-gradient(135deg, #1e1e2f, #2c2c54);
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #2c2c54;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 24px;
            color: #a29bfe;
            margin-bottom: 10px;
        }

        .login-header p {
            font-size: 14px;
            color: #dfe6e9;
        }

        .form-control {
            background-color: #1e1e2f;
            border: 1px solid #6c5ce7;
            color: white;
        }

        .form-control:focus {
            background-color: #1e1e2f;
            border-color: #a29bfe;
            color: white;
            box-shadow: none;
        }

        .btn-custom {
            background-color: #6c5ce7;
            color: white;
            border: none;
            transition: 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #a29bfe;
        }

        .btn-show-password {
            background-color: transparent;
            border: 1px solid #6c5ce7;
            color: #6c5ce7;
            transition: 0.3s ease-in-out;
        }

        .btn-show-password:hover {
            background-color: #6c5ce7;
            color: white;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #dfe6e9;
        }
    </style>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if ($errors->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first('error') }}',
            });
        </script>
    @endif

    <div class="login-container">
        <div class="login-header">
            <h1>SISTEM MANAJEMEN INFORMASI UKK</h1>
            <p>Silakan login untuk melanjutkan</p>
        </div>
        <form action="/login" method="post">
            @csrf
            <div class="mb-4">
                {{-- <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email" required> --}}
                <label for="login">Username atau Email</label>
                <input type="text" id="login" name="login" class="form-control" placeholder="Masukkan Username atau Email" required>
            </div>
            <div class="mb-4">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                    <button type="button" class="btn btn-show-password" onclick="togglePassword()">
                        <i id="toggleIcon" class="fa fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-custom">Login</button>
            </div>
        </form>
        <div class="footer">
            <p>Copyright by &copy; Akasshy2024</p>
        </div>
    </div>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        </script>
    @endif

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
