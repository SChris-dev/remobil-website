<?php
session_start();
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);

// Include the database configuration file
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Remobil | Data Rental</title>

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
            <h1>Data Rental</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Data Rental</li>
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
                <button class="btn btn-success" id="tombolTambah">Tambah Rental</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="rental-table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Rental ID</th>
                    <th>Car ID</th>
                    <th>Customer ID</th>
                    <th>Rental Date</th>
                    <th>Return Date</th>
                    <th>Total Price</th>
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
    
      <!-- Modal Tambah Rental -->
      <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTambahLabel">Tambah Rental</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="formTambah">
                <div class="form-group">
                  <label for="customer_id">Customer ID:</label>
                  <input type="number" class="form-control" id="customer_id" name="customer_id">
                </div>
                <div class="form-group">
                  <label for="car_id">Car ID:</label>
                  <input type="number" class="form-control" id="car_id" name="car_id">
                </div>
                <div class="form-group">
                  <label for="rental_date">Rental Date:</label>
                  <input type="date" class="form-control" id="rental_date" name="rental_date">
                </div>
                <div class="form-group">
                  <label for="return_date">Return Date:</label>
                  <input type="date" class="form-control" id="return_date" name="return_date">
                </div>
                <div class="form-group">
                  <label for="total_price">Total Price:</label>
                  <input type="number" class="form-control" id="total_price" name="total_price">
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

      <!-- Modal Edit Rental -->
      <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditLabel">Edit Rental</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="formEdit">
                <input type="hidden" id="edit_rental_id" name="rental_id">
                <div class="form-group">
                  <label for="edit_customer_id">Customer ID:</label>
                  <input type="number" class="form-control" id="edit_customer_id" name="customer_id">
                </div>
                <div class="form-group">
                  <label for="edit_car_id">Car ID:</label>
                  <input type="number" class="form-control" id="edit_car_id" name="car_id">
                </div>
                <div class="form-group">
                  <label for="edit_rental_date">Rental Date:</label>
                  <input type="date" class="form-control" id="edit_rental_date" name="rental_date">
                </div>
                <div class="form-group">
                  <label for="edit_return_date">Return Date:</label>
                  <input type="date" class="form-control" id="edit_return_date" name="return_date">
                </div>
                <div class="form-group">
                  <label for="edit_total_price">Total Price:</label>
                  <input type="number" class="form-control" id="edit_total_price" name="total_price">
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
    // Initialize DataTables
    var table = $('#rental-table').DataTable({
        "ajax": {
            "url": "ajax/ajax_rental.php",
            "type": "GET",
            "dataSrc": ""
        },
        "columns": [
            { "data": "rental_id" },
            { "data": "car_id" },
            { "data": "customer_id" },
            { "data": "rental_date" },
            { "data": "return_date" },
            { "data": "total_price" },
            { "data": null, "render": function(data, type, row) {
                return '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.rental_id + '"><i class="fas fa-edit"></i></button> ' +
                       '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.rental_id + '"><i class="fas fa-trash"></i></button>';
            }}
        ]
    });

    // Show Add Rental Modal
    $('#tombolTambah').click(function() {
        $('#modalTambah').modal('show');
    });

    // Add Rental
    $('#simpanTambah').click(function() {
        var data = {
            customer_id: $('#customer_id').val(),
            car_id: $('#car_id').val(),
            rental_date: $('#rental_date').val(),
            return_date: $('#return_date').val(),
            total_price: $('#total_price').val()
        };
        $.ajax({
            url: 'ajax/ajax_rental.php',
            type: 'POST',
            data: data,
            success: function(response) {
                $('#modalTambah').modal('hide');
                table.ajax.reload();
                $('#formTambah')[0].reset();
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error("Error adding rental:", error);
                alert("Error adding rental. Please check the console for details.");
            }
        });
    });

    // Show Edit Rental Modal
    $('#rental-table').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'ajax/ajax_rental.php?id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#edit_rental_id').val(data.rental_id);
                $('#edit_customer_id').val(data.customer_id);
                $('#edit_car_id').val(data.car_id);
                $('#edit_rental_date').val(data.rental_date);
                $('#edit_return_date').val(data.return_date);
                $('#edit_total_price').val(data.total_price);
                $('#modalEdit').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching rental data:", error);
                console.error("Response Text:", xhr.responseText);
                alert("Error fetching rental data. Please check the console for details.");
            }
        });
    });

    // Save changes after editing
    $('#simpanEdit').click(function() {
        var data = {
            rental_id: $('#edit_rental_id').val(),
            customer_id: $('#edit_customer_id').val(),
            car_id: $('#edit_car_id').val(),
            rental_date: $('#edit_rental_date').val(),
            return_date: $('#edit_return_date').val(),
            total_price: $('#edit_total_price').val()
        };
        $.ajax({
            url: 'ajax/ajax_rental.php',
            type: 'PUT',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                $('#modalEdit').modal('hide');
                table.ajax.reload();
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error("Error updating rental:", error);
                alert("Error updating rental. Please check the console for details.");
            }
        });
    });

    // Delete Rental
    $('#rental-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this rental?')) {
            $.ajax({
                url: 'ajax/ajax_rental.php',
                type: 'DELETE',
                data: JSON.stringify({rental_id: id}),
                contentType: 'application/json',
                success: function(response) {
                    table.ajax.reload();
                    alert(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting rental:", error);
                    alert("Error deleting rental. Please check the console for details.");
                }
            });
        }
    });
});
</script>
</body>
</html>