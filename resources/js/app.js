import logoUrl from '../image/logo-abro-co.svg';

document.querySelectorAll('[data-brand-logo]').forEach((logo) => {
	logo.src = logoUrl;
});
