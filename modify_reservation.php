<?php
session_start();
require_once 'layouts/header.php';
require_once 'config/database.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$reservation_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];

// Fetch reservation details
$sql = "SELECT r.*, h.name as hotel_name, h.price as hotel_price, h.image_url 
        FROM reservations r
        JOIN hotels h ON r.hotel_id = h.hotel_id
        WHERE r.reservation_id = ? AND r.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$reservation_id, $user_id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

// If reservation not found or doesn't belong to user, redirect
if (!$reservation || $reservation['status'] !== 'pending') {
    $_SESSION['error'] = "Cette réservation ne peut pas être modifiée";
    header("Location: my-reservations.php");
    exit();
}
?>

<!-- Edit Reservation Form -->
<div class="pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-up">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Modifier la réservation</h1>
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                    En attente
                </span>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6">
                <?php 
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']);
                ?>
            </div>
            <?php endif; ?>

            <div class="flex items-center mb-6">
                <img src="<?php echo htmlspecialchars($reservation['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($reservation['hotel_name']); ?>"
                     class="w-24 h-24 object-cover rounded-lg">
                <div class="ml-4">
                    <h2 class="text-xl font-bold text-gray-900">
                        <?php echo htmlspecialchars($reservation['hotel_name']); ?>
                    </h2>
                    <p class="text-gray-600">
                        <?php echo number_format($reservation['hotel_price'], 2); ?> € / nuit
                    </p>
                </div>
            </div>

            <form action="process_modify_reservation.php" method="POST">
                <input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date d'arrivée</label>
                        <input type="date" 
                               name="check_in_date" 
                               required 
                               min="<?php echo date('Y-m-d'); ?>"
                               value="<?php echo $reservation['check_in_date']; ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de départ</label>
                        <input type="date" 
                               name="check_out_date" 
                               required 
                               min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                               value="<?php echo $reservation['check_out_date']; ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type de chambre</label>
                        <select name="room_type" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="standard" <?php echo $reservation['room_type'] === 'standard' ? 'selected' : ''; ?>>
                                Chambre Standard
                            </option>
                            <option value="deluxe" <?php echo $reservation['room_type'] === 'deluxe' ? 'selected' : ''; ?>>
                                Chambre Deluxe
                            </option>
                            <option value="suite" <?php echo $reservation['room_type'] === 'suite' ? 'selected' : ''; ?>>
                                Suite
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de personnes</label>
                        <select name="num_guests" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo $reservation['num_guests'] == $i ? 'selected' : ''; ?>>
                                <?php echo $i; ?> personne<?php echo $i > 1 ? 's' : ''; ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="my-reservations.php" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.querySelector('input[name="check_in_date"]');
    const checkOutInput = document.querySelector('input[name="check_out_date"]');

    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function() {
            const minCheckOut = new Date(this.value);
            minCheckOut.setDate(minCheckOut.getDate() + 1);
            checkOutInput.min = minCheckOut.toISOString().split('T')[0];
            
            if (checkOutInput.value && new Date(checkOutInput.value) <= new Date(this.value)) {
                checkOutInput.value = minCheckOut.toISOString().split('T')[0];
            }
        });
    }
});
</script>

<?php require_once 'layouts/footer.php'; ?> 