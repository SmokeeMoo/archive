<?php
require_once('../../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['booking_id'] ?? '';
    $approved = $_POST['approved'] ?? '';

    try {
        $pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("UPDATE booking SET approved = ? WHERE booking_id = ?");
        $stmt->execute([$approved, $bookingId]);

        echo "Updated successfully";

    } catch(PDOException $e) {
        die("Database connection error: " . $e->getMessage());
    }
}
?>
