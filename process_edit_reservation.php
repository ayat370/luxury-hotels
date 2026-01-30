<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $reservation_id = $_POST['reservation_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $room_type = $_POST['room_type'];
    $num_guests = $_POST['num_guests'];

    try {
        // Verify reservation belongs to user and is pending
        $verify_sql = "SELECT r.*, h.price FROM reservations r 
                      JOIN hotels h ON r.hotel_id = h.hotel_id 
                      WHERE r.reservation_id = ? AND r.user_id = ? AND r.status = 'pending'";
        $verify_stmt = $conn->prepare($verify_sql);
        $verify_stmt->execute([$reservation_id, $user_id]);
        $reservation = $verify_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            throw new Exception("Cette réservation ne peut pas être modifiée");
        }

        // Check for date validity
        $check_in = new DateTime($check_in_date);
        $check_out = new DateTime($check_out_date);
        $today = new DateTime();

        if ($check_in < $today) {
            throw new Exception("La date d'arrivée ne peut pas être dans le passé");
        }

        if ($check_out <= $check_in) {
            throw new Exception("La date de départ doit être après la date d'arrivée");
        }

        // Check for conflicting reservations (excluding current reservation)
        $conflict_sql = "SELECT COUNT(*) as conflict_count 
                        FROM reservations 
                        WHERE hotel_id = ? 
                        AND room_type = ?
                        AND reservation_id != ?
                        AND status != 'cancelled'
                        AND (
                            (check_in_date <= ? AND check_out_date > ?) 
                            OR (check_in_date < ? AND check_out_date >= ?)
                            OR (check_in_date >= ? AND check_out_date <= ?)
                        )";
        
        $conflict_stmt = $conn->prepare($conflict_sql);
        $conflict_stmt->execute([
            $reservation['hotel_id'],
            $room_type,
            $reservation_id,
            $check_out_date, $check_in_date,
            $check_out_date, $check_out_date,
            $check_in_date, $check_out_date
        ]);
        
        $conflict = $conflict_stmt->fetch(PDO::FETCH_ASSOC);

        if ($conflict['conflict_count'] > 0) {
            throw new Exception("Cette chambre n'est pas disponible pour les dates sélectionnées");
        }

        // Calculate new total price
        $interval = $check_in->diff($check_out);
        $num_nights = $interval->days;
        
        // Apply room type multiplier
        $price_multiplier = 1;
        switch($room_type) {
            case 'deluxe':
                $price_multiplier = 1.5;
                break;
            case 'suite':
                $price_multiplier = 2;
                break;
        }
        
        $total_price = $reservation['price'] * $num_nights * $price_multiplier;

        // Update reservation
        $sql = "UPDATE reservations 
                SET check_in_date = ?, check_out_date = ?, room_type = ?, 
                    num_guests = ?, total_price = ?, updated_at = NOW()
                WHERE reservation_id = ? AND user_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $check_in_date,
            $check_out_date,
            $room_type,
            $num_guests,
            $total_price,
            $reservation_id,
            $user_id
        ]);

        $_SESSION['success'] = "Votre réservation a été mise à jour";
        header("Location: my-reservations.php");
        exit();

    } catch(Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: edit_reservation.php?id=" . $reservation_id);
        exit();
    }
} else {
    header("Location: my-reservations.php");
    exit();
} 