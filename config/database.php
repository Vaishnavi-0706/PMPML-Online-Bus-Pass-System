<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = 'Swara@2006'; // Default XAMPP password
$dbname = 'pmpml_bus_pass';

try {
    $pdo = new PDO("mysql:host=$host;port=3308;dbname=$dbname", $user, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!-- PDO  Php data object   pdo provide a way for php to communicate with database such as MYSQL-->