import logoUrl from '../image/logo-abro-co.svg';

document.querySelectorAll('[data-brand-logo]').forEach((logo) => {
	logo.src = logoUrl;
});

const helpPage = document.querySelector('.help-page');

if (helpPage) {
	const filterButtons = [...helpPage.querySelectorAll('[data-help-filter]')];
	const serviceCards = [...helpPage.querySelectorAll('[data-help-category]')];
	const searchInput = helpPage.querySelector('#help-search');
	const noResults = helpPage.querySelector('[data-help-no-results]');
	let activeFilter = 'all';

	const updateServices = () => {
		const search = searchInput.value.trim().toLowerCase();
		let visibleCount = 0;

		serviceCards.forEach((card) => {
			const matchesFilter = activeFilter === 'all' || card.dataset.helpCategory === activeFilter;
			const matchesSearch = !search || card.dataset.helpText.includes(search);
			const isVisible = matchesFilter && matchesSearch;

			card.hidden = !isVisible;
			visibleCount += isVisible ? 1 : 0;
		});

		noResults.hidden = visibleCount > 0;
	};

	filterButtons.forEach((button) => {
		button.addEventListener('click', () => {
			activeFilter = button.dataset.helpFilter;

			filterButtons.forEach((filterButton) => {
				const isActive = filterButton === button;
				filterButton.classList.toggle('is-active', isActive);
				filterButton.setAttribute('aria-pressed', String(isActive));
			});

			updateServices();
		});
	});

	searchInput.addEventListener('input', updateServices);
}
