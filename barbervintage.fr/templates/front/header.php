<!-- ========================================
     HEADER FRONT - VINTAGE BARBER SHOP
     ======================================== -->
<header class="header" id="header">
    <div class="header__container">
        
        <!-- Partie 1 : Logo (Gauche) -->
        <div class="header__logo-section">
            <a href="index.php" class="header__logo-link" title="Retour à l'accueil">
                <img src="assets/img/logo.png" 
                     alt="Vintage Barber Shop Logo" 
                     class="header__logo-img">
            </a>
        </div>

        <!-- Partie 2 : Titre du Site (Centre) -->
        <div class="header__title-section">
            <h1 class="header__site-title">
                <?= $site_title ?? 'VINTAGE BARBER SHOP' ?>
            </h1>
            <span class="header__site-subtitle">Le style sur le fil du rasoir</span>
        </div>

        <!-- Partie 3 : Navigation (Droite) -->
        <div class="header__nav-section">
            
            <!-- Version Initiale : Menu Burger -->
            <div class="header__burger-container" id="burger-container">
                <button class="header__burger-btn" 
                        id="burger-btn" 
                        aria-label="Ouvrir le menu" 
                        aria-expanded="false">
                    <img src="assets/img/menu.png" 
                         alt="Menu" 
                         class="header__burger-img">
                </button>
            </div>

            <!-- Version Après Animation : Navigation Visible -->
            <nav class="header__nav" id="main-nav" aria-hidden="true">
                <ul class="header__nav-list">
                    <li class="header__nav-item">
                        <a href="#services" 
                           class="header__nav-link header__nav-link--services" 
                           data-scroll="services">
                            Services
                        </a>
                    </li>
                    <li class="header__nav-item">
                        <a href="#gallery" 
                           class="header__nav-link header__nav-link--gallery" 
                           data-scroll="gallery">
                            Galerie
                        </a>
                    </li>
                    <li class="header__nav-item">
                        <a href="#contact" 
                           class="header__nav-link header__nav-link--contact" 
                           data-scroll="contact">
                            Contact
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>