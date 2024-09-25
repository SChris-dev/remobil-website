<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
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
    <title>Remobil | Car Catalog</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --main-color: #E4501D;
            --secondary-color: #892D0E;
            --text-color: #FFFFFF;
            --light-bg: #FFF5F2;
            --dark-bg: #2C1006;
        }

        body {
            color: var(--dark-bg);
            font-family: 'Source Sans Pro', sans-serif;
        }

        .car-card {
            transition: all 0.3s ease;
        }
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: var(--main-color);
            border-color: var(--main-color);
        }
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
    </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    <?php include "php/navbar.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Car Catalog</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Car Catalog</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">
                    <?php
                    // Fetch cars from the database
                    $sql = "SELECT * FROM cars WHERE status = 'available'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-md-4 mb-4" data-aos="fade-up">
                                <div class="card car-card">
                                    <img src="dist/img/remobil/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['brand'] . ' ' . $row['model']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['brand'] . ' ' . $row['model']; ?></h5>
                                        <p class="card-text">Year: <?php echo $row['year']; ?></p>
                                        <p class="card-text">License Plate: <?php echo $row['license_plate']; ?></p>
                                        <button type="button" class="btn btn-primary rent-btn" data-toggle="modal" data-target="#rentModal" 
                                                data-id="<?php echo $row['car_id']; ?>" 
                                                data-brand="<?php echo $row['brand']; ?>" 
                                                data-model="<?php echo $row['model']; ?>">
                                            Rent Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>No cars available at the moment.</p>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <?php include "php/footer.php"; ?>
</div>

<!-- Rent Modal -->
<div class="modal fade" id="rentModal" tabindex="-1" role="dialog" aria-labelledby="rentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rentModalLabel">Rent a Car</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rentForm">
                    <input type="hidden" id="carId" name="carId">
                    <div class="form-group">
                        <label for="carDetails">Car:</label>
                        <input type="text" class="form-control" id="carDetails" readonly>
                    </div>
                    <div class="form-group">
                        <label for="rentDate">Rent Date:</label>
                        <input type="date" class="form-control" id="rentDate" name="rentDate" required>
                    </div>
                    <div class="form-group">
                        <label for="returnDate">Return Date:</label>
                        <input type="date" class="form-control" id="returnDate" name="returnDate" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmRent">Confirm Rental</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init();

$(document).ready(function() {
    $('.rent-btn').click(function() {
        var carId = $(this).data('id');
        var brand = $(this).data('brand');
        var model = $(this).data('model');
        
        $('#carId').val(carId);
        $('#carDetails').val(brand + ' ' + model);
    });

    $('#confirmRent').click(function() {
        var carId = $('#carId').val();
        var rentDate = $('#rentDate').val();
        var returnDate = $('#returnDate').val();

        $.ajax({
            url: 'ajax/process_rental.php',
            type: 'POST',
            data: {
                carId: carId,
                rentDate: rentDate,
                returnDate: returnDate
            },
            success: function(response) {
                if(response === 'success') {
                    alert('Car rented successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response);
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
</script>
</body>
</html>