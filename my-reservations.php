<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'config/database.php';

// Handle cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    
    // Check if reservation is past or not pending
    $stmt = $conn->prepare("
        SELECT r.*, h.name as hotel_name 
        FROM reservations r 
        JOIN hotels h ON r.hotel_id = h.hotel_id 
        WHERE r.reservation_id = ? AND r.user_id = ?
    ");
    $stmt->execute([$reservation_id, $_SESSION['user_id']]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($reservation) {
        // Check if reservation is past
        $check_out_date = new DateTime($reservation['check_out_date']);
        $today = new DateTime();
        
        if ($check_out_date < $today) {
            $_SESSION['error'] = "Impossible d'annuler une réservation passée.";
        } 
        // Check if reservation is not pending
        elseif ($reservation['status'] !== 'pending') {
            $_SESSION['error'] = "Seules les réservations en attente peuvent être annulées.";
        }
        else {
            // Only allow cancellation if pending and not past
            $stmt = $conn->prepare("UPDATE reservations SET status = 'cancelled' WHERE reservation_id = ? AND user_id = ?");
            $stmt->execute([$reservation_id, $_SESSION['user_id']]);
            $_SESSION['success'] = "Réservation annulée avec succès.";
        }
    }
    
    header("Location: my-reservations.php");
    exit();
}

// Fetch all user's reservations
$user_id = $_SESSION['user_id'];
$sql = "SELECT r.*, h.name as hotel_name, h.image_url, h.description, c.name as category_name
        FROM reservations r 
        JOIN hotels h ON r.hotel_id = h.hotel_id 
        LEFT JOIN categories c ON h.category_id = c.category_id
        WHERE r.user_id = ? 
        ORDER BY r.check_in_date DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'layouts/header.php';
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-[40vh] flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Mes Réservations</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Gérez vos réservations et planifiez vos prochains séjours
            </p>
        </div>
    </div>
</div>

<!-- Reservations List -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6">
            <?php 
            echo htmlspecialchars($_SESSION['error']);
            unset($_SESSION['error']);
            ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-50 text-green-800 p-4 rounded-lg mb-6">
            <?php 
            echo htmlspecialchars($_SESSION['success']);
            unset($_SESSION['success']);
            ?>
        </div>
        <?php endif; ?>
        
        <?php if (empty($reservations)): ?>
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-calendar-times text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Aucune réservation</h2>
            <p class="text-gray-600 mb-8">Vous n'avez pas encore effectué de réservation</p>
            <a href="hotels.php" 
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Découvrir nos hôtels
            </a>
        </div>
        <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($reservations as $reservation): ?>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-up">
                <div class="md:flex">
                    <div class="md:flex-shrink-0">
                        <img class="h-48 w-full md:w-48 object-cover" 
                             src="<?php echo htmlspecialchars($reservation['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($reservation['hotel_name']); ?>">
                    </div>
                    <div class="p-8 w-full">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">
                                <?php echo htmlspecialchars($reservation['hotel_name']); ?>
                            </h3>
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                <?php 
                                switch($reservation['status']) {
                                    case 'confirmed':
                                        echo 'bg-green-100 text-green-800';
                                        break;
                                    case 'pending':
                                        echo 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'cancelled':
                                        echo 'bg-red-100 text-red-800';
                                        break;
                                }
                                ?>">
                                <?php 
                                switch($reservation['status']) {
                                    case 'confirmed':
                                        echo 'Confirmée';
                                        break;
                                    case 'pending':
                                        echo 'En attente';
                                        break;
                                    case 'cancelled':
                                        echo 'Annulée';
                                        break;
                                }
                                ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">
                            <?php echo htmlspecialchars($reservation['category_name']); ?>
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <span class="block text-sm text-gray-500">Check-in</span>
                                <span class="block text-lg font-medium text-gray-900">
                                    <?php echo date('d/m/Y', strtotime($reservation['check_in_date'])); ?>
                                </span>
                            </div>
                            <div>
                                <span class="block text-sm text-gray-500">Check-out</span>
                                <span class="block text-lg font-medium text-gray-900">
                                    <?php echo date('d/m/Y', strtotime($reservation['check_out_date'])); ?>
                                </span>
                            </div>
                            <div>
                                <span class="block text-sm text-gray-500">Voyageurs</span>
                                <span class="block text-lg font-medium text-gray-900">
                                    <?php echo $reservation['num_guests']; ?> personne<?php echo $reservation['num_guests'] > 1 ? 's' : ''; ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="block text-sm text-gray-500">Type de chambre</span>
                                <span class="block text-lg font-medium text-gray-900">
                                    <?php echo htmlspecialchars($reservation['room_type']); ?>
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="block text-sm text-gray-500">Prix total</span>
                                <span class="block text-2xl font-bold text-blue-600">
                                    <?php echo number_format($reservation['total_price'], 2); ?> €
                                </span>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-4">
                            <?php if ($reservation['status'] === 'pending'): ?>
                                <a href="modify_reservation.php?id=<?php echo $reservation['reservation_id']; ?>" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-edit mr-2"></i>
                                    Modifier
                                </a>
                                <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['reservation_id']; ?>">
                                    <button type="submit" 
                                            name="cancel_reservation"
                                            class="inline-flex items-center px-4 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 hover:bg-red-50">
                                        <i class="fas fa-times mr-2"></i>
                                        Annuler
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'layouts/footer.php'; ?> 