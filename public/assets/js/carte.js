document.addEventListener('DOMContentLoaded', function() {
	const cartes = document.querySelectorAll('.carte');

	cartes.forEach(carte => {
		const statut = carte.getAttribute('hexa');
		const bgColor = carte.querySelectorAll('.carte-bg-color');

		bgColor.forEach(bgColor => {
			bgColor.style.backgroundColor = statut;
		});
	});

	const ajoutBouton = document.getElementById('ajout-bouton');
	const overlay = document.querySelector('.overlay');
	
	if (overlay) {
		overlay.style.display = 'none';
	}

	if (ajoutBouton) {
		ajoutBouton.addEventListener('click', function() {
			if (overlay) {
				overlay.style.display = 'flex';
			}
		});
	}

	if (overlay) {
		overlay.addEventListener('click', function(event) {
			if (event.target === overlay) {
				overlay.style.display = 'none';
			}
		});
	}
});