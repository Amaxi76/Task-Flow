document.querySelector('.filtre-button').addEventListener('click', function() {
	document.getElementById('filter-popup').classList.add('show');
});

document.querySelector('.close-btn').addEventListener('click', function() {
	document.getElementById('filter-popup').classList.remove('show');
});