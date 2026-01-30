<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    
    $sql = "INSERT INTO reservations (hotel_id, user_id, check_in_date, check_out_date) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    try {
        $stmt->execute([$hotel_id, $_SESSION['user_id'], $check_in, $check_out]);
        header("Location: index.php?success=1");
        exit();
    } catch(PDOException $e) {
        $error = "Error making reservation: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Hotel - <?php echo htmlspecialchars($hotel['name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
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
        input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book Hotel: <?php echo htmlspecialchars($hotel['name']); ?></h2>
        <p>Price per night: $<?php echo number_format($hotel['price'], 2); ?></p>
        
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Check-in Date:</label>
                <input type="date" name="check_in" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            
            <div class="form-group">
                <label>Check-out Date:</label>
                <input type="date" name="check_out" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
            
            <button type="submit" class="button">Book Now</button>
            <a href="index.php" class="button" style="text-decoration: none; margin-left: 10px;">Cancel</a>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            var checkIn = new Date(document.querySelector('input[name="check_in"]').value);
            var checkOut = new Date(document.querySelector('input[name="check_out"]').value);
            
            if (checkOut <= checkIn) {
                e.preventDefault();
                alert('Check-out date must be after check-in date');
            }
        });
    </script>
</body>
</html> 