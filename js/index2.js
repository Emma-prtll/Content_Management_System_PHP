
//MESSAGE DE CONFIRMATION
//JAVASCRIPT DE BULMA POUR GERER LE BOUTON "DELETE"
document.addEventListener('DOMContentLoaded', () => {
  (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
    const $notification = $delete.parentNode;

    $delete.addEventListener('click', () => {
      $notification.parentNode.removeChild($notification);
    });
  });
});


// CHOIX DES GENRES POUR LA CREATION D'UNE FICHE DE FILM
const checkboxes = document.querySelectorAll('.genre-checkbox');
const maxGenres = 3;


function updateCheckboxState() {
  const selected = Array.from(checkboxes).filter(box => box.checked);

  checkboxes.forEach(box => {
    const label = box.closest('label.tag');
    label.classList.toggle('selected', box.checked);

    const tooManySelected = selected.length >= maxGenres && !box.checked;
    box.disabled = tooManySelected;
    label.classList.toggle('disabled', tooManySelected);
  });
}

checkboxes.forEach(box => {
  const label = box.parentElement;

  label.addEventListener('click', () => {
    if (box.disabled) return;
    box.checked = !box.checked;
    updateCheckboxState();
  });
});

updateCheckboxState(); // Au chargement



