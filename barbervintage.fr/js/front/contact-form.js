/**
 * JavaScript pour la section Contact
 * Gestion du formulaire de contact avec système mailto
 * Vintage Barber Shop
 */

class ContactForm {
    constructor() {
        this.form = document.getElementById('contactForm');
        this.feedback = document.getElementById('contactFeedback');
        this.adminEmail = 'contact@vintagebarber.fr'; // Email de l'admin
        
        this.initializeForm();
    }

    initializeForm() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        }
    }

    handleSubmit(e) {
        e.preventDefault();
        
        // Récupération des données du formulaire
        const formData = new FormData(this.form);
        const data = {
            nom: formData.get('nom'),
            prenom: formData.get('prenom'),
            email: formData.get('email'),
            message: formData.get('message')
        };

        // Validation des champs
        if (!this.validateForm(data)) {
            return;
        }

        // Création du lien mailto
        this.createMailtoLink(data);
    }

    validateForm(data) {
        // Vérification que tous les champs sont remplis
        if (!data.nom || !data.prenom || !data.email || !data.message) {
            this.showFeedback('Veuillez remplir tous les champs', 'error');
            return false;
        }

        // Validation basique de l'email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(data.email)) {
            this.showFeedback('Veuillez entrer une adresse email valide', 'error');
            return false;
        }

        return true;
    }

    createMailtoLink(data) {
        // Construction du sujet et du corps du message
        const subject = encodeURIComponent(`Nouveau message de ${data.prenom} ${data.nom}`);
        const body = encodeURIComponent(
            `Bonjour,\n\n` +
            `Vous avez reçu un nouveau message depuis le site web :\n\n` +
            `Nom : ${data.nom}\n` +
            `Prénom : ${data.prenom}\n` +
            `Email : ${data.email}\n\n` +
            `Message :\n${data.message}\n\n` +
            `---\n` +
            `Ce message a été envoyé depuis le formulaire de contact du site Vintage Barber Shop.`
        );

        // Création du lien mailto
        const mailtoLink = `mailto:${this.adminEmail}?subject=${subject}&body=${body}`;

        try {
            // Tentative d'ouverture du client email
            window.location.href = mailtoLink;
            
            // Affichage du message de succès
            this.showFeedback(
                'Votre client email va s\'ouvrir avec le message prêt à envoyer !', 
                'success'
            );
            
            // Réinitialisation du formulaire
            setTimeout(() => {
                this.resetForm();
            }, 2000);

        } catch (error) {
            console.error('Erreur lors de l\'ouverture du client email:', error);
            this.showFeedback(
                'Erreur lors de l\'ouverture du client email. Veuillez réessayer.', 
                'error'
            );
        }
    }

    showFeedback(message, type) {
        if (!this.feedback) return;

        // Suppression des classes précédentes
        this.feedback.classList.remove('success', 'error');
        
        // Ajout de la nouvelle classe et du message
        this.feedback.classList.add(type);
        this.feedback.textContent = message;

        // Masquage automatique après 5 secondes
        setTimeout(() => {
            this.feedback.style.opacity = '0';
            setTimeout(() => {
                this.feedback.classList.remove('success', 'error');
                this.feedback.textContent = '';
            }, 300);
        }, 5000);

    }

    resetForm() {
        if (this.form) {
            this.form.reset();
            
            // Réinitialisation du feedback après un délai
            setTimeout(() => {
                if (this.feedback) {
                    this.feedback.style.opacity = '0';
                    setTimeout(() => {
                        this.feedback.classList.remove('success', 'error');
                        this.feedback.textContent = '';
                    }, 300);
                }
            }, 3000);
        }
    }
}

// Initialisation du formulaire de contact quand le DOM est chargé
document.addEventListener('DOMContentLoaded', () => {
    new ContactForm();
});

// Debug info
