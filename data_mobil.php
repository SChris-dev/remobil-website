<?php
session_start();
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas') {
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
  <title>Remobil | Data Mobil</title>

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
  <?php include "php/navbar.php"; ?>
  <?php include "php/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Mobil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Data Mobil</li>
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
                <button class="btn btn-success" id="tombolTambah">Tambah Mobil</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="mobil-table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>NO</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>License Plate</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Action</th>
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
    
    <!-- Modal Tambah Mobil -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Mobil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTambah">
                        <div class="form-group">
                            <label for="brand">Brand:</label>
                            <input type="text" class="form-control" id="brand" name="brand">
                        </div>
                        <div class="form-group">
                            <label for="model">Model:</label>
                            <input type="text" class="form-control" id="model" name="model">
                        </div>
                        <div class="form-group">
                            <label for="year">Year:</label>
                            <input type="number" class="form-control" id="year" name="year">
                        </div>
                        <div class="form-group">
                            <label for="license_plate">License Plate:</label>
                            <input type="text" class="form-control" id="license_plate" name="license_plate">
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <input type="text" class="form-control" id="status" name="status">
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="text" class="form-control" id="image" name="image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpanTambah">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Mobil -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Mobil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <input type="hidden" id="edit_car_id" name="car_id">
                        <div class="form-group">
                            <label for="edit_brand">Brand:</label>
                            <input type="text" class="form-control" id="edit_brand" name="brand">
                        </div>
                        <div class="form-group">
                            <label for="edit_model">Model:</label>
                            <input type="text" class="form-control" id="edit_model" name="model">
                        </div>
                        <div class="form-group">
                            <label for="edit_year">Year:</label>
                            <input type="number" class="form-control" id="edit_year" name="year">
                        </div>
                        <div class="form-group">
                            <label for="edit_license_plate">License Plate:</label>
                            <input type="text" class="form-control" id="edit_license_plate" name="license_plate">
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status:</label>
                            <input type="text" class="form-control" id="edit_status" name="status">
                        </div>
                        <div class="form-group">
                            <label for="edit_image">Image:</label>
                            <input type="text" class="form-control" id="edit_image" name="image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpanEdit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include "php/footer.php"; ?>

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
<!-- DataTables  & Plugins -->
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
<!-- Page specific script -->
<script>
$(document).ready(function() {
    // Inisialisasi DataTables
    var table = $('#mobil-table').DataTable({
        "ajax": {
            "url": "ajax/ajax_mobil.php",
            "type": "GET",
            "dataSrc": ""
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) {
                return meta.row + 1;
            }},
            { "data": "brand" },
            { "data": "model" },
            { "data": "year" },
            { "data": "license_plate" },
            { "data": "status" },
            { "data": "image" },
            { "data": null, "render": function(data, type, row) {
                return '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.car_id + '"><i class="fas fa-edit"></i></button> ' +
                       '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.car_id + '"><i class="fas fa-trash"></i></button>';
            }}
        ]
    });

    // Menampilkan modal Tambah Mobil
    $('#tombolTambah').click(function() {
        $('#modalTambah').modal('show');
    });

    // Menambahkan Mobil
    $('#simpanTambah').click(function() {
        var data = {
            brand: $('#brand').val(),
            model: $('#model').val(),
            year: $('#year').val(),
            license_plate: $('#license_plate').val(),
            status: $('#status').val(),
            image: $('#image').val()
        };
        $.ajax({
            url: 'ajax/ajax_mobil.php',
            type: 'POST',
            data: data,
            success: function(response) {
                $('#modalTambah').modal('hide');
                table.ajax.reload();
                $('#formTambah')[0].reset();
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error("Error adding car:", error);
                alert("Error adding car. Please check the console for details.");
            }
        });
    });

    // Menampilkan modal Edit Mobil
    $('#mobil-table').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'ajax/ajax_mobil.php?car_id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log("Received data:", data);
                $('#edit_car_id').val(data.car_id);
                $('#edit_brand').val(data.brand);
                $('#edit_model').val(data.model);
                $('#edit_year').val(data.year);
                $('#edit_license_plate').val(data.license_plate);
                $('#edit_status').val(data.status);
                $('#edit_image').val(data.image);
                $('#modalEdit').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching car data:", error);
                console.error("Response Text:", xhr.responseText);
                alert("Error fetching car data. Please check the console for details.");
            }
        });
    });

    // Menyimpan perubahan setelah edit
    $('#simpanEdit').click(function() {
        var data = {
            car_id: $('#edit_car_id').val(),
            brand: $('#edit_brand').val(),
            model: $('#edit_model').val(),
            year: $('#edit_year').val(),
            license_plate: $('#edit_license_plate').val(),
            status: $('#edit_status').val(),
            image: $('#edit_image').val()
        };
        $.ajax({
            url: 'ajax/ajax_mobil.php',
            type: 'PUT',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                $('#modalEdit').modal('hide');
                table.ajax.reload();
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error("Error updating car:", error);
                alert("Error updating car. Please check the console for details.");
            }
        });
    });

    // Menghapus Mobil
    $('#mobil-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: 'ajax/ajax_mobil.php',
                type: 'DELETE',
                data: JSON.stringify({car_id: id}),
                contentType: 'application/json',
                success: function(response) {
                    table.ajax.reload();
                    alert(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting car:", error);
                    alert("Error deleting car. Please check the console for details.");
                }
            });
        }
    });
});
</script>
</body>
</html>
