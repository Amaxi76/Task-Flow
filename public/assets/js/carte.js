document.addEventListener('DOMContentLoaded', function() {
	const cartes = document.querySelectorAll('.carte');

	cartes.forEach(carte => {
		const statut = carte.getAttribute('hexa');
		const bgColor = carte.querySelectorAll('.carte-bg-color');

		bgColor.forEach(bgColor => {
			bgColor.style.backgroundColor = statut;
		});
	});
});