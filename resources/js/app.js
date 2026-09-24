import logoUrl from '../image/logo-abro-co.svg';

document.querySelectorAll('[data-brand-logo]').forEach((logo) => {
	logo.src = logoUrl;
});

const helpPage = document.querySelector('.help-page');

if (helpPage) {
	const filterButtons = [...helpPage.querySelectorAll('[data-help-filter]')];
	const serviceCards = [...helpPage.querySelectorAll('[data-help-category]')];
	const searchInput = helpPage.querySelector('#help-search');
	 const sortSelect = helpPage.querySelector('[data-help-sort]');
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

	const sortServices = () => {
		const sort = sortSelect.value;
		const list = helpPage.querySelector('.help-list');
		const sortedCards = [...serviceCards].sort((firstCard, secondCard) => {
			if (sort === 'category') {
				return firstCard.dataset.helpCategory.localeCompare(secondCard.dataset.helpCategory);
			}

			const firstValue = Number(firstCard.dataset[`help${sort[0].toUpperCase()}${sort.slice(1)}`]);
			const secondValue = Number(secondCard.dataset[`help${sort[0].toUpperCase()}${sort.slice(1)}`]);

			return firstValue - secondValue;
		});

		sortedCards.forEach((card) => list.append(card));
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
	sortSelect.addEventListener('change', sortServices);

	document.querySelectorAll('[data-help-service]').forEach((bookingForm) => {
		const dateInput = bookingForm.querySelector('input[name="slot_date"]');
		const slotSelect = bookingForm.querySelector('select[name="slot_time"]');
		const availability = bookingForm.querySelector('[data-help-availability]');
		const submitButton = bookingForm.querySelector('button[type="submit"]');
		const serviceKey = bookingForm.dataset.helpService;

		const updateAvailability = async () => {
			const response = await fetch(`/besoin-aide/${serviceKey}/disponibilite?date=${dateInput.value}`);
			if (!response.ok) {
				return;
			}

			const remainingBySlot = await response.json();
			[...slotSelect.options].forEach((option) => {
				const remaining = remainingBySlot[option.value];
				option.dataset.remaining = remaining;
				option.textContent = `${option.value} · ${remaining} places restantes`;
				option.disabled = remaining === 0;
			});

			const selectedRemaining = remainingBySlot[slotSelect.value];
			submitButton.disabled = selectedRemaining === 0;
			availability.textContent = `${selectedRemaining} place${selectedRemaining === 1 ? '' : 's'} restante${selectedRemaining === 1 ? '' : 's'}`;
		};

		dateInput.addEventListener('change', updateAvailability);
		slotSelect.addEventListener('change', () => {
			const remaining = slotSelect.selectedOptions[0]?.dataset.remaining;
			submitButton.disabled = Number(remaining) === 0;
			availability.textContent = `${remaining} places restantes`;
		});
		updateAvailability();
	});
}

const donationForm = document.querySelector('[data-donation-form]');

if (donationForm) {
	const donorOrganization = donationForm.querySelector('[data-donor-organization]');
	const donationFinancial = donationForm.querySelector('[data-donation-financial]');
	const donationFood = donationForm.querySelector('[data-donation-food]');
	const organizationInput = donationForm.querySelector('input[name="organization"]');
	const amountInput = donationForm.querySelector('input[name="amount"]');
	const descriptionInput = donationForm.querySelector('textarea[name="description"]');

	const updateDonationFields = () => {
		const donorType = donationForm.querySelector('input[name="donor_type"]:checked')?.value;
		const donationType = donationForm.querySelector('input[name="donation_type"]:checked')?.value;
		const isOrganization = donorType === 'organization';
		const isFinancial = donationType === 'financial';

		donorOrganization.hidden = !isOrganization;
		donationFinancial.hidden = !isFinancial;
		donationFood.hidden = isFinancial;
		organizationInput.required = isOrganization;
		amountInput.required = isFinancial;
		descriptionInput.required = !isFinancial;
	};

	donationForm.querySelectorAll('input[type="radio"]').forEach((input) => {
		input.addEventListener('change', updateDonationFields);
	});

	updateDonationFields();
}
