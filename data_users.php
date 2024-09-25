<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Remobil | Data Anggota</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php
  include "php/navbar.php";
  ?>

  <?php
    include "php/sidebar.php";
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Anggota</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Data Anggota</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <button class="btn btn-success" id="tombolTambah">Tambah Anggota</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="anggota-table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>NO</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    
    <!-- Modal Tambah User -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambah User -->
                    <form id="formTambah">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <input type="text" class="form-control" id="role" name="role">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanTambah">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengedit User -->
                    <form id="formEdit">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_username">Username:</label>
                            <input type="text" class="form-control" id="edit_username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="edit_password">Password:</label>
                            <input type="password" class="form-control" id="edit_password" name="password" disabled>
                        </div>
                        <div class="form-group">
                            <label for="edit_role">Role:</label>
                            <input type="text" class="form-control" id="edit_role" name="role">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanEdit">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
  include "php/footer.php";
  ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            var table = $('#anggota-table').DataTable({
                "ajax": "ajax/ajax_users.php",
                "columns": [{
                        "data": "no"
                    },
                    {
                        "data": "username"
                    },
                    {
                        "data": "role"
                    },
                    {
                        "data": "aksi",
                        "orderable": false, // Agar kolom ini tidak bisa diurutkan
                        "searchable": false // Agar kolom ini tidak bisa dicari
                    }
                ]
            });

            // Menampilkan modal tambah User
            $('#tombolTambah').click(function() {
                $('#modalTambah').modal('show');
            });

            // Menambahkan User
            $('#simpanTambah').click(function() {
                var data = $('#formTambah').serialize();
                $.ajax({
                    url: 'ajax/ajax_users.php',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('#modalTambah').modal('hide');
                        table.ajax.reload();
                        // Mengosongkan formulir
                        $('#formTambah')[0].reset();
                        alert(response);
                    }
                });
            });

            // Menampilkan modal Edit User
            $('#anggota-table').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'ajax/ajax_users.php?id=' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#edit_id').val(data.id);
                        $('#edit_username').val(data.username);
                        $('#edit_password').val(data.password);
                        $('#edit_role').val(data.role);
                        $('#modalEdit').modal('show');
                    }
                });
            });

            // Menyimpan perubahan setelah edit
            $('#simpanEdit').click(function() {
                var data = $('#formEdit').serialize();
                $.ajax({
                    url: 'ajax/ajax_users.php',
                    type: 'PUT',
                    data: data,
                    success: function(response) {
                        $('#modalEdit').modal('hide');
                        table.ajax.reload();
                        alert(response);
                    }
                });
            });

            // Menghapus User
            $('#anggota-table').on('click', '.delete', function() {
                var id = $(this).data('id');
                if (confirm('Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: 'ajax/ajax_users.php',
                        type: 'DELETE',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            table.ajax.reload();
                            alert(response);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
