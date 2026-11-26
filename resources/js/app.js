import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', () => {
	document.querySelector('.admin-shell')?.classList.toggle('sidebar-open');
});

document.querySelectorAll('[data-sidebar-close]').forEach((element) => {
	element.addEventListener('click', () => document.querySelector('.admin-shell')?.classList.remove('sidebar-open'));
});
