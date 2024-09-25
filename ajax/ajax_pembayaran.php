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
    if (isset($_GET["payment_id"])) {
        $id = $_GET["payment_id"];
        $stmt = $conn->prepare("SELECT * FROM payments WHERE payment_id = ?");
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
            echo json_encode(["error" => "Payment not found"]);
        }
    } else {
        $result = $conn->query("SELECT * FROM payments");
        $payments = array();
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
        echo json_encode($payments);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rental_id = $_POST["rental_id"];
    $payment_date = $_POST["payment_date"];
    $amount = $_POST["amount"];
    $payment_method = $_POST["payment_method"];

    $stmt = $conn->prepare("INSERT INTO payments (rental_id, payment_date, amount, payment_method) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $rental_id, $payment_date, $amount, $payment_method);

    if ($stmt->execute()) {
        echo "Payment data added successfully";
    } else {
        echo "Error adding payment data: " . $stmt->error;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    $payment_id = $data["payment_id"];
    $rental_id = $data["rental_id"];
    $payment_date = $data["payment_date"];
    $amount = $data["amount"];
    $payment_method = $data["payment_method"];

    $stmt = $conn->prepare("UPDATE payments SET rental_id = ?, payment_date = ?, amount = ?, payment_method = ? WHERE payment_id = ?");
    $stmt->bind_param("isdsi", $rental_id, $payment_date, $amount, $payment_method, $payment_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Payment data updated successfully"]);
    } else {
        echo json_encode(["error" => "Error updating payment data: " . $stmt->error]);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $payment_id = $data["payment_id"];

    $stmt = $conn->prepare("DELETE FROM payments WHERE payment_id = ?");
    $stmt->bind_param("i", $payment_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Payment data deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error deleting payment data: " . $stmt->error]);
    }
}

$conn->close();
?>