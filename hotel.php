<?php
require_once 'layouts/header.php';
require_once 'config/database.php';

// Get hotel ID from URL
$hotel_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch hotel details with category and average rating
$sql = "SELECT h.*, c.name as category_name,
        (SELECT AVG(rating) FROM reviews r WHERE r.hotel_id = h.hotel_id) as avg_rating,
        (SELECT COUNT(*) FROM reviews r WHERE r.hotel_id = h.hotel_id) as review_count
        FROM hotels h
        LEFT JOIN categories c ON h.category_id = c.category_id
        WHERE h.hotel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$hotel_id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

// If hotel not found, redirect to hotels page
if (!$hotel) {
    header("Location: hotels.php");
    exit();
}

// Fetch hotel reviews
$reviews_sql = "SELECT r.*, u.firstname, u.lastname 
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                WHERE r.hotel_id = ? 
                ORDER BY r.created_at DESC";
$reviews_stmt = $conn->prepare($reviews_sql);
$reviews_stmt->execute([$hotel_id]);
$reviews = $reviews_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hotel Details -->
<div class="pt-20">
    <!-- Hotel Image -->
    <div class="relative h-[60vh]">
        <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" 
             alt="<?php echo htmlspecialchars($hotel['name']); ?>"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold mb-4" data-aos="fade-up">
                    <?php echo htmlspecialchars($hotel['name']); ?>
                </h1>
                <div class="flex items-center space-x-4" data-aos="fade-up" data-aos-delay="100">
                    <span class="text-lg"><?php echo htmlspecialchars($hotel['category_name']); ?></span>
                    <div class="flex items-center">
                        <?php 
                        $rating = round($hotel['avg_rating'] ?? 0);
                        for ($i = 1; $i <= 5; $i++): 
                        ?>
                            <i class="fas fa-star <?php echo $i <= $rating ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                        <?php endfor; ?>
                        <span class="ml-2">(<?php echo $hotel['review_count']; ?> avis)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hotel Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Hotel Description -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                    <p class="text-gray-600 whitespace-pre-line">
                        <?php echo htmlspecialchars($hotel['description']); ?>
                    </p>
                </div>

                <!-- Reviews Section -->
                <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-up">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Avis des clients</h2>
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="add_review.php?hotel_id=<?php echo $hotel_id; ?>" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-star mr-2"></i>
                            Donner mon avis
                        </a>
                        <?php endif; ?>
                    </div>

                    <?php if (empty($reviews)): ?>
                    <p class="text-gray-600">Aucun avis pour le moment</p>
                    <?php else: ?>
                    <div class="space-y-6">
                        <?php foreach ($reviews as $review): ?>
                        <div class="border-b border-gray-200 pb-6 last:border-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="font-medium text-blue-600">
                                            <?php 
                                            echo strtoupper(substr($review['firstname'], 0, 1) . 
                                                          substr($review['lastname'], 0, 1)); 
                                            ?>
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-medium text-gray-900">
                                            <?php echo htmlspecialchars($review['firstname'] . ' ' . $review['lastname']); ?>
                                        </h4>
                                        <div class="flex items-center">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">
                                    <?php echo date('d/m/Y', strtotime($review['created_at'])); ?>
                                </span>
                            </div>
                            <p class="text-gray-600"><?php echo htmlspecialchars($review['comment']); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Reservation Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24" data-aos="fade-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Réserver</h3>
                    <div class="text-3xl font-bold text-blue-600 mb-6">
                        <?php echo number_format($hotel['price'], 2); ?> € <span class="text-sm text-gray-500">/ nuit</span>
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="process_reservation.php" method="POST">
                        <input type="hidden" name="hotel_id" value="<?php echo $hotel_id; ?>">
                        
                        <?php if (isset($_SESSION['error'])): ?>
                        <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6">
                            <?php 
                            echo htmlspecialchars($_SESSION['error']);
                            unset($_SESSION['error']);
                            ?>
                        </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date d'arrivée</label>
                            <input type="date" 
                                   name="check_in_date" 
                                   required 
                                   min="<?php echo date('Y-m-d'); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de départ</label>
                            <input type="date" 
                                   name="check_out_date" 
                                   required 
                                   min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de chambre</label>
                            <select name="room_type" 
                                    required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="standard">Chambre Standard</option>
                                <option value="deluxe">Chambre Deluxe</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de personnes</label>
                            <select name="num_guests" 
                                    required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> personne<?php echo $i > 1 ? 's' : ''; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                            Réserver maintenant
                        </button>
                    </form>
                    <?php else: ?>
                    <div class="text-center">
                        <p class="text-gray-600 mb-4">Connectez-vous pour réserver cet hôtel</p>
                        <a href="login.php" 
                           class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                            Se connecter
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure check-out date is after check-in date
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