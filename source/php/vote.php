<?php
    require_once('../../config.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $vote = (int)$_POST['vote'];
        $biolinkBlockId = (int)$_POST['biolinkBlockId'];
        
        try {
            $pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
            // Установка режима ошибок PDO
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
            //echo "Database connection error: " . $e->getMessage();
            die();
        }
        
        $sqlSelect = "SELECT JSON_UNQUOTE(JSON_EXTRACT(settings, '$.items[$vote].votes')) as currentVotes FROM biolinks_blocks WHERE biolink_block_id = :biolinkBlockId";
        
        $stmtSelect = $pdo->prepare($sqlSelect);
        
        $stmtSelect->bindParam(':biolinkBlockId', $biolinkBlockId, PDO::PARAM_INT);
        
        if ($stmtSelect->execute()) {
            $row = $stmtSelect->fetch(PDO::FETCH_ASSOC);
            $currentVotes = $row['currentVotes'];
            
            $newVotesValue = $currentVotes + 1; // Например, увеличиваем на 1
            
            $sqlUpdate = "UPDATE biolinks_blocks SET settings = JSON_SET(settings, '$.items[$vote].votes', :newVotesValue) WHERE biolink_block_id = :biolinkBlockId";
            
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            
            $stmtUpdate->bindParam(':newVotesValue', $newVotesValue, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':biolinkBlockId', $biolinkBlockId, PDO::PARAM_INT);
            
            if ($stmtUpdate->execute()) {
                // echo "The value has been updated successfully.";
                } else {
                // echo "Error updating the value: " . print_r($stmtUpdate->errorInfo(), true);
            }
            } else {
            //echo "Error when extracting the current value: " . print_r($stmtSelect->errorInfo(), true);
        }
        
        $response = array('success' => true, 'message' => 'The vote was successfully counted.');
        echo json_encode($response);
        } else {
        $response = array('success' => false, 'message' => 'Invalid request method.');
        echo json_encode($response);
    }
?>
