<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ujian5";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah data dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $product = trim($_POST['product']);
    $payment = trim($_POST['payment']);

    // Validasi sederhana untuk memastikan tidak ada kolom kosong
    if (empty($name) || empty($email) || empty($address) || empty($product) || empty($payment)) {
        die("Semua kolom wajib diisi!");
    }

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Format email tidak valid!");
    }

    // Menggunakan prepared statement untuk mencegah SQL Injection
    $stmt = $conn->prepare("INSERT INTO leads (name, email, address, product, payment_method) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $address, $product, $payment);

    if ($stmt->execute()) {
        echo "Pesanan berhasil disimpan!";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    echo "Metode pengiriman tidak valid.";
}
?>
