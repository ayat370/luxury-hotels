<?php
require_once 'layouts/header.php';
?>

<!-- Hero Section -->
<div class="hero-gradient min-h-[40vh] flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Contactez-nous</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Notre équipe est à votre disposition pour répondre à toutes vos questions 
                et vous aider à planifier votre séjour parfait.
            </p>
        </div>
    </div>
</div>

<!-- Contact Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-xl shadow-sm p-8" data-aos="fade-right">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envoyez-nous un message</h2>
                <form action="process_contact.php" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                            <input type="text" name="name" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                            <input type="text" name="firstname" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="tel" name="phone" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sujet</label>
                        <select name="subject" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Sélectionnez un sujet</option>
                            <option value="reservation">Réservation</option>
                            <option value="information">Demande d'information</option>
                            <option value="complaint">Réclamation</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea name="message" rows="5" required 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        Envoyer le message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div data-aos="fade-left">
                <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informations de contact</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-100 rounded-full p-3">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Adresse</h3>
                                <p class="text-gray-600">123 Rue de Paris<br>75000 Paris, France</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-100 rounded-full p-3">
                                    <i class="fas fa-phone text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Téléphone</h3>
                                <p class="text-gray-600">+33 1 23 45 67 89</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-100 rounded-full p-3">
                                    <i class="fas fa-envelope text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-600">contact@luxuryhotels.fr</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-100 rounded-full p-3">
                                    <i class="fas fa-clock text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Horaires d'ouverture</h3>
                                <p class="text-gray-600">
                                    Lundi - Vendredi: 9h00 - 18h00<br>
                                    Samedi: 10h00 - 16h00<br>
                                    Dimanche: Fermé
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9916256937595!2d2.292292615509614!3d48.85837007928757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sTour%20Eiffel!5e0!3m2!1sfr!2sfr!4v1647874587201!5m2!1sfr!2sfr" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Questions Fréquentes</h2>
            <p class="text-xl text-gray-600">Trouvez rapidement les réponses à vos questions</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-sm p-8" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Comment puis-je modifier ma réservation ?
                </h3>
                <p class="text-gray-600">
                    Vous pouvez modifier votre réservation en vous connectant à votre compte 
                    ou en contactant directement notre service client. Les modifications sont 
                    possibles jusqu'à 48h avant votre arrivée.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-8" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Quels sont les moyens de paiement acceptés ?
                </h3>
                <p class="text-gray-600">
                    Nous acceptons les principales cartes de crédit (Visa, Mastercard, American Express), 
                    les virements bancaires et les paiements en espèces sur place.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-8" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    À quelle heure puis-je faire le check-in/check-out ?
                </h3>
                <p class="text-gray-600">
                    Le check-in est disponible à partir de 15h00 et le check-out doit être 
                    effectué avant 11h00. Un check-in anticipé ou un check-out tardif peut 
                    être arrangé sur demande.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-8" data-aos="fade-up" data-aos-delay="400">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Les animaux sont-ils acceptés ?
                </h3>
                <p class="text-gray-600">
                    Les petits animaux de compagnie sont acceptés dans certains de nos hôtels. 
                    Veuillez nous contacter à l'avance pour connaître les conditions et les 
                    suppléments éventuels.
                </p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'layouts/footer.php'; ?> 