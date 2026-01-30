<?php
require_once 'layouts/header.php';
require_once 'config/database.php';

// Fetch all hotels with their categories
$hotels_sql = "SELECT h.*, c.name as category_name,
               (SELECT AVG(rating) FROM reviews WHERE hotel_id = h.hotel_id) as avg_rating
               FROM hotels h
               LEFT JOIN categories c ON h.category_id = c.category_id
               ORDER BY h.created_at DESC";
$hotels = $conn->query($hotels_sql)->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories for filter
$categories_sql = "SELECT * FROM categories";
$categories = $conn->query($categories_sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-[40vh] flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Nos Hôtels</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Découvrez notre sélection d'hôtels de luxe pour un séjour inoubliable
            </p>
        </div>
    </div>
</div>

<!-- Filters Section -->
<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <div class="flex gap-4">
                <select id="category-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <select id="price-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Prix</option>
                    <option value="asc">Prix croissant</option>
                    <option value="desc">Prix décroissant</option>
                </select>
            </div>
            <div class="relative">
                <input type="text" 
                       placeholder="Rechercher un hôtel..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 w-full">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>
</section>

<!-- Hotels Grid -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($hotels as $index => $hotel): ?>
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
                            <?php 
                            $rating = round($hotel['avg_rating'] ?? 0);
                            for ($i = 1; $i <= 5; $i++): 
                            ?>
                                <i class="fas fa-star <?php echo $i <= $rating ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-2xl font-bold text-blue-600"><?php echo number_format($hotel['price'], 2); ?> €</span>
                    </div>
                    <a href="hotel.php?id=<?php echo $hotel['hotel_id']; ?>" 
                       class="mt-6 block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Voir les détails
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'layouts/footer.php'; ?> 