<?php
/* ========================================
   SECTION SERVICES - VINTAGE BARBER SHOP
   ======================================== */
?>

<!-- ========================================
     SECTION SERVICES
     ======================================== -->
<section class="services" id="services">
    
    <!-- Titre principal centré avec background noir -->
    <div class="services__title-container">
        <h2 class="services__title">Nos Services</h2>
    </div>
    
    <!-- Conteneur principal avec 2 blocs -->
    <div class="services__container">
        
        <!-- ========================================
             BLOC GAUCHE - À PROPOS DU BARBIER
             ======================================== -->
        <div class="services__about">
            <h3 class="services__about-title">Le Maître Barbier</h3>
            <p class="services__about-text">
                Depuis plus de 20 ans, notre maître barbier perpétue l'art traditionnel du rasage et de la coupe masculine.<br> 
                Formé dans les plus prestigieux salons européens, il maîtrise les techniques ancestrales tout en intégrant 
                les tendances contemporaines.<br>  Chaque prestation est un moment unique, alliant savoir-faire artisanal et 
                produits de qualité premium.<br>  L'excellence du service et le respect des traditions font de chaque visite 
                une expérience authentique dans l'univers du barbier vintage.<br>  Un véritable artisan au service de votre élégance.
            </p>
        </div>
        
        <!-- ========================================
             BLOC DROITE - PRESTATIONS
             ======================================== -->
        <div class="services__prestations">
            <h3 class="services__prestations-title">Prestations</h3>
            
            <!-- Flip Box avec tableaux des prestations -->
            <div class="services__flip-container">
                <div class="services__flip-card">
                    
                    <!-- Face A : Prestations Coiffure -->
                    <div class="services__flip-front">
                        <h4 class="services__table-title">Coiffure</h4>
                        <table class="services__table">
                            <thead>
                                <tr>
                                    <th>Prestation</th>
                                    <th>Tarif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Coupe Classique</td>
                                    <td>25€</td>
                                </tr>
                                <tr>
                                    <td>Coupe + Shampooing</td>
                                    <td>30€</td>
                                </tr>
                                <tr>
                                    <td>Coupe Vintage Style</td>
                                    <td>35€</td>
                                </tr>
                                <tr>
                                    <td>Coupe + Styling</td>
                                    <td>40€</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Face B : Prestations Barbe -->
                    <div class="services__flip-back">
                        <h4 class="services__table-title">Barbe & Prestations</h4>
                        <table class="services__table">
                            <thead>
                                <tr>
                                    <th>Prestation</th>
                                    <th>Tarif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Taille de Barbe</td>
                                    <td>20€</td>
                                </tr>
                                <tr>
                                    <td>Rasage Traditionnel</td>
                                    <td>25€</td>
                                </tr>
                                <tr>
                                    <td>Complet (Coupe + Barbe)</td>
                                    <td>45€</td>
                                </tr>
                                <tr>
                                    <td>Prestation Événement</td>
                                    <td>65€</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            
            <!-- Indication pour l'utilisateur -->
            <p style="font-family: var(--font-text); font-size: 0.9rem; color: var(--color-black-50); margin-top: 20px; text-align: center; font-style: italic;">
                💡 <span class="desktop-hint">Survolez</span><span class="mobile-hint" style="display: none;">Tapez sur</span> le tableau pour découvrir<br> nos autres prestations
            </p>
            
        </div>
        
    </div>
    
</section>
