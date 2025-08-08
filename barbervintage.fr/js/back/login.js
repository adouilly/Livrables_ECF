/**
 * Script pour la page de connexion - Vintage Barber Shop
 * Gère les interactions et sécurité de la page de connexion admin
 */

// ========================================
// INITIALISATION AU CHARGEMENT DU DOM
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    // Éléments du formulaire
    const loginForm = document.querySelector('.login-form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const loginButton = document.querySelector('.btn-primary');
    
    // Mise en focus du premier champ
    if (usernameInput) {
        usernameInput.focus();
    }
    
    // ========================================
    // GESTION DES ÉVÉNEMENTS
    // ========================================
    
    // Validation du formulaire
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            // Désactiver le bouton pour éviter les soumissions multiples
            if (loginButton) {
                loginButton.disabled = true;
                loginButton.innerHTML = 'Connexion en cours...';
            }
            
            // La validation sera gérée par le serveur
        });
    }
    
    // DÉSACTIVATION TEMPORAIRE DE LA DÉCONNEXION AUTO POUR LA V1
    // Sera réactivée dans la V2
    // Événements d'activité utilisateur désactivés temporairement
    /*
    setupInactivityTimeout();
    document.addEventListener('mousemove', resetInactivityTimer);
    document.addEventListener('keypress', resetInactivityTimer);
    document.addEventListener('click', resetInactivityTimer);
    document.addEventListener('scroll', resetInactivityTimer);
    */
    
    // Ajout d'une console debug pour la partie admin
    console.log("Login - Déconnexion automatique désactivée temporairement - Sera réactivée dans la V2");
    
    // ========================================
    // SÉCURITÉ - DÉCONNEXION AUTO
    // ========================================
    
    // Configure le timeout d'inactivité
    function setupInactivityTimeout() {
        // Ne s'applique pas à la page de login elle-même
        // Sera utile pour les autres pages admin après connexion
        console.log("Timeout d'inactivité désactivé sur la page de login");
    }
    
    // Réinitialise le timer d'inactivité
    function resetInactivityTimer() {
        // Ne s'applique pas à la page de login elle-même
        // Ce code sera plus pertinent dans le dashboard.php
        console.log("Reset inactivity timer désactivé");
        // Ne pas utiliser inactivityTimeout car il n'est pas défini
    }
});
