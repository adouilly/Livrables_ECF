# Charte Graphique - Vintage Barber Shop

## 1. Couleurs principales

| Nom           | Variable CSS         | Code HEX     | Usage                       |
|---------------|---------------------|--------------|-----------------------------|
| Jaune vintage | --color-primary     | #D4A574      | Titres, boutons, accents    |
| Bleu rétro    | --color-secondary   | #6B9BD8      | Fond gallery, contours      |
| Noir profond  | --color-black       | #1a1a1a      | Fond général, textes        |
| Blanc         | --color-white       | #fff         | Fonds, contrastes           |
| Gris admin    | --color-admin-bg    | #f5f5f5      | Fond back-office            |
| Vert succès   | --color-success     | #28a745      | Messages success            |
| Rouge erreur  | --color-error       | #dc3545      | Messages erreur             |
| Jaune warning | --color-warning     | #ffc107      | Messages warning            |

**Exemple CSS :**
```css
:root {
    --color-primary: #D4A574;
    --color-secondary: #6B9BD8;
    --color-black: #1a1a1a;
    --color-white: #fff;
    --color-admin-bg: #f5f5f5;
    --color-success: #28a745;
    --color-error: #dc3545;
    --color-warning: #ffc107;
}
```

## 2. Typographies

| Usage         | Police principale         | Police secondaire      |
|---------------|--------------------------|-----------------------|
| Titres        | 'Playfair Display', serif | 'Grenze Gotisch', cursive |
| Textes        | 'Lato', sans-serif        | 'Roboto', sans-serif  |
| Footer        | 'Yatra One', cursive      |                       |

**Exemple CSS :**
```css
body {
    font-family: 'Lato', Arial, sans-serif;
}
h1, h2, h3 {
    font-family: 'Playfair Display', serif;
}
.dashboard-title-standalone {
    font-family: 'Grenze Gotisch', cursive;
}
.footer {
    font-family: 'Yatra One', cursive;
}
```

## 3. Iconographie

- Logo circulaire : `assets/img/logo.png`
- Tondeuse animée : `assets/img/tondeuse.png`
- Favicon : `assets/favicon/favicon.png`
- Images galerie : `assets/gallery/`
- Images hero : `assets/hero/`

## 4. Règles graphiques

- Design mobile-first, breakpoints à 360px, 768px, 1200px+
- Header rétractable, navigation burger animée
- Flip box interactif pour les prestations
- Galerie rétro avec fond jaune et contours bleus
- Boutons arrondis, ombres légères, transitions douces
- Utilisation de border-radius uniquement sur certains coins pour effet vintage
- Animations CSS pour transitions, fade, flip, tondeuse

## 5. Exemples d’utilisation

**Bouton principal :**
```css
.btn-primary {
    background-color: var(--color-primary);
    color: var(--color-black);
    border-radius: 25px;
    padding: 12px 28px;
    font-family: 'Playfair Display', serif;
    font-weight: bold;
    transition: background 0.3s;
}
.btn-primary:hover {
    background-color: var(--color-secondary);
    color: var(--color-white);
}
```

**Bloc gallery :**
```css
.gallery__container {
    background-color: var(--color-primary);
    border-radius: var(--border-radius-top-right);
    box-shadow: var(--box-shadow-normal);
}
```

## 6. Accessibilité

- Contrastes respectés (WCAG AA)
- Textes alternatifs sur toutes les images
- Navigation clavier et ARIA sur les éléments interactifs
- Responsive hints pour mobile et desktop

---

Cette charte graphique garantit la cohérence visuelle et l’accessibilité du site Vintage Barber Shop.
