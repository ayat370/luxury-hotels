<?php
session_start();
require_once 'config/database.php';
require_once 'layouts/header.php';
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-screen flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-up">
            <div class="p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Créer un compte</h2>
                    <p class="text-gray-600 mt-2">Rejoignez Luxury Hotels</p>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6">
                    <?php 
                    echo htmlspecialchars($_SESSION['error']);
                    unset($_SESSION['error']);
                    ?>
                </div>
                <?php endif; ?>

                <form action="process_register.php" method="POST">
                                        <div class="mb-6">                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom d'utilisateur</label>                        <input type="text"                                name="username"                                required                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"                               placeholder="jeandupont">                    </div>                    <div class="grid grid-cols-2 gap-4 mb-6">                        <div>                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>                            <input type="text"                                    name="lastname"                                    required                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"                                   placeholder="Dupont">                        </div>                        <div>                            <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>                            <input type="text"                                    name="firstname"                                    required                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"                                   placeholder="Jean">                        </div>                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="votre@email.com">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="tel" 
                               name="phone" 
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="+33 6 12 34 56 78">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <input type="password" 
                               name="password" 
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="••••••••">
                        <p class="mt-1 text-sm text-gray-500">
                            Minimum 8 caractères, incluant majuscules, minuscules et chiffres
                        </p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                        <input type="password" 
                               name="confirm_password" 
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="••••••••">
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="terms" 
                                   required 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">
                                J'accepte les <a href="#" class="text-blue-600 hover:text-blue-700">conditions d'utilisation</a> 
                                et la <a href="#" class="text-blue-600 hover:text-blue-700">politique de confidentialité</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        Créer mon compte
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Déjà un compte ? 
                        <a href="login.php" class="text-blue-600 hover:text-blue-700 font-medium">
                            Se connecter
                        </a>
                    </p>
                </div>

                <div class="mt-8 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Ou s'inscrire avec</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fab fa-google text-red-600 mr-2"></i>
                        Google
                    </button>
                    <button class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>
                        Facebook
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?> 