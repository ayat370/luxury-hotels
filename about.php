<?php
require_once 'layouts/header.php';
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-[60vh] flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">À Propos de Nous</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Découvrez l'histoire de Luxury Hotels, notre engagement envers l'excellence 
                et notre passion pour l'hospitalité de luxe.
            </p>
        </div>
    </div>
</div>

<!-- Our Story Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Notre Histoire</h2>
                <p class="text-gray-600 mb-6">
                    Fondé en 2010, Luxury Hotels est né de la vision de créer des expériences 
                    hôtelières exceptionnelles qui dépassent les attentes de nos clients les plus exigeants.
                </p>
                <p class="text-gray-600 mb-6">
                    Au fil des années, nous avons développé un portfolio d'établissements prestigieux, 
                    chacun incarnant notre engagement envers l'excellence et le service personnalisé.
                </p>
                <div class="grid grid-cols-3 gap-6 text-center">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600 mb-2">14</div>
                        <div class="text-gray-600">Hôtels</div>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600 mb-2">1200+</div>
                        <div class="text-gray-600">Chambres</div>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600 mb-2">50K+</div>
                        <div class="text-gray-600">Clients</div>
                    </div>
                </div>
            </div>
            <div class="relative" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                     alt="Hotel Luxury" 
                     class="rounded-lg shadow-2xl">
                <div class="absolute -bottom-6 -right-6 bg-white p-8 rounded-lg shadow-xl">
                    <div class="text-4xl font-bold text-blue-600 mb-2">13</div>
                    <div class="text-gray-600">Années d'Excellence</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos Valeurs</h2>
            <p class="text-xl text-gray-600">Les principes qui guident chacune de nos actions</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="100">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-star text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Excellence</h3>
                <p class="text-gray-600">
                    Nous nous efforçons d'offrir un service impeccable et une attention aux 
                    détails dans chaque aspect de votre séjour.
                </p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="200">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-heart text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Passion</h3>
                <p class="text-gray-600">
                    Notre passion pour l'hospitalité se reflète dans chaque interaction 
                    et chaque moment de votre expérience.
                </p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="300">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-handshake text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Engagement</h3>
                <p class="text-gray-600">
                    Nous nous engageons à créer des moments mémorables et des expériences 
                    uniques pour chaque client.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Notre Équipe de Direction</h2>
            <p class="text-xl text-gray-600">Des professionnels passionnés à votre service</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="relative mb-4 inline-block">
                    <img src="IM1.png" alt="IM" class="w-48 h-48 rounded-full">
                    <div class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full">
                        <i class="fab fa-linkedin"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Sophie Martin</h3>
                <p class="text-gray-600">PDG</p>
            </div>
            
            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="relative mb-4 inline-block">
                    <img src="IM2.png" alt="Operations Director" class="w-48 h-48 rounded-full">
                    <div class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full">
                        <i class="fab fa-linkedin"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Thomas Dubois</h3>
                <p class="text-gray-600">Directeur des Opérations</p>
            </div>
            
            <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="relative mb-4 inline-block">
                    <img src="IM3.png" alt="Marketing Director" class="w-48 h-48 rounded-full">
                    <div class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full">
                        <i class="fab fa-linkedin"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Marie Laurent</h3>
                <p class="text-gray-600">Directrice Marketing</p>
            </div>
            
            <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                <div class="relative mb-4 inline-block">
                    <img src="IM4.png" alt="Customer Service Director" class="w-48 h-48 rounded-full">
                    <div class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full">
                        <i class="fab fa-linkedin"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Pierre Moreau</h3>
                <p class="text-gray-600">Directeur Service Client</p>
            </div>
        </div>
    </div>
</section>

<!-- Awards Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos Récompenses</h2>
            <p class="text-xl text-gray-600">La reconnaissance de notre excellence</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-sm text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="text-yellow-400 mb-4">
                    <i class="fas fa-trophy text-5xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Meilleur Groupe Hôtelier</h3>
                <p class="text-gray-600">World Travel Awards 2023</p>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="text-yellow-400 mb-4">
                    <i class="fas fa-medal text-5xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Excellence du Service</h3>
                <p class="text-gray-600">Hospitality Awards 2023</p>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="text-yellow-400 mb-4">
                    <i class="fas fa-star text-5xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">5 Étoiles Diamond</h3>
                <p class="text-gray-600">AAA Rating 2023</p>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm text-center" data-aos="fade-up" data-aos-delay="400">
                <div class="text-yellow-400 mb-4">
                    <i class="fas fa-award text-5xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Luxury Lifestyle Awards</h3>
                <p class="text-gray-600">Best Luxury Hotels 2023</p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'layouts/footer.php'; ?> 