<?php
require_once 'layouts/header.php';
require_once 'config/database.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user's reservations
$reservations_sql = "SELECT r.*, h.name as hotel_name, h.image_url 
                    FROM reservations r 
                    JOIN hotels h ON r.hotel_id = h.hotel_id 
                    WHERE r.user_id = ? 
                    ORDER BY r.check_in_date DESC 
                    LIMIT 3";
$reservations_stmt = $conn->prepare($reservations_sql);
$reservations_stmt->execute([$user_id]);
$recent_reservations = $reservations_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch user's reviews
$reviews_sql = "SELECT r.*, h.name as hotel_name 
                FROM reviews r 
                JOIN hotels h ON r.hotel_id = h.hotel_id 
                WHERE r.user_id = ? 
                ORDER BY r.created_at DESC 
                LIMIT 3";
$reviews_stmt = $conn->prepare($reviews_sql);
$reviews_stmt->execute([$user_id]);
$recent_reviews = $reviews_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-[40vh] flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Mon Profil</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Gérez vos informations personnelles et suivez vos activités
            </p>
        </div>
    </div>
</div>

<!-- Profile Content -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-right">
                    <div class="text-center mb-6">
                        <div class="w-32 h-32 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-4xl font-bold text-blue-600">
                                <?php echo strtoupper(substr($user['firstname'], 0, 1) . substr($user['lastname'], 0, 1)); ?>
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>
                        </h2>
                        <p class="text-gray-600">Membre depuis <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                    </div>

                    <nav class="space-y-2">
                        <a href="#profile" class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg">
                            <i class="fas fa-user mr-3"></i>
                            Informations personnelles
                        </a>
                        <a href="my-reservations.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Mes réservations
                        </a>
                        <a href="my-reviews.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-star mr-3"></i>
                            Mes avis
                        </a>
                        <a href="settings.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-cog mr-3"></i>
                            Paramètres
                        </a>
                        <a href="logout.php" class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Déconnexion
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8" data-aos="fade-left">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Informations personnelles</h3>
                    <form action="update_profile.php" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                <input type="text" 
                                       name="lastname" 
                                       value="<?php echo htmlspecialchars($user['lastname']); ?>" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                <input type="text" 
                                       name="firstname" 
                                       value="<?php echo htmlspecialchars($user['firstname']); ?>" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" 
                                   name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone']); ?>" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                            Mettre à jour
                        </button>
                    </form>
                </div>

                <!-- Recent Reservations -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8" data-aos="fade-left" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Réservations récentes</h3>
                        <a href="my-reservations.php" class="text-blue-600 hover:text-blue-700">Voir tout</a>
                    </div>
                    
                    <?php if (empty($recent_reservations)): ?>
                    <p class="text-gray-600">Aucune réservation récente</p>
                    <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($recent_reservations as $reservation): ?>
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                            <img src="<?php echo htmlspecialchars($reservation['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($reservation['hotel_name']); ?>"
                                 class="w-20 h-20 object-cover rounded-lg">
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900">
                                    <?php echo htmlspecialchars($reservation['hotel_name']); ?>
                                </h4>
                                <p class="text-gray-600">
                                    Du <?php echo date('d/m/Y', strtotime($reservation['check_in_date'])); ?> 
                                    au <?php echo date('d/m/Y', strtotime($reservation['check_out_date'])); ?>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Recent Reviews -->
                <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Avis récents</h3>
                        <a href="my-reviews.php" class="text-blue-600 hover:text-blue-700">Voir tout</a>
                    </div>
                    
                    <?php if (empty($recent_reviews)): ?>
                    <p class="text-gray-600">Aucun avis récent</p>
                    <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($recent_reviews as $review): ?>
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-900">
                                    <?php echo htmlspecialchars($review['hotel_name']); ?>
                                </h4>
                                <div class="flex items-center">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="text-gray-600"><?php echo htmlspecialchars($review['comment']); ?></p>
                            <p class="text-sm text-gray-500 mt-2">
                                <?php echo date('d/m/Y', strtotime($review['created_at'])); ?>
                            </p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'layouts/footer.php'; ?> 