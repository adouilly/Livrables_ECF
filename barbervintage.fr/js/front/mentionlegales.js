// JS dédié pour la popup Mentions Légales

document.addEventListener('DOMContentLoaded', function() {
  var legalLink = document.getElementById('legal-link');
  var modal = document.getElementById('legalModal');
  var closeBtn = document.getElementById('closeLegalModal');
  var backdrop = modal ? modal.querySelector('.legal-modal__backdrop') : null;
  if (legalLink && modal && closeBtn && backdrop) {
    legalLink.addEventListener('click', function(e) {
      e.preventDefault();
      modal.style.display = 'flex';
    });
    closeBtn.addEventListener('click', function() {
      modal.style.display = 'none';
    });
    backdrop.addEventListener('click', function() {
      modal.style.display = 'none';
    });
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') modal.style.display = 'none';
    });
  }
});
