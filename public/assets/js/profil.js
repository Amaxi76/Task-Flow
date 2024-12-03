document.addEventListener('DOMContentLoaded', () => {
	const btnAjouterStatut   = document.getElementById('btn-ajouter-statut');
	const popupAjouterStatut = document.getElementById('popup-ajouter-statut');
	const btnFermerPopup     = document.getElementById('btn-fermer-popup');
	const colorPickers       = document.querySelectorAll('input[type="color"]');

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

	const CONTRASTE_MINIMUM = 3;

	colorPickers.forEach((colorPicker) => {
        colorPicker.addEventListener('change', (event) => {
            const newColor = event.target.value;
            const contrast = calculateContrast(newColor);

            if (contrast < CONTRASTE_MINIMUM) {
                console.error(
                    `La couleur sélectionnée (${newColor}) a un contraste insuffisant (${contrast.toFixed(2)}) avec le blanc. Veuillez choisir une couleur plus contrastée.`
                );
                // Optionnel : afficher un message d'erreur dans l'UI
                alert(`Attention, la couleur que vous avez selectionné est très proche du blanc, vous risquez de ne pas fare la distinction entre les 2 couleurs`);
            } else {
                console.log(`Nouvelle couleur validée : ${newColor} avec un contraste de ${contrast.toFixed(2)}.`);
            }
        });
    });


});

const calculateLuminance = (color) => {
	const rgb = color.match(/\w\w/g).map((c) => parseInt(c, 16) / 255);
	const adjusted = rgb.map((c) => (c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4)));
	return 0.2126 * adjusted[0] + 0.7152 * adjusted[1] + 0.0722 * adjusted[2];
};

// Fonction pour calculer le ratio de contraste
const calculateContrast = (color1, color2 = "#ffffff") => {
	const lum1 = calculateLuminance(color1);
	const lum2 = calculateLuminance(color2);
	const brightest = Math.max(lum1, lum2);
	const darkest = Math.min(lum1, lum2);
	return (brightest + 0.05) / (darkest + 0.05);
};

function afficherCookiePopUp() {
	document.getElementById('cookie-popup').style.display = 'block';
}

function fermerCookiePopUp() {
	document.getElementById('cookie-popup').style.display = 'none';
}