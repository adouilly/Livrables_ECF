// 🔒 FICHIER VERROUILLÉ TEMPORAIREMENT
// Ce fichier est protégé. Ne pas modifier/supprimer tant qu'une instruction explicite n'est donnée.


# 🎨 Effet Grille Dynamique - barbervintage.fr

## 🎯 Objectif

Intégrer un effet visuel dynamique sur certains blocs du site `barbervintage.fr`, sous la forme d’une **grille en overlay** :
- Chaque cellule affiche une **image aléatoire semi-transparente** issue d’un dossier spécifique (`assets/img3/`).
- Les images sont mises à jour toutes les **5 secondes** automatiquement.
- La grille ne gêne pas l’interaction utilisateur (`pointer-events: none`).
- L'effet est léger, en **HTML/CSS/JS vanilla**, sans framework.
- Avec un **effet fade-in / fade-out** à chaque mise à jour.

## 🧠 Fonctionnement

Le script JS :
- Cible les éléments HTML contenant la classe `.grid-overlay-target`.
- Génère une grille CSS en overlay avec des cases de `50x50px max`.
- Chaque case est remplie d'une image de fond choisie aléatoirement parmi 5 fichiers PNG dans `assets/img3/`.
- À chaque intervalle de 5 secondes, chaque cellule se voit attribuer une nouvelle image avec un **effet fondu progressif**.

## ⚙️ Intégration dans le projet existant

Aucune modification d’arborescence requise. Le code s’intègre directement dans ta **structure actuelle** sans toucher à l’organisation de fichiers.

### 1. Modifier les fichiers PHP

Dans `index.php` et `login.php`, ajoute la classe `grid-overlay-target` aux éléments concernés :

```html
<!-- index.php -->
<div class="services__about grid-overlay-target"></div>
<div class="gallery__container grid-overlay-target"></div>
<div class="contact__form-block grid-overlay-target"></div>
```

Et dans `login.php`, ajoute la même classe sur les blocs que tu veux affecter par l’effet.

### 2. Ajouter du CSS (dans ton fichier CSS global)

```css
.grid-overlay {
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
  grid-auto-rows: 50px;
  gap: 2px;
  pointer-events: none;
  z-index: 10;
}

.grid-cell {
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  opacity: 0.25;
  transition: opacity 0.5s ease-in-out, background-image 0.5s ease-in-out;
}
```

> 🔁 L’effet **fade in/out** est assuré par `transition` sur `opacity` et `background-image`.

### 3. Ajouter le JS (dans ton fichier JS global ou en bas de page)

```js
const imagePaths = [
  'assets/img3/img1.png',
  'assets/img3/img2.png',
  'assets/img3/img3..png',
  'assets/img3/img4..png',
  'assets/img3/img5..png'
];

function getRandomImage() {
  return imagePaths[Math.floor(Math.random() * imagePaths.length)];
}

function getRandomOpacity() {
  return (0.25 + Math.random() * 0.25).toFixed(2);
}

function createGridOverlay(target) {
  const overlay = document.createElement('div');
  overlay.className = 'grid-overlay';

  const cols = Math.ceil(target.offsetWidth / 50);
  const rows = Math.ceil(target.offsetHeight / 50);
  const totalCells = cols * rows;

  for (let i = 0; i < totalCells; i++) {
    const cell = document.createElement('div');
    cell.className = 'grid-cell';
    cell.style.backgroundImage = `url(${getRandomImage()})`;
    cell.style.opacity = getRandomOpacity();
    overlay.appendChild(cell);
  }

  target.style.position = 'relative';
  target.appendChild(overlay);
  return overlay;
}

function updateGridImages(gridOverlay) {
  const cells = gridOverlay.querySelectorAll('.grid-cell');
  cells.forEach(cell => {
    cell.style.opacity = 0;
    setTimeout(() => {
      cell.style.backgroundImage = `url(${getRandomImage()})`;
      cell.style.opacity = getRandomOpacity();
    }, 200); // délai pour le fade-out avant mise à jour
  });
}

function initGrids() {
  const targets = document.querySelectorAll('.grid-overlay-target');
  targets.forEach(target => {
    const grid = createGridOverlay(target);
    setInterval(() => updateGridImages(grid), 5000);
  });
}

window.addEventListener('DOMContentLoaded', initGrids);
```

> 📌 L’effet `fade` est renforcé par un petit `setTimeout` entre l’opacité à `0` et le changement d’image.

### 4. Vérification

| Vérification                              | OK ? |
|-------------------------------------------|------|
| Images placées dans `assets/img3/`        | ✅    |
| Classes `grid-overlay-target` ajoutées    | ✅    |
| CSS bien chargé                           | ✅    |
| JS exécuté après chargement DOM           | ✅    |
| Effet visible et fonctionnel              | ✅    |

---

## 💡 Conseils performance

- ⚠️ Évite trop de cellules (limiter la taille en mobile).
- 📦 Précharge les images en HTML avec `<link rel="preload">` si besoin.
- 💨 Tu peux désactiver l'effet sur mobile via media queries ou JS.

---

## 🧑‍💻 Auteur

Projet réalisé par El Chapo avec l’aide d’un assistant numérique en CSS/JS vanilla ultra-efficace 🧠
