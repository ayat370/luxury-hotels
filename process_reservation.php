<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $hotel_id = $_POST['hotel_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $room_type = $_POST['room_type'];
    $num_guests = $_POST['num_guests'];

    // Debug logging
    error_log("Attempting reservation with data:");
    error_log("user_id: " . $user_id);
    error_log("hotel_id: " . $hotel_id);
    error_log("check_in_date: " . $check_in_date);
    error_log("check_out_date: " . $check_out_date);
    error_log("room_type: " . $room_type);
    error_log("num_guests: " . $num_guests);

    try {
        // Check for date validity
        $check_in = new DateTime($check_in_date);
        $check_out = new DateTime($check_out_date);
        $today = new DateTime();

        if ($check_in < $today) {
            $_SESSION['error'] = "La date d'arrivée ne peut pas être dans le passé";
            header("Location: hotel.php?id=" . $hotel_id);
            exit();
        }

        if ($check_out <= $check_in) {
            $_SESSION['error'] = "La date de départ doit être après la date d'arrivée";
            header("Location: hotel.php?id=" . $hotel_id);
            exit();
        }

        // Check for existing pending reservations        $pending_sql = "SELECT COUNT(*) as pending_count                        FROM reservations                        WHERE user_id = ?                        AND status = 'pending'                       AND (                           (check_in_date <= ? AND check_out_date > ?)                            OR (check_in_date < ? AND check_out_date >= ?)                           OR (check_in_date >= ? AND check_out_date <= ?)                       )";                $pending_stmt = $conn->prepare($pending_sql);        $pending_stmt->execute([            $user_id,            $check_out_date, $check_in_date,            $check_out_date, $check_out_date,            $check_in_date, $check_out_date        ]);                $pending = $pending_stmt->fetch(PDO::FETCH_ASSOC);        if ($pending['pending_count'] > 0) {            $_SESSION['error'] = "Vous avez déjà une réservation en attente pour ces dates";            header("Location: hotel.php?id=" . $hotel_id);            exit();        }        // Check for conflicting reservations
        $conflict_sql = "SELECT COUNT(*) as conflict_count 
                        FROM reservations 
                        WHERE hotel_id = ? 
                        AND room_type = ?
                        AND status != 'cancelled'
                        AND (
                            (check_in_date <= ? AND check_out_date > ?) 
                            OR (check_in_date < ? AND check_out_date >= ?)
                            OR (check_in_date >= ? AND check_out_date <= ?)
                        )";
        
        $conflict_stmt = $conn->prepare($conflict_sql);
        $conflict_stmt->execute([
            $hotel_id, 
            $room_type,
            $check_out_date, $check_in_date,
            $check_out_date, $check_out_date,
            $check_in_date, $check_out_date
        ]);
        
        $conflict = $conflict_stmt->fetch(PDO::FETCH_ASSOC);

        if ($conflict['conflict_count'] > 0) {
            $_SESSION['error'] = "Cette chambre n'est pas disponible pour les dates sélectionnées";
            header("Location: hotel.php?id=" . $hotel_id);
            exit();
        }

        // Calculate total price
        $hotel_sql = "SELECT price FROM hotels WHERE hotel_id = ?";
        $hotel_stmt = $conn->prepare($hotel_sql);
        $hotel_stmt->execute([$hotel_id]);
        $hotel = $hotel_stmt->fetch(PDO::FETCH_ASSOC);

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
        
        $total_price = $hotel['price'] * $num_nights * $price_multiplier;

        // Create reservation
        $sql = "INSERT INTO reservations (user_id, hotel_id, check_in_date, check_out_date, 
                                        room_type, num_guests, total_price, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $user_id,
            $hotel_id,
            $check_in_date,
            $check_out_date,
            $room_type,
            $num_guests,
            $total_price
        ]);

        $_SESSION['success'] = "Votre réservation a été confirmée";
        header("Location: my-reservations.php");
        exit();

    } catch(Exception $e) {
        error_log("Reservation error: " . $e->getMessage());
        error_log("Stack trace: " . $e->getTraceAsString());
        $_SESSION['error'] = "Une erreur est survenue lors de la réservation";
        header("Location: hotel.php?id=" . $hotel_id);
        exit();
    }
} else {
    header("Location: hotels.php");
    exit();
} 