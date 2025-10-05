<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Dasbor SIMAN</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('admin/assets/modules/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet"
      href="{{ asset('admin/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

  <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">

  <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-iconpicker.min.css') }}">

  <link rel="stylesheet" href="{{ asset('admin/assets/modules/izitoast/css/iziToast.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">

  @stack('style')
</head>
<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
    @include('layouts.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2025 <div class="bullet"></div> <a href="">Muhammad Ridha Karimi</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/popper.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/stisla.js') }}"></script>

  <script src="{{ asset('admin/assets/modules/izitoast/js/iziToast.min.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('admin/assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
  </script>
  <script src="{{ asset('admin/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

  <script src="{{ asset('admin/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
  <!-- Sweet Alert Js -->
  @include('sweetalert::alert')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- Template JS File -->
  <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
  <script>
    // Add csrf token in ajax request
    /** Handle Dynamic delete **/
    $(document).ready(function() {
      // CSRF Token
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $('.delete-item').on('click', function(e) {
          e.preventDefault();
          Swal.fire({
              title: 'Apakah kamu yakin?',
              text: "Anda tidak dapat mengembalikannya!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#009e0f',
              cancelButtonColor: '#d33',
              cancelButtonText: 'Batal',
              confirmButtonText: 'Ya, hapus!'
          }).then((result) => {
              if (result.isConfirmed) {
                  let url = $(this).attr('href');
                  console.log(url);
                  $.ajax({
                      method: 'DELETE',
                      url: url,
                      success: function(data) {
                          if (data.status === 'success') {
                              // --- AWAL PERUBAHAN ---
                              Swal.fire({
                                  title: 'Terhapus!',
                                  text: data.message,
                                  icon: 'success',
                                  timer: 2000, // Notifikasi akan hilang setelah 2 detik
                                  showConfirmButton: false
                              }).then(function() {
                                  window.location.reload(); // Muat ulang halaman setelah notifikasi hilang
                              });
                              // --- AKHIR PERUBAHAN ---
                          } else if (data.status === 'error') {
                              Swal.fire(
                                  'Error!',
                                  data.message,
                                  'error'
                              )
                          }
                      },
                      error: function(xhr, status, error) {
                          console.error(error);
                      }
                  });


              }
          })
      })
    
    })
  </script>
  <script>
      @if (session('login-success'))
          iziToast.success({
              title: 'Berhasil!',
              message: '{{ session('login-success') }}',
              position: 'topRight'
          });
      @endif
  </script>
  
  @stack('scripts')
</body>
</html>