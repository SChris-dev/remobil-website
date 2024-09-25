<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "remobil";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $stmt = $conn->prepare("SELECT * FROM rentals WHERE rental_id = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        } else {
            echo json_encode(["error" => "Rental not found"]);
        }
        exit;
    } else {
        $result = $conn->query("SELECT * FROM rentals");
        $rentals = array();
        while ($row = $result->fetch_assoc()) {
            $rentals[] = $row;
        }
        echo json_encode($rentals);
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST["customer_id"];
    $car_id = $_POST["car_id"];
    $rental_date = $_POST["rental_date"];
    $return_date = $_POST["return_date"];
    $total_price = $_POST["total_price"];

    $stmt = $conn->prepare("INSERT INTO rentals (customer_id, car_id, rental_date, return_date, total_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissd", $customer_id, $car_id, $rental_date, $return_date, $total_price);

    if ($stmt->execute()) {
        echo "Rental data added successfully";
    } else {
        echo "Error adding rental data: " . $stmt->error;
    }
    
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    $rental_id = $data["rental_id"];
    $customer_id = $data["customer_id"];
    $car_id = $data["car_id"];
    $rental_date = $data["rental_date"];
    $return_date = $data["return_date"];
    $total_price = $data["total_price"];

    $stmt = $conn->prepare("UPDATE rentals SET customer_id = ?, car_id = ?, rental_date = ?, return_date = ?, total_price = ? WHERE rental_id = ?");
    $stmt->bind_param("iissdi", $customer_id, $car_id, $rental_date, $return_date, $total_price, $rental_id);

    if ($stmt->execute()) {
        echo "Rental data updated successfully";
    } else {
        echo "Error updating rental data: " . $stmt->error;
    }

} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $rental_id = $data["rental_id"];

    $stmt = $conn->prepare("DELETE FROM rentals WHERE rental_id = ?");
    $stmt->bind_param("i", $rental_id);

    if ($stmt->execute()) {
        echo "Rental data deleted successfully";
    } else {
        echo "Error deleting rental data: " . $stmt->error;
    }
}

$conn->close();
?>
