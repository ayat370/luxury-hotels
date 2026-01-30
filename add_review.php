<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$hotel_id = isset($_GET['hotel_id']) ? (int)$_GET['hotel_id'] : 0;
$error_message = null;
$success_message = null;

// Check if hotel exists
$stmt = $conn->prepare("SELECT * FROM hotels WHERE hotel_id = ?");
$stmt->execute([$hotel_id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hotel) {
    header("Location: hotels.php");
    exit();
}

// Handle form submission first, before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Check if user has already reviewed
        $stmt = $conn->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = ? AND hotel_id = ?");
        $stmt->execute([$_SESSION['user_id'], $hotel_id]);
        $has_reviewed = $stmt->fetchColumn() > 0;

        if ($has_reviewed) {
            $error_message = "Vous avez déjà donné votre avis sur cet hôtel.";
        } else {
            // Check for past stay
            $stmt = $conn->prepare("
                SELECT COUNT(*) 
                FROM reservations 
                WHERE user_id = ? 
                AND hotel_id = ? 
                AND status = 'confirmed' 
                AND check_out_date < CURRENT_DATE
            ");
            $stmt->execute([$_SESSION['user_id'], $hotel_id]);
            $has_past_stay = $stmt->fetchColumn() > 0;

            if (!$has_past_stay) {
                $error_message = "Vous ne pouvez laisser un avis que si vous avez séjourné dans cet hôtel.";
            } else {
                // Validate rating
                if (!isset($_POST['rating']) || !in_array($_POST['rating'], range(1, 5))) {
                    throw new Exception("Veuillez donner une note entre 1 et 5 étoiles.");
                }

                // Validate comment
                if (empty($_POST['comment']) || strlen($_POST['comment']) < 10) {
                    throw new Exception("Veuillez écrire un commentaire d'au moins 10 caractères.");
                }

                // Insert review
                $stmt = $conn->prepare("
                    INSERT INTO reviews (user_id, hotel_id, rating, comment, created_at) 
                    VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)
                ");
                $stmt->execute([
                    $_SESSION['user_id'],
                    $hotel_id,
                    $_POST['rating'],
                    $_POST['comment']
                ]);

                $_SESSION['success'] = "Votre avis a été ajouté avec succès!";
                header("Location: hotel.php?id=" . $hotel_id);
                exit();
            }
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Now we can include the header and output content
require_once 'layouts/header.php';

// Check review status for display
$stmt = $conn->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = ? AND hotel_id = ?");
$stmt->execute([$_SESSION['user_id'], $hotel_id]);
$has_reviewed = $stmt->fetchColumn() > 0;

$stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM reservations 
    WHERE user_id = ? 
    AND hotel_id = ? 
    AND status = 'confirmed' 
    AND check_out_date < CURRENT_DATE
");
$stmt->execute([$_SESSION['user_id'], $hotel_id]);
$has_past_stay = $stmt->fetchColumn() > 0;
?>

<!-- Add some padding for the fixed header -->
<div class="pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">
                    Ajouter un Avis pour <?php echo htmlspecialchars($hotel['name']); ?>
                </h2>
            </div>

            <?php if ($error_message): ?>
            <div class="p-4 bg-red-50 text-red-800">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
            <div class="p-4 bg-green-50 text-green-800">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
            <?php endif; ?>

            <?php if (!$has_reviewed && $has_past_stay): ?>
            <form method="POST" class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Note</label>
                    <div class="flex space-x-4">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="rating" 
                                   value="<?php echo $i; ?>" 
                                   required
                                   class="mr-2">
                            <?php echo $i; ?> étoile<?php echo $i > 1 ? 's' : ''; ?>
                        </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire</label>
                    <textarea name="comment" 
                              required
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                              placeholder="Partagez votre expérience..."></textarea>
                    <p class="mt-1 text-sm text-gray-500">Minimum 10 caractères</p>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="hotel.php?id=<?php echo $hotel_id; ?>" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Publier l'avis
                    </button>
                </div>
            </form>
            <?php endif; ?>

            <?php if ($has_reviewed || !$has_past_stay): ?>
            <div class="p-6 flex justify-center">
                <a href="hotel.php?id=<?php echo $hotel_id; ?>" 
                   class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Retourner à la page de l'hôtel
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?> 