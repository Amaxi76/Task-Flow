document.addEventListener('DOMContentLoaded', () => {
	const btnAjouterStatut = document.getElementById('btn-ajouter-statut');
	const popupAjouterStatut = document.getElementById('popup-ajouter-statut');
	const btnFermerPopup = document.getElementById('btn-fermer-popup');

	// Afficher la popup
	btnAjouterStatut.addEventListener('click', () => {
		popupAjouterStatut.style.display = 'flex';
	});

	// Fermer la popup avec le bouton Annuler
	btnFermerPopup.addEventListener('click', () => {
		popupAjouterStatut.style.display = 'none';
	});

	// Fermer la popup en cliquant à l'extérieur du contenu
	popupAjouterStatut.addEventListener('click', (event) => {
		if (event.target === popupAjouterStatut) {
			popupAjouterStatut.style.display = 'none';
		}
	});
});
