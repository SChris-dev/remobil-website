<?php
session_start();
include "../config.php";

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carId = $_POST['carId'];
    $customerId = $_SESSION['user_id'];
    $rentalDate = $_POST['rentDate'];
    $returnDate = $_POST['returnDate'];

    // Check if the car is still available
    $checkSql = "SELECT status FROM cars WHERE car_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $carId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $car = $result->fetch_assoc();

    if ($car['status'] != 'available') {
        echo "This car is no longer available";
        exit();
    }

    // Calculate total price (you may want to implement your own pricing logic)
    $rentDateTime = new DateTime($rentalDate);
    $returnDateTime = new DateTime($returnDate);
    $interval = $rentDateTime->diff($returnDateTime);
    $days = $interval->days + 1; // Including the first day
    $pricePerDay = 50; // Example price per day
    $totalPrice = $days * $pricePerDay;

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert rental record
        $rentSql = "INSERT INTO rentals (car_id, customer_id, rental_date, return_date, total_price) VALUES (?, ?, ?, ?, ?)";
        $rentStmt = $conn->prepare($rentSql);
        $rentStmt->bind_param("iissd", $carId, $customerId, $rentalDate, $returnDate, $totalPrice);
        $rentStmt->execute();

        // Update car status
        $updateSql = "UPDATE cars SET status = 'rented' WHERE car_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $carId);
        $updateStmt->execute();

        // Commit transaction
        $conn->commit();

        echo "success";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $rentStmt->close();
    $updateStmt->close();
} else {
    echo "Invalid request method";
}

$conn->close();
?>