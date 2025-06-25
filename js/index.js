// On sélectionne tous les éléments checkbox ayant la classe "genre-checkbox"
const genreCheckboxes = document.querySelectorAll('.genre-checkbox');

// Définir le nombre maximum de genres qu'on peut sélectionner
const maxGenresAllowed = 3;

/**
 * Fonction qui met à jour l'état des cases à cocher
 * - Active/désactive les cases en fonction du nombre sélectionné
 * - Change l'apparence des étiquettes en fonction de la sélection
 */
function mettreAJourGenres() {
  // On crée un tableau contenant uniquement les cases cochées
  const genresSelectionnes = Array.from(genreCheckboxes).filter(checkbox => checkbox.checked);

  // Pour chaque case à cocher :
  genreCheckboxes.forEach(checkbox => {
    // On récupère l'étiquette <label> parente de la checkbox (qui a la classe "tag")
    const etiquetteGenre = checkbox.closest('label.tag');

    // On applique ou retire la classe "selected" à l'étiquette si la case est cochée ou non
    etiquetteGenre.classList.toggle('selected', checkbox.checked);

    // Si on a atteint la limite et que cette case n'est pas encore cochée, on la désactive
    if (genresSelectionnes.length >= maxGenresAllowed && !checkbox.checked) {
      checkbox.disabled = true; // On empêche l'utilisateur de cocher cette case
      etiquetteGenre.classList.add('disabled'); // Ajoute une classe visuelle grisée ou bloquée
    } else {
      // Sinon, on réactive la case et on enlève le style "disabled"
      checkbox.disabled = false;
      etiquetteGenre.classList.remove('disabled');
    }
  });
}

// On ajoute un écouteur de clic à chaque checkbox (via son parent <label>)
genreCheckboxes.forEach(checkbox => {
  const etiquette = checkbox.parentElement;

  etiquette.addEventListener('click', event => {
    // Si la case est désactivée, on ne fait rien
    if (checkbox.disabled) return;

    // On inverse l'état coché de la case
    checkbox.checked = !checkbox.checked;

    // Et on met à jour l'affichage
    mettreAJourGenres();
  });
});

// On initialise l'affichage au chargement de la page
mettreAJourGenres();
console.log(genreCheckboxes.checked)
