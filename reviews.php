<?php
session_start();
require_once 'config/database.php';

if (!isset($_GET['hotel_id'])) {
    header("Location: index.php");
    exit();
}

$hotel_id = $_GET['hotel_id'];

// Fetch hotel details
$hotel_sql = "SELECT * FROM hotels WHERE hotel_id = ?";
$hotel_stmt = $conn->prepare($hotel_sql);
$hotel_stmt->execute([$hotel_id]);
$hotel = $hotel_stmt->fetch(PDO::FETCH_ASSOC);

if (!$hotel) {
    header("Location: index.php");
    exit();
}

// Handle new review submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    
    $sql = "INSERT INTO reviews (hotel_id, user_id, rating, comment) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    try {
        $stmt->execute([$hotel_id, $_SESSION['user_id'], $rating, $comment]);
        header("Location: reviews.php?hotel_id=" . $hotel_id . "&success=1");
        exit();
    } catch(PDOException $e) {
        $error = "Error submitting review: " . $e->getMessage();
    }
}

// Fetch reviews
$reviews_sql = "SELECT r.*, u.username, r.created_at 
                FROM reviews r
                JOIN users u ON r.user_id = u.user_id
                WHERE r.hotel_id = ?
                ORDER BY r.created_at DESC";
$reviews_stmt = $conn->prepare($reviews_sql);
$reviews_stmt->execute([$hotel_id]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reviews - <?php echo htmlspecialchars($hotel['name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .review-form, .review {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 100px;
        }
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .rating > input {
            display: none;
        }
        .rating > label {
            position: relative;
            width: 1.1em;
            font-size: 30px;
            color: #FFD700;
            cursor: pointer;
        }
        .rating > label::before {
            content: "★";
            position: absolute;
            opacity: 0;
        }
        .rating > label:hover:before,
        .rating > label:hover ~ label:before {
            opacity: 1 !important;
        }
        .rating > input:checked ~ label:before {
            opacity: 1;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
        .stars {
            color: #FFD700;
        }
        .review-meta {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reviews for <?php echo htmlspecialchars($hotel['name']); ?></h2>
        
        <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="review-form">
                <h3>Write a Review</h3>
                <?php if (isset($error)) { ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Rating:</label>
                        <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5" required/>
                            <label for="star5">★</label>
                            <input type="radio" id="star4" name="rating" value="4"/>
                            <label for="star4">★</label>
                            <input type="radio" id="star3" name="rating" value="3"/>
                            <label for="star3">★</label>
                            <input type="radio" id="star2" name="rating" value="2"/>
                            <label for="star2">★</label>
                            <input type="radio" id="star1" name="rating" value="1"/>
                            <label for="star1">★</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Comment:</label>
                        <textarea name="comment" required></textarea>
                    </div>
                    <button type="submit" class="button">Submit Review</button>
                </form>
            </div>
        <?php } ?>

        <div class="reviews">
            <?php while ($review = $reviews_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="review">
                    <div class="review-meta">
                        <strong><?php echo htmlspecialchars($review['username']); ?></strong>
                        <span class="stars">
                            <?php for ($i = 0; $i < $review['rating']; $i++) echo "★"; ?>
                        </span>
                        <span style="float: right">
                            <?php echo date('Y-m-d', strtotime($review['created_at'])); ?>
                        </span>
                    </div>
                    <p><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                </div>
            <?php } ?>
        </div>
        
        <a href="index.php" class="button" style="text-decoration: none;">Back to Hotels</a>
    </div>
</body>
</html> 