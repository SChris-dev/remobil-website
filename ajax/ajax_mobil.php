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
    if (isset($_GET["car_id"])) {
        $id = $_GET["car_id"];
        $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
        if ($stmt === false) {
            die(json_encode(["error" => "Error preparing statement: " . $conn->error]));
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            die(json_encode(["error" => "Error executing statement: " . $stmt->error]));
        }
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        } else {
            echo json_encode(["error" => "Car not found"]);
        }
    } else {
        $result = $conn->query("SELECT * FROM cars");
        $cars = array();
        while ($row = $result->fetch_assoc()) {
            $cars[] = $row;
        }
        echo json_encode($cars);
    }
    exit;
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menambahkan data nilai
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $license_plate = $_POST["license_plate"];
    $status = $_POST["status"];
    $image = $_POST["image"];

    $stmt = $conn->prepare("INSERT INTO cars (brand, model, year, license_plate, status, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $brand, $model, $year, $license_plate, $status, $image);

    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan";
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }
    
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Mengedit data nilai
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["car_id"];
    $brand = $data["brand"];
    $model = $data["model"];
    $year = $data["year"];
    $license_plate = $data["license_plate"];
    $status = $data["status"];
    $image = $data["image"];

    $stmt = $conn->prepare("UPDATE cars SET brand = ?, model = ?, year = ?, license_plate = ?, status = ?, image = ? WHERE car_id = ?");
    $stmt->bind_param("ssisssi", $brand, $model, $year, $license_plate, $status, $image, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Data berhasil diperbarui"]);
    } else {
        throw new Exception("Gagal memperbarui data: " . $stmt->error);
    }

    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Menghapus data nilai
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["car_id"];

    $stmt = $conn->prepare("DELETE FROM cars WHERE car_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Data mobil berhasil dihapus"]);
    } else {
        throw new Exception("Gagal menghapus data mobil: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
