<?php
require_once 'layouts/header.php';
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-[60vh] flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Nos Services</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Découvrez notre gamme complète de services luxueux conçus pour rendre 
                votre séjour exceptionnel.
            </p>
        </div>
    </div>
</div>

<!-- Main Services Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Accommodation -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3" 
                     alt="Luxury Room" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-bed text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Hébergement de Luxe</h3>
                    <p class="text-gray-600 mb-4">
                        Des chambres et suites somptueuses avec une vue imprenable et 
                        des équipements haut de gamme pour votre confort absolu.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Literie premium</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Service en chambre 24/7</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Mini-bar garni</li>
                    </ul>
                </div>
            </div>

            <!-- Dining -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3" 
                     alt="Fine Dining" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-utensils text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Restauration Gastronomique</h3>
                    <p class="text-gray-600 mb-4">
                        Une expérience culinaire exceptionnelle avec nos chefs étoilés 
                        et notre sélection de vins raffinés.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Restaurants étoilés</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Cave à vins exclusive</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Menus personnalisés</li>
                    </ul>
                </div>
            </div>

            <!-- Wellness -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                <img src="https://www.arthurs-h.be/wp-content/uploads/2023/05/2023_04_12_OBulles_018_websize.jpg" 
                     alt="Spa & Wellness" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-spa text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Spa & Bien-être</h3>
                    <p class="text-gray-600 mb-4">
                        Un havre de paix pour votre bien-être avec des soins spa 
                        exclusifs et des installations de détente.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Massages signature</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Piscine intérieure</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Salle de fitness</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Services -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Services Complémentaires</h2>
            <p class="text-xl text-gray-600">Pour rendre votre séjour encore plus mémorable</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Concierge -->
            <div class="bg-white p-6 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="100">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-concierge-bell text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Conciergerie</h3>
                <p class="text-gray-600">Service personnalisé 24/7 pour répondre à toutes vos demandes</p>
            </div>

            <!-- Transport -->
            <div class="bg-white p-6 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="200">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-car text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Transport</h3>
                <p class="text-gray-600">Service de limousine et transferts aéroport privés</p>
            </div>

            <!-- Events -->
            <div class="bg-white p-6 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="300">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-glass-cheers text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Événements</h3>
                <p class="text-gray-600">Organisation d'événements sur mesure</p>
            </div>

            <!-- Business -->
            <div class="bg-white p-6 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="400">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-briefcase text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Business Center</h3>
                <p class="text-gray-600">Espaces de travail équipés et salles de réunion</p>
            </div>
        </div>
    </div>
</section>

<!-- Exclusive Experiences -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Expériences Exclusives</h2>
            <p class="text-xl text-gray-600">Des moments uniques créés spécialement pour vous</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Private Tours -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-right">
                <div class="md:flex">
                    <div class="md:flex-shrink-0">
                        <img class="h-48 w-full md:w-48 object-cover" 
                             src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?ixlib=rb-4.0.3" 
                             alt="Private Tours">
                    </div>
                    <div class="p-8">
                        <div class="text-blue-600 mb-2">
                            <i class="fas fa-map-marked-alt text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Visites Privées</h3>
                        <p class="text-gray-600">
                            Découvrez la région avec nos guides experts lors de visites 
                            personnalisées et exclusives.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Culinary Experiences -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" data-aos="fade-left">
                <div class="md:flex">
                    <div class="md:flex-shrink-0">
                        <img class="h-48 w-full md:w-48 object-cover" 
                             src="https://images.unsplash.com/photo-1507048331197-7d4ac70811cf?ixlib=rb-4.0.3" 
                             alt="Culinary Experience">
                    </div>
                    <div class="p-8">
                        <div class="text-blue-600 mb-2">
                            <i class="fas fa-utensils text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Expériences Culinaires</h3>
                        <p class="text-gray-600">
                            Cours de cuisine privés avec nos chefs et dégustations 
                            exclusives dans notre cave.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Request -->
<section class="py-20 bg-blue-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-white mb-4">Un Service Particulier ?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Notre équipe est à votre disposition pour répondre à toutes vos demandes spéciales
            </p>
            <a href="contact.php" 
               class="inline-block bg-white text-blue-600 px-8 py-3 rounded-full text-lg font-medium hover:bg-blue-50 transition-colors">
                Contactez-nous
            </a>
        </div>
    </div>
</section>

<?php require_once 'layouts/footer.php'; ?> 