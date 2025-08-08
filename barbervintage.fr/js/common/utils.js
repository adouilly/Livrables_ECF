/**
 * Fonctions communes - Vintage Barber Shop
 * Utilitaires partagés entre front et back
 */

// ================================
// UTILITAIRES GÉNÉRAUX
// ================================
const VintageUtils = {
    // Formater une date
    formatDate: function(date) {
        return new Intl.DateTimeFormat('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(new Date(date));
    },
    
    // Valider un email
    isValidEmail: function(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },
    
    // Afficher une notification
    showNotification: function(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `notification notification--${type}`;
        notification.textContent = message;
        
        // Styles inline pour l'affichage
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            font-weight: 500;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        // Couleurs selon le type
        const colors = {
            success: '#28a745',
            error: '#dc3545',
            warning: '#ffc107',
            'bloc-infos': '#17a2b8'
        };
        notification.style.backgroundColor = colors[type] || colors.info;
        
        document.body.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Animation de sortie
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, duration);
    },
    
    // Confirmer une action
    confirmAction: function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    }
};

// ================================
// GESTION DES IMAGES
// ================================
const ImageUtils = {
    // Prévisualiser une image
    previewImage: function(input, previewElement) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewElement.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },
    
    // Valider un fichier image
    validateImageFile: function(file, maxSize = 5 * 1024 * 1024) { // 5MB par défaut
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        
        if (!allowedTypes.includes(file.type)) {
            return {
                valid: false,
                error: 'Type de fichier non autorisé. Utilisez JPG, PNG ou WebP.'
            };
        }
        
        if (file.size > maxSize) {
            return {
                valid: false,
                error: `Le fichier est trop volumineux. Taille maximum: ${maxSize / (1024 * 1024)}MB.`
            };
        }
        
        return { valid: true };
    }
};

// ================================
// GESTION DES FORMULAIRES
// ================================
const FormUtils = {
    // Valider un formulaire
    validateForm: function(formElement, rules) {
        let isValid = true;
        const errors = [];
        
        for (const fieldName in rules) {
            const field = formElement.querySelector(`[name="${fieldName}"]`);
            const rule = rules[fieldName];
            
            if (!field) continue;
            
            // Champ requis
            if (rule.required && !field.value.trim()) {
                isValid = false;
                errors.push(`${rule.label || fieldName} est requis.`);
                continue;
            }
            
            // Longueur minimum
            if (rule.minLength && field.value.length < rule.minLength) {
                isValid = false;
                errors.push(`${rule.label || fieldName} doit contenir au moins ${rule.minLength} caractères.`);
            }
            
            // Email
            if (rule.email && field.value && !VintageUtils.isValidEmail(field.value)) {
                isValid = false;
                errors.push(`${rule.label || fieldName} doit être un email valide.`);
            }
            
            // Correspondance de champs
            if (rule.match) {
                const matchField = formElement.querySelector(`[name="${rule.match}"]`);
                if (matchField && field.value !== matchField.value) {
                    isValid = false;
                    errors.push(`${rule.label || fieldName} ne correspond pas.`);
                }
            }
        }
        
        return { valid: isValid, errors };
    }
};

// Exposition globale des utilitaires
window.VintageUtils = VintageUtils;
window.ImageUtils = ImageUtils;
window.FormUtils = FormUtils;
