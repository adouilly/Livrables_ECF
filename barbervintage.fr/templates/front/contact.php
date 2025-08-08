<?php
/**
 * Template de la section Contact
 * Section avec formulaire de contact et coordonnées
 */
?>

<!-- Section Contact -->
<section id="contact" class="contact">
    <div class="contact__container">
        <!-- Titre de la section -->
        <div class="contact__title-block">
            <h2 class="contact__title">Contact</h2>
        </div>

        <!-- Contenu organisé en deux blocs -->
        <div class="contact__content">
            <!-- Bloc gauche - Formulaire de contact -->
            <div class="contact__form-block">
                <!-- Titre du formulaire -->
                <h3 class="contact__form-title">Une question ? Contactez-moi</h3>
                
                <form class="contact__form" id="contactForm">
                    <!-- Champs Nom et Prénom sur la même ligne -->
                    <div class="contact__name-row">
                        <input 
                            type="text" 
                            name="nom" 
                            placeholder="Nom" 
                            class="contact__input contact__input--half"
                            required
                        >
                        <input 
                            type="text" 
                            name="prenom" 
                            placeholder="Prénom" 
                            class="contact__input contact__input--half"
                            required
                        >
                    </div>

                    <!-- Champ Email -->
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Votre adresse email" 
                        class="contact__input contact__input--full"
                        required
                    >

                    <!-- Champ Message -->
                    <textarea 
                        name="message" 
                        placeholder="Votre message..." 
                        class="contact__textarea"
                        rows="6"
                        required
                    ></textarea>

                    <!-- Bouton d'envoi -->
                    <button type="submit" class="contact__submit-btn">
                        Envoyer le message
                    </button>

                    <!-- Message de confirmation/erreur -->
                    <div class="contact__feedback" id="contactFeedback"></div>
                </form>
            </div>

            <!-- Bloc droite - Coordonnées -->
            <div class="contact__info-block">
                <h4 class="contact__info-title">Coordonnées</h4>
                
                <div class="contact__info-list">
                    <div class="contact__info-item">
                        <strong>Adresse :</strong><br>
                        123 Rue de la Coiffure<br>
                        75000 Paris
                    </div>

                    <div class="contact__info-item">
                        <strong>Téléphone :</strong><br>
                        01 23 45 67 89
                    </div>

                    <div class="contact__info-item">
                        <strong>Email :</strong><br>
                        contact@vintagebarber.fr
                    </div>

                    <div class="contact__info-item">
                        <strong>Horaires :</strong><br>
                        Lun - Ven : 9h00 - 19h00<br>
                        Samedi : 9h00 - 17h00<br>
                        Dimanche : Fermé
                    </div>
                </div>

                <!-- Lien Instagram -->
                <div class="contact__social">
                    <a href="https://instagram.com/vintagebarber" target="_blank" class="contact__instagram-link">
                        <svg class="contact__instagram-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        @vintagebarber
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
