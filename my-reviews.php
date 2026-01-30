<?php
require_once 'layouts/header.php';
require_once 'config/database.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all user's reviews
$user_id = $_SESSION['user_id'];
$sql = "SELECT r.*, h.name as hotel_name, h.image_url, c.name as category_name
        FROM reviews r 
        JOIN hotels h ON r.hotel_id = h.hotel_id 
        LEFT JOIN categories c ON h.category_id = c.category_id
        WHERE r.user_id = ? 
        ORDER BY r.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-[40vh] flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Mes Avis</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Retrouvez tous vos avis et commentaires sur nos hôtels
            </p>
        </div>
    </div>
</div>

<!-- Reviews List -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (empty($reviews)): ?>
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-comment-slash text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Aucun avis</h2>
            <p class="text-gray-600 mb-8">Vous n'avez pas encore donné votre avis sur nos hôtels</p>
            <a href="hotels.php" 
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Découvrir nos hôtels
            </a>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($reviews as $review): ?>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-up">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img class="h-16 w-16 rounded-lg object-cover" 
                             src="<?php echo htmlspecialchars($review['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($review['hotel_name']); ?>">
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-gray-900">
                                <?php echo htmlspecialchars($review['hotel_name']); ?>
                            </h3>
                            <p class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($review['category_name']); ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center mb-4">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                        <?php endfor; ?>
                        <span class="ml-2 text-sm text-gray-500">
                            <?php echo date('d/m/Y', strtotime($review['created_at'])); ?>
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4">
                        <?php echo htmlspecialchars($review['comment']); ?>
                    </p>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="edit_review.php?id=<?php echo $review['review_id']; ?>" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </a>
                        <button onclick="deleteReview(<?php echo $review['review_id']; ?>)" 
                                class="inline-flex items-center px-4 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 hover:bg-red-50">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
function deleteReview(reviewId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')) {
        window.location.href = `delete_review.php?id=${reviewId}`;
    }
}
</script>

<?php require_once 'layouts/footer.php'; ?> 