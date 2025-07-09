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


//CHOIX DES GENRES POUR LA CREATION D'UNE FICHE DE FILM
const checkboxes = document.querySelectorAll('.genre-checkbox');
const maxGenres = 3; //Fixe ne nombre max de genre séléctionnable à 3

function updateCheckbox() { //Changement de la couleur et de l'état des checkboxes
  const selected = Array.from(checkboxes).filter(box => box.checked); //On met la liste des checkboxes dans un tableau et on filtre pour garder les checkboxes cochée

  checkboxes.forEach(box => { //On parcourt chaque checkbox
    const label = box.closest('label.tag'); //On séléctionne le label parents de tag afin de séléctionner avec le nom (pas uniquement la case à cocher)
    label.classList.toggle('selected', box.checked); //toggle permet d'ajouter ou retirer suivant l'état actuelle la class "selected"

    const tooManySelected = selected.length >= maxGenres && !box.checked; //On fixe la limite 
    box.disabled = tooManySelected; //Ne permet pas au user de cliquer sur la case car dékà trop de séléctionnée
    label.classList.toggle('disabled', tooManySelected); //toggle permet d'ajouter ou retirer suivant l'état actuelle la class "disable"
  });
}

//On recommence pour toute les cases cochée
checkboxes.forEach(box => {
  const label = box.parentElement;

  label.addEventListener('click', () => {
    if (box.disabled) return;
    box.checked = !box.checked;
    updateCheckbox();
  });
});

// Ce lance au chargement
updateCheckbox(); 



