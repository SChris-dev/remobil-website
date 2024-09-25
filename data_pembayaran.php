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
  <title>Remobil | Data Pembayaran</title>

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
            <h1>Data Pembayaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Data Pembayaran</li>
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
                <button class="btn btn-success" id="tombolTambah">Tambah Pembayaran</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pembayaran-table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>NO</th>
                    <th>Rental ID</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
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
    
    <!-- Modal Tambah Pembayaran -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTambah">
                        <div class="form-group">
                            <label for="rental_id">Rental ID:</label>
                            <input type="number" class="form-control" id="rental_id" name="rental_id">
                        </div>
                        <div class="form-group">
                            <label for="payment_date">Payment Date:</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount:</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method:</label>
                            <input type="text" class="form-control" id="payment_method" name="payment_method">
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

    <!-- Modal Edit Pembayaran -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <input type="hidden" id="edit_payment_id" name="payment_id">
                        <div class="form-group">
                            <label for="edit_rental_id">Rental ID:</label>
                            <input type="number" class="form-control" id="edit_rental_id" name="rental_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_payment_date">Payment Date:</label>
                            <input type="date" class="form-control" id="edit_payment_date" name="payment_date">
                        </div>
                        <div class="form-group">
                            <label for="edit_amount">Amount:</label>
                            <input type="number" step="0.01" class="form-control" id="edit_amount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="edit_payment_method">Payment Method:</label>
                            <input type="text" class="form-control" id="edit_payment_method" name="payment_method">
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
$(function () {
    var table = $('#pembayaran-table').DataTable({
        "ajax": {
            "url": "ajax/ajax_pembayaran.php",
            "type": "GET",
            "dataSrc": ""
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) {
                return meta.row + 1;
            }},
            { "data": "rental_id" },
            { "data": "payment_date" },
            { "data": "amount" },
            { "data": "payment_method" },
            { "data": null, "render": function(data, type, row) {
                return '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.payment_id + '"><i class="fas fa-edit"></i></button> ' +
                       '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.payment_id + '"><i class="fas fa-trash"></i></button>';
            }}
        ]
    });

    // Menampilkan modal Tambah Pembayaran
    $('#tombolTambah').click(function() {
        $('#modalTambah').modal('show');
    });

    // Menambahkan Pembayaran
    $('#simpanTambah').click(function() {
        var data = {
            rental_id: $('#rental_id').val(),
            payment_date: $('#payment_date').val(),
            amount: $('#amount').val(),
            payment_method: $('#payment_method').val()
        };
        $.ajax({
            url: 'ajax/ajax_pembayaran.php',
            type: 'POST',
            data: data,
            success: function(response) {
                $('#modalTambah').modal('hide');
                table.ajax.reload();
                $('#formTambah')[0].reset();
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error("Error adding payment:", error);
                alert("Error adding payment. Please check the console for details.");
            }
        });
    });

    // Menampilkan modal Edit Pembayaran
    $('#pembayaran-table').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'ajax/ajax_pembayaran.php?payment_id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#edit_payment_id').val(data.payment_id);
                $('#edit_rental_id').val(data.rental_id);
                $('#edit_payment_date').val(data.payment_date);
                $('#edit_amount').val(data.amount);
                $('#edit_payment_method').val(data.payment_method);
                $('#modalEdit').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching payment data:", error);
                alert("Error fetching payment data. Please check the console for details.");
            }
        });
    });

    // Menyimpan perubahan setelah edit
    $('#simpanEdit').click(function() {
        var data = {
            payment_id: $('#edit_payment_id').val(),
            rental_id: $('#edit_rental_id').val(),
            payment_date: $('#edit_payment_date').val(),
            amount: $('#edit_amount').val(),
            payment_method: $('#edit_payment_method').val()
        };
        $.ajax({
            url: 'ajax/ajax_pembayaran.php',
            type: 'PUT',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                $('#modalEdit').modal('hide');
                table.ajax.reload();
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error("Error updating payment:", error);
                alert("Error updating payment. Please check the console for details.");
            }
        });
    });

    // Menghapus Pembayaran
    $('#pembayaran-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: 'ajax/ajax_pembayaran.php',
                type: 'DELETE',
                data: JSON.stringify({payment_id: id}),
                contentType: 'application/json',
                success: function(response) {
                    table.ajax.reload();
                    alert(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting payment:", error);
                    alert("Error deleting payment. Please check the console for details.");
                }
            });
        }
    });
});
</script>
</body>
</html>
