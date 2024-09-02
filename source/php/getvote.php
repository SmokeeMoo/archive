<?php	
    
	require_once('../../config.php');
    try {
        $pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        //echo "Database connection error: " . $e->getMessage();
        die();
    }
    $biolinkBlockId = (int)$_POST['biolinkBlockId'];
    $sql = "SELECT 
    JSON_UNQUOTE(JSON_EXTRACT(settings, CONCAT('$.items[', numbers.n, '].title'))) AS title,
    JSON_UNQUOTE(JSON_EXTRACT(settings, CONCAT('$.items[', numbers.n, '].votes'))) AS votes
    FROM (
    SELECT 0 AS n UNION ALL
    SELECT 1 UNION ALL
    SELECT 2 UNION ALL
    SELECT 3 UNION ALL
    SELECT 4 UNION ALL
    SELECT 5 UNION ALL
    SELECT 6 UNION ALL
    SELECT 7 UNION ALL
    SELECT 8 UNION ALL
    SELECT 9
    ) numbers
    JOIN biolinks_blocks ON JSON_UNQUOTE(JSON_EXTRACT(settings, CONCAT('$.items[', numbers.n, ']'))) IS NOT NULL
    WHERE biolink_block_id = :biolinkBlockId";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':biolinkBlockId', $biolinkBlockId, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($response);
    
?>