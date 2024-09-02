<?php
	require_once('../../config.php');
	session_start();
	$user_id = $_SESSION['user_id'];
	
	$current_page = $_GET['page'] ?? 1;
	$records_per_page = 25;
	
	try {
		$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$total_records_stmt = $pdo->prepare("SELECT COUNT(*) FROM booking WHERE user_id = :user_id");
		$total_records_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$total_records_stmt->execute();
		$total_records = $total_records_stmt->fetchColumn();
		$total_pages = ceil($total_records / $records_per_page);
		$starting_record = ($current_page - 1) * $records_per_page + 1;
		$ending_record = min($starting_record + $records_per_page - 1, $total_records);
		
		$offset = ($current_page - 1) * $records_per_page;
		
		$stmt = $pdo->prepare("SELECT * FROM booking WHERE user_id = :user_id ORDER BY booking_date DESC, booking_time ASC LIMIT :limit OFFSET :offset");
	    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();
		$bookings = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$tmappointment_dataform_name = $_GET['tmappointment_dataform_name'];
		$tmappointment_dataform_email = $_GET['tmappointment_dataform_email'];
		$tmappointment_dataform_phone = $_GET['tmappointment_dataform_phone'];
		$tmappointment_dataform_date = $_GET['tmappointment_dataform_date'];
		$tmappointment_dataform_time = $_GET['tmappointment_dataform_time'];
		$tmappointment_dataform_service = $_GET['tmappointment_dataform_service'];
		$tmappointment_dataform_approved = $_GET['tmappointment_dataform_approved'];
		
		echo '<table class="table" id="bookingsTable">
        <thead>
		<tr>
		<th>ID</th>
		<th>'.  $tmappointment_dataform_name .'</th>
		<th>'. $tmappointment_dataform_email .'</th>
		<th>'. $tmappointment_dataform_phone .'</th>
		<th>'. $tmappointment_dataform_date .'</th>
		<th>'. $tmappointment_dataform_time .'</th>
		<th>'. $tmappointment_dataform_service .'</th>
		<th>'. $tmappointment_dataform_approved .'</th>
		<th></th>
		</tr>
        </thead>
        <tbody>';
		
		foreach($bookings as $booking) {
		    echo '<tr data-booking-id="' . $booking->booking_id . '">';
			echo '<td>' . htmlspecialchars($booking->booking_id) . '</td>';
			echo '<td>' . htmlspecialchars($booking->name) . '</td>';
			echo '<td>' . htmlspecialchars($booking->email) . '</td>';
			echo '<td>' . htmlspecialchars($booking->phone) . '</td>';
			echo '<td>' . htmlspecialchars($booking->booking_date) . '</td>';
			echo '<td>' . date('H:i', strtotime(htmlspecialchars($booking->booking_time))) . '</td>';
			echo '<td>' . htmlspecialchars($booking->service) . '</td>';
			echo '<td><div class="custom-control custom-switch">';
			echo '<input type="checkbox" class="custom-control-input" id="approved_' . $booking->booking_id . '" ';
			echo ($booking->approved ? 'checked' : '') . ' onchange="toggleApproved(' . $booking->booking_id . ')">';
			echo '<label class="custom-control-label" for="approved_' . $booking->booking_id . '"></label></div></td>';
			echo '<td><button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $booking->booking_id . ')"><i class="fa fa-trash"></i></button></td>';
			echo '</tr>';
		}
		
		echo '</tbody></table>';
		echo '<nav aria-label="Page navigation"><ul class="pagination">';
		
		for($i = 1; $i <= $total_pages; $i++) {
			$active_class = $i == $current_page ? 'active' : '';
			echo '<li class="page-item ' . $active_class . '">';
			echo '<a class="page-link" href="#" onclick="loadPage(' . $i . '); return false;">' . $i . '</a>';
			echo '</li>';
		}
		
		echo '</ul></nav>';
		echo "<p class='showing-info'>Showing " . $starting_record . "-" . $ending_record . " out of " . $total_records . " results</p>";
		
		
		} catch(PDOException $e) {
		die("Database connection error: " . $e->getMessage());
	}
?>
