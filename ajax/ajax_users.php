<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "remobil";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        $result = $koneksi->query("SELECT * FROM users");
        $data = array();

        $i=0;
        while ($row = $result->fetch_assoc()) {
            $i++;
            $row['no'] = $i;
            $row['aksi'] = '<button class="edit btn btn-primary" data-id="' . $row['id'] . '"><i class="fas fa-edit"></i></button>
                            <button class="delete btn btn-danger" data-id="' . $row['id'] . '"><i class="fas fa-trash"></i></button>';
            $data[] = $row;
        }

        echo json_encode(["data" => $data]);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menambahkan data nilai
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = md5($password);
    $role = $_POST["role"];

    $stmt = $koneksi->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan";
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }
    
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Mengedit data nilai
    parse_str(file_get_contents("php://input"), $data);
    $id = $data["id"];
    $username = $data["username"];
    $password = $data["password"];
    $hashed_password = md5($password);
    $role = $data["role"];

    $stmt = $koneksi->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $hashed_password, $role, $id);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui";
    } else {
        echo "Gagal memperbarui data: " . $stmt->error;
    }

    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Menghapus data nilai
    parse_str(file_get_contents("php://input"), $data);
    $id = $data["id"];

    $stmt = $koneksi->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Data nilai berhasil dihapus";
    } else {
        echo "Gagal menghapus data nilai: " . $stmt->error;
    }

    $stmt->close();
}

$koneksi->close();
?>
