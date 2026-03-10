<?php
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    echo "<h1>Koneksi Aiven Berhasil!</h1>";
    echo "Terhubung ke: " . $host;
} catch (PDOException $e) {
    echo "<h1>Koneksi Gagal:</h1> " . $e->getMessage();
}
?>
