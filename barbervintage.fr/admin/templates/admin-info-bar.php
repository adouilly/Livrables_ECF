<!-- Barre d'information admin -->
<div class="admin-info-bar">
    <div class="admin-info-contenu">
        <div class="admin-welcome">
            <span class="admin-welcome__icon">👋</span>
            <p>Bienvenue, <strong><?php echo htmlspecialchars($admin_username); ?></strong></p>
        </div>
        <div class="admin-actions">
            <a href="#" onclick="basculerFormulaireMotDePasse()" class="btn-admin btn-admin--small" id="changePasswordBtn">Changer mot de passe</a>
            <a href="logout.php" class="btn-admin btn-admin--small admin-btn--logout">Déconnexion</a>
        </div>
        
        <!-- Formulaire extensible pour changer le mot de passe -->
        <div class="password-form-container" id="passwordFormContainer" style="display: none;">
            <form method="POST" action="change-password-ajax.php" class="password-form" id="passwordForm">
                <!-- Champ username caché pour l'accessibilité -->
                <input type="text" name="username" value="<?php echo htmlspecialchars($admin_username); ?>" autocomplete="username" style="display: none;">
                
                <div class="password-form__group">
                    <label for="new_password" class="password-form__label">Nouveau mot de passe :</label>
                    <input type="password" id="new_password" name="new_password" class="password-form__input" required minlength="6" autocomplete="new-password">
                </div>
                <div class="password-form__group">
                    <label for="confirm_password" class="password-form__label">Confirmer le mot de passe :</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="password-form__input" required autocomplete="new-password">
                </div>
                <div class="password-form__actions">
                    <button type="submit" class="btn-admin btn-admin--primaire">✅ Enregistrer</button>
                    <button type="button" onclick="togglePasswordForm()" class="btn-admin btn-admin--secondaire">❌ Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
