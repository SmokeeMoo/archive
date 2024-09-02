<?php
    require_once('../../config.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $query = "CREATE TABLE IF NOT EXISTS booking (
            booking_id INT AUTO_INCREMENT PRIMARY KEY,
            biolink_block_id INT NOT NULL,
            link_id INT NOT NULL,
            user_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            phone VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            booking_date DATE NOT NULL,
            booking_time TIME NOT NULL,
			service VARCHAR(255) NOT NULL,
            approved BOOLEAN NOT NULL DEFAULT FALSE,
            datetime DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($query);
            
            $biolinkBlockId = $_POST['biolink_block_id'] ?? null;
            $linkId = $_POST['link_id'] ?? null;
            $userId = $_POST['user_id'] ?? null;
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $service = $_POST['service'] ?? '';
            $bookingDate = $_POST['booking_date'] ?? '';
            $bookingTime = $_POST['booking_time'] ?? '';
            $approved = 0;
            
            $bookingDate = DateTime::createFromFormat('d/m/Y', $bookingDate);
            $bookingDate = $bookingDate->format('Y-m-d');
            
            //$startTime = date("H:i:s", strtotime($startTime));
            //$endTime = date("H:i:s", strtotime($endTime));
            
            $stmt = $pdo->prepare("INSERT INTO booking (biolink_block_id, link_id, user_id, name, phone, email, booking_date, booking_time, service, approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$biolinkBlockId, $linkId, $userId, $name, $phone, $email, $bookingDate, $bookingTime, $service, $approved]);
            
            $response_data = [
            'biolinkBlockId' => $biolinkBlockId,
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'service' => $service,
            'bookingDate' => $bookingDate,
            'bookingTime' => $bookingTime
            ];
            
            echo json_encode($response_data);
            
			
            
            } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }
?>



