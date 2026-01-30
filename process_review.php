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
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment']);

    try {
        // Validate rating
        if ($rating < 1 || $rating > 5) {
            throw new Exception("La note doit être comprise entre 1 et 5");
        }

        // Validate comment length
        if (strlen($comment) < 10) {
            throw new Exception("Le commentaire doit contenir au moins 10 caractères");
        }

        // Check if user has completed a stay
        $check_sql = "SELECT COUNT(*) as stay_count 
                     FROM reservations 
                     WHERE user_id = ? 
                     AND hotel_id = ? 
                     AND status = 'confirmed'
                     AND check_out_date < CURRENT_DATE";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute([$user_id, $hotel_id]);
        $check = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($check['stay_count'] == 0) {
            throw new Exception("Vous devez avoir séjourné dans cet hôtel pour pouvoir laisser un avis");
        }

        // Check if user has already reviewed
        $review_check_sql = "SELECT COUNT(*) as review_count FROM reviews WHERE user_id = ? AND hotel_id = ?";
        $review_check_stmt = $conn->prepare($review_check_sql);
        $review_check_stmt->execute([$user_id, $hotel_id]);
        $review_check = $review_check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($review_check['review_count'] > 0) {
            throw new Exception("Vous avez déjà donné votre avis sur cet hôtel");
        }

        // Insert review
        $sql = "INSERT INTO reviews (user_id, hotel_id, rating, comment, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $user_id,
            $hotel_id,
            $rating,
            $comment
        ]);

        $_SESSION['success'] = "Votre avis a été publié";
        header("Location: hotel.php?id=" . $hotel_id);
        exit();

    } catch(Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: add_review.php?hotel_id=" . $hotel_id);
        exit();
    }
} else {
    header("Location: hotels.php");
    exit();
} 