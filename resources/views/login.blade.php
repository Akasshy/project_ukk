<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Tambahkan link untuk Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <style>
        body {
            background-size: cover;
        }
        .shadow-custom {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* border-radius: 8px; */
        }
    </style>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <div class="login p-5">
        <div class="row p-4 bg-white shadow-custom pb-5" style="border-radius: 8px 8px 0px 0px">
            <div class="col-md-6">
                <div class="icon">
                    <p class="fw-bold text-center" style="color: #101422">SISTEM MANAJEMEN INFORMASI UKK</p>
                    {{-- <p class="">SMK YPC TASIKMALAYA</p> --}}
                    <p class="text-center fw-bold">Silahkan Login</p>
                </div>
                <div class="form">
                    <form action="/login" method="post">
                        @csrf
                        <div class="email">
                            <label for="email">Email</label><br>
                            <input class="form-control mt-2 text-secondary" style="fon"  type="email" name="email" placeholder="Masukan Email" id="email">
                        </div>
                        <div class="email pt-4">
                            <label for="password">Password</label><br>
                            <div class="input-group">
                                <input class="form-control mt-2" type="password" name="password" placeholder="Masukan Password" id="password">
                                <div class="input-group-append">
                                    <button type="button" class="btn mt-2 rounded-0" style="border:1px solid gray; " onclick="togglePassword()">
                                        <i id="toggleIcon" class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="submit pt-4 pb-4">
                            <input class="btn text-white fw-bold" style="width: 150px ; background-color: #A8DCE7" type="submit" value="Login">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="kata-kata">
                    <p class="text-center fs-4 fw-bold" style="color: #A8DCE7">SELAMAT DATANG</p>
                    {{-- <img class="img-fluid rounded-start  object-fit-cove w-100" loading="lazy" src="{{asset('image/m2.jpeg')}}" alt="Welcome back you've been missed!"> --}}
                    <p>Sistem Manajemen Informasi UKK (Ujian Kompetensi Keahlian) adalah sebuah platform yang dirancang untuk mengelola dan memantau pelaksanaan ujian kompetensi di sekolah atau lembaga pendidikan kejuruan. Sistem ini bertujuan untuk mempermudah administrasi dan pengawasan proses UKK, mulai dari pendaftaran peserta, pengaturan jadwal ujian, penyimpanan data hasil ujian, hingga laporan nilai yang dihasilkan.

                        Dengan fitur-fitur yang terstruktur, sistem ini membantu panitia UKK dan pengajar dalam mengelola seluruh aspek ujian secara lebih efektif, memastikan kelancaran pelaksanaan, serta meningkatkan transparansi dan akurasi data yang berhubungan dengan hasil kompetensi siswa.</p>
                </div>
            </div>
        </div>
        <div class="row p-3 shadow-custom" style="background-color: #A8DCE7">
            <div class="text">
                <p class="text-white text-center">Copyright by &copyAkasshy2024</p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");
            
            // Ubah tipe input password menjadi teks dan sebaliknya
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
