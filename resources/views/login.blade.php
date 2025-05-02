<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda E-Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Work Sans', sans-serif;
            margin: 0;
        }

        .background {
            position: relative;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/logo/image.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
            opacity: 0.2;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .content-box {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 20px;
            border-radius: 10px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
        }

        .toggle-role {
            cursor: pointer;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            color: #0d6efd;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="row text-center w-100 px-3">
            <!-- Informasi Aplikasi -->
            <div class="col-md-8 mb-3 d-flex align-items-center justify-content-center order-1 order-md-1">
                <div class="content-box text-center">
                    <img src="/images/image.png" alt="Logo SMK Mulia Buana"
                        style="max-height: 100px; border-radius: 5%;" class="mb-3">
                    <h4>Selamat Datang di E-Learning SMK Mulia Buana</h4>
                    <p class="mt-3">
                        Aplikasi ini dirancang untuk mendukung proses belajar mengajar secara digital.
                        Siswa dapat mengakses materi, tugas, dan kuis online. Guru dapat memberikan soal,
                        mengelola nilai siswa dengan mudah dan efisien.
                    </p>
                </div>
            </div>

            <!-- Card Login Form Toggle -->
            <div class="col-md-4 mb-3 order-2 order-md-2 mx-auto">
                <div class="card p-3">
                    <div id="toggleRole" class="toggle-role text-end">👨‍🏫 Pindah ke Login Guru</div>

                    <!-- Form Siswa -->
                    <form id="siswaForm" class="active" method="POST" action="{{ route('login.siswa') }}">
                        @csrf
                        <h5 class="mb-3">Login Siswa</h5>
                        <!-- Menampilkan pesan error dari session jika ada -->
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <input type="email" class="form-control mb-2" placeholder="Email Siswa" name="email"
                            required>

                        <!-- Password input with toggle eye icon -->
                        <div class="form-group position-relative">
                            <input type="password" id="password" class="form-control mb-2" placeholder="Password"
                                name="password" required>
                            <button type="button" id="togglePassword" class="position-absolute"
                                style="top: 50%; right: 10px; transform: translateY(-50%); background: transparent; border: none; font-size: 18px;">
                                <i class="fas fa-eye"></i> <!-- Default eye icon -->
                            </button>
                        </div>

                        <input type="hidden" name="role" value="siswa">
                        <button type="submit" class="btn btn-success w-100 mt-2">Masuk sebagai Siswa</button>
                    </form>



                    <!-- Form Guru -->
                    <form id="guruForm" class="d-none" method="POST" action="{{ route('login.guru') }}">
                        @csrf
                        <h5 class="mb-3">Login Guru</h5>
                        <!-- Menampilkan pesan error dari session jika ada -->
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <input type="email" class="form-control mb-2" placeholder="Email Guru" name="email"
                            required>

                        <!-- Password input with toggle eye icon -->
                        <div class="form-group position-relative">
                            <input type="password" id="guruPassword" class="form-control mb-2"
                                placeholder="Password Guru" name="password" required>
                            <button type="button" id="toggleGuruPassword" class="position-absolute"
                                style="top: 50%; right: 10px; transform: translateY(-50%); background: transparent; border: none; font-size: 18px;">
                                <i class="fas fa-eye"></i> <!-- Default eye icon -->
                            </button>
                        </div>

                        <input type="hidden" name="role" value="guru">
                        <button type="submit" class="btn btn-primary w-100 mt-2">Masuk sebagai Guru</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Script -->
    <script>
        const toggleBtn = document.getElementById('toggleRole');
        const siswaForm = document.getElementById('siswaForm');
        const guruForm = document.getElementById('guruForm');

        let isSiswa = true;

        toggleBtn.addEventListener('click', () => {
            isSiswa = !isSiswa;
            siswaForm.classList.toggle('d-none', !isSiswa);
            guruForm.classList.toggle('d-none', isSiswa);
            toggleBtn.textContent = isSiswa ? '👨‍🏫 Pindah ke Login Guru' : '🎓 Pindah ke Login Siswa';
        });

        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            // Toggle the input type between 'password' and 'text'
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;

            // Toggle the eye icon between open and closed
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
        });

        // Toggle password visibility for Guru Form
        const toggleGuruPassword = document.getElementById('toggleGuruPassword');
        const guruPassword = document.getElementById('guruPassword');

        toggleGuruPassword.addEventListener('click', function() {
            // Toggle the input type between 'password' and 'text'
            const type = guruPassword.type === 'password' ? 'text' : 'password';
            guruPassword.type = type;

            // Toggle the eye icon between open and closed
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
        });
    </script>
</body>

</html>
