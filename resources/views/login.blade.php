<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda E-Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

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
            /* ✅ Isi penuh area */
            background-position: center;
            /* ✅ Fokus di tengah */
            background-repeat: no-repeat;
            /* ✅ Hindari pengulangan */
            z-index: -1;
            opacity: 0.2;
            /* ✅ Supaya konten tetap terlihat */
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* gelapkan gambar */
            z-index: -1;
        }

        .content-box {
            background-color: rgba(255, 255, 255, 0.85);
            /* kotak putih transparan */
            padding: 20px;
            border-radius: 10px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="row text-center w-100 px-3">
            <!-- Card Siswa -->
            <!-- Card Siswa -->
            <div class="col-md-4 mb-3 order-2 order-md-1">
                <div class="card mx-auto" style="width: 18rem;">
                    <img src="/images/logo/bg.jpg" class="card-img-top" alt="Logo Siswa">
                    <div class="card-body">
                        <h5 class="card-title">Login Siswa</h5>
                        <p class="card-text">Klik tombol di bawah untuk masuk ke akun siswa dan mulai belajar.</p>
                        <a href="/siswa" class="btn btn-success">Login Siswa</a>
                    </div>
                </div>
            </div>

            <!-- Informasi Aplikasi -->
            <div class="col-md-4 mb-3 d-flex align-items-center justify-content-center order-1 order-md-2">
                <div class="content-box text-center">
                    <img src="/images/image.png" alt="Logo SMK Mulia Buana" style="max-height: 100px; border-radius: 5%;" class="mb-3">
                    <h4>Selamat Datang di E-Learning SMK Mulia Buana</h4>
                    <p class="mt-3">
                        Aplikasi ini dirancang untuk mendukung proses belajar mengajar secara digital.
                        Siswa dapat mengakses materi, tugas, dan kuis online. Guru dapat memberikan soal,
                        mengelola nilai siswa dengan mudah dan efisien.
                    </p>
                </div>
            </div>

            <!-- Card Guru -->
            <div class="col-md-4 mb-3 order-3 order-md-3">
                <div class="card mx-auto" style="width: 18rem;">
                    <img src="/images/logo/bg_guru.jpg" class="card-img-top" alt="Logo Guru">
                    <div class="card-body">
                        <h5 class="card-title">Login Guru</h5>
                        <p class="card-text">Masuk ke akun guru untuk mengelola kelas, tugas, dan kuis siswa.</p>
                        <a href="/guru" class="btn btn-primary">Login Guru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
