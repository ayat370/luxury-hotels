<?php
session_start();
require_once 'layouts/header.php';
require_once 'config/database.php';

// Fetch categories
$categories_sql = "SELECT * FROM categories";
$categories_stmt = $conn->query($categories_sql);

// Fetch hotels
$hotels_sql = "SELECT h.*, c.name as category_name FROM hotels h 
               JOIN categories c ON h.category_id = c.category_id";
$hotels_stmt = $conn->query($hotels_sql);

// Fetch featured hotels
$featured_hotels = $conn->query("
    SELECT h.*, c.name as category_name, 
           (SELECT AVG(rating) FROM reviews WHERE hotel_id = h.hotel_id) as avg_rating
    FROM hotels h
    LEFT JOIN categories c ON h.category_id = c.category_id
    WHERE h.featured = 1
    LIMIT 3
")->fetchAll(PDO::FETCH_ASSOC);

// Fetch testimonials
$testimonials = $conn->query("
    SELECT r.*, u.username, h.name as hotel_name 
    FROM reviews r
    JOIN users u ON r.user_id = u.user_id
    JOIN hotels h ON r.hotel_id = h.hotel_id
    WHERE r.rating >= 4
    ORDER BY r.created_at DESC
    LIMIT 3
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-screen flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Découvrez le Luxe et le Confort
                </h1>
                <p class="text-xl text-blue-100 mb-8">
                    Vivez une expérience unique dans nos hôtels de prestige. 
                    Des moments inoubliables vous attendent.
                </p>
                <div class="flex space-x-4">
                    <a href="hotels.php" class="bg-white text-blue-600 px-8 py-3 rounded-full text-lg font-medium hover:bg-blue-50 transition-colors">
                        Réserver Maintenant
                    </a>
                    <a href="about.php" class="border-2 border-white text-white px-8 py-3 rounded-full text-lg font-medium hover:bg-white hover:text-blue-600 transition-colors">
                        En Savoir Plus
                    </a>
                </div>
            </div>
            <div class="hidden lg:block" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                     alt="Luxury Hotel" 
                     class="rounded-lg shadow-2xl float-animation">
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pourquoi Nous Choisir</h2>
            <p class="text-xl text-gray-600">Des services exceptionnels pour un séjour inoubliable</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="100">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-concierge-bell text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Service 24/7</h3>
                <p class="text-gray-600">Notre équipe est à votre disposition 24h/24 et 7j/7 pour répondre à tous vos besoins.</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="200">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-spa text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Spa & Bien-être</h3>
                <p class="text-gray-600">Profitez de nos installations spa et bien-être pour une relaxation totale.</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="300">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-utensils text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Gastronomie</h3>
                <p class="text-gray-600">Découvrez une cuisine raffinée dans nos restaurants étoilés.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Hotels Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos Hôtels en Vedette</h2>
            <p class="text-xl text-gray-600">Découvrez nos établissements les plus prisés</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($featured_hotels as $index => $hotel): ?>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($hotel['name']); ?>"
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($hotel['name']); ?></h3>
                        <span class="text-sm text-gray-500"><?php echo htmlspecialchars($hotel['category_name']); ?></span>
                    </div>
                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars(substr($hotel['description'], 0, 100)) . '...'; ?></p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo $i <= $hotel['avg_rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-2xl font-bold text-blue-600"><?php echo number_format($hotel['price'], 2); ?> €</span>
                    </div>
                    <a href="hotel.php?id=<?php echo $hotel['hotel_id']; ?>" 
                       class="mt-6 block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Réserver
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Ce que disent nos clients</h2>
            <p class="text-xl text-gray-600">Des expériences authentiques partagées par nos hôtes</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($testimonials as $index => $testimonial): ?>
            <div class="bg-white p-8 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold text-xl">
                                <?php echo strtoupper(substr($testimonial['username'], 0, 1)); ?>
                            </span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($testimonial['username']); ?></h4>
                        <p class="text-gray-500"><?php echo htmlspecialchars($testimonial['hotel_name']); ?></p>
                    </div>
                </div>
                <div class="mb-4">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 italic">"<?php echo htmlspecialchars($testimonial['comment']); ?>"</p>
                <p class="text-sm text-gray-500 mt-4">
                    <?php echo date('d/m/Y', strtotime($testimonial['created_at'])); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-blue-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-white mb-4">Restez Informé</h2>
            <p class="text-xl text-blue-100 mb-8">Inscrivez-vous à notre newsletter pour recevoir nos meilleures offres</p>
            <form class="max-w-md mx-auto">
                <div class="flex">
                    <input type="email" placeholder="Votre adresse email" 
                           class="flex-1 px-6 py-3 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <button type="submit" class="bg-white text-blue-600 px-6 py-3 rounded-r-lg font-medium hover:bg-blue-50 transition-colors">
                        S'inscrire
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <i class="fas fa-hotel text-3xl text-blue-500"></i>
                    <span class="text-2xl font-bold">Luxury Hotels</span>
                </div>
                <p class="text-gray-400">
                    Votre destination de choix pour des séjours inoubliables.
                </p>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Liens Rapides</h4>
                <ul class="space-y-2">
                    <li><a href="about.php" class="text-gray-400 hover:text-white">À Propos</a></li>
                    <li><a href="hotels.php" class="text-gray-400 hover:text-white">Nos Hôtels</a></li>
                    <li><a href="services.php" class="text-gray-400 hover:text-white">Services</a></li>
                    <li><a href="contact.php" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><i class="fas fa-map-marker-alt mr-2"></i>123 Rue de Paris, 75000 Paris</li>
                    <li><i class="fas fa-phone mr-2"></i>+33 1 23 45 67 89</li>
                    <li><i class="fas fa-envelope mr-2"></i>contact@luxuryhotels.fr</li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Suivez-nous</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-2xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-2xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-2xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin text-2xl"></i></a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
            <p>&copy; 2024 Luxury Hotels. Tous droits réservés.</p>
        </div>
    </div>
</footer> 