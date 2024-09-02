<?php
    require_once('../../config.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookingId = $_POST['booking_id'] ?? '';
        
        try {
            $pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("DELETE FROM booking WHERE booking_id = ?");
            
            if($stmt->execute([$bookingId])) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
                } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete booking']);
            }
            
            } catch(PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['status' => 'error', 'message' => 'Database connection error']);
        }
        exit; // Exit the script after sending the response
    }
?>
