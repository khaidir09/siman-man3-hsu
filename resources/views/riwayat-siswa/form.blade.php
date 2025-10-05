{{-- resources/views/riwayat-siswa/form.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cek Riwayat Siswa - SIMAN MAN 3 HSU</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="login-brand">
                <img src="{{ asset('images/kemenag.png') }}" alt="" class="img-fluid logo" style="width: 100px; height: 100px;">
                <h6>Sistem Informasi Manajemen MAN 3 HSU (SIMAN)</h6>
                </div>
                <div class="card card-primary">
                    <div class="card-header">Cek Riwayat Siswa</div>
                    <div class="card-body">
                        <form action="{{ route('siswa.riwayat.check') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nisn">Nomor Induk Siswa Nasional (NISN)</label>
                                <input type="text" name="nisn" id="nisn" class="form-control" required>
                                @error('nisn')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Cek Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
</body>
</html>