/* Direction « Le Comptoir Éditorial » : interactions brèves, accessibles et réellement synchronisées à WooCommerce. */
(() => {
	const app = document.querySelector('[data-rc-vendor-app]');
	const config = window.restocommerceVendorApp;
	if (!app || !config) return;
	const feedbackHost = document.querySelector('[data-rc-vendor-feedback]');
	const notify = (message, kind = 'success', retry = null) => {
		if (!feedbackHost || !message) return () => {};
		const item = document.createElement('section');
		item.className = 'rc-feedback is-visible'; item.dataset.kind = kind; item.setAttribute('role', kind === 'error' ? 'alert' : 'status');
		item.innerHTML = `<i aria-hidden="true">${kind === 'error' ? '!' : kind === 'loading' ? '…' : '✓'}</i><p></p>${retry ? '<button type="button">Réessayer</button>' : ''}`;
		item.querySelector('p').textContent = message;
		const dismiss = () => item.remove(); item.querySelector('button')?.addEventListener('click', () => { dismiss(); retry?.(); }); feedbackHost.replaceChildren(item); if (kind !== 'loading') window.setTimeout(dismiss, 5200); return dismiss;
	};
	const queryParams = new URLSearchParams(window.location.search);
	const requestedState = queryParams.has('rcqa') ? (queryParams.get('rc_ui') || '') : '';

  const labels = { overview: 'Vue d’ensemble', orders: 'Commandes', menu: 'Mon menu', hours: 'Horaires', profile: 'Profil restaurant' };
  const post = async (action, fields = {}) => {
    const form = new FormData();
    form.append('action', action);
    form.append('nonce', config.nonce);
    Object.entries(fields).forEach(([key, value]) => form.append(key, String(value)));
    const response = await fetch(config.ajaxUrl, { method: 'POST', body: form, credentials: 'same-origin' });
    const result = await response.json();
    if (!result.success) throw new Error(result.data?.message || 'Une mise à jour est impossible pour le moment.');
    return result.data;
  };

  const activate = (section) => {
    if (!labels[section]) return;
    app.querySelectorAll('[data-rc-panel]').forEach((panel) => { panel.hidden = panel.dataset.rcPanel !== section; });
    app.querySelectorAll('[data-rc-tab]').forEach((tab) => tab.classList.toggle('is-active', tab.dataset.rcTab === section));
    const title = app.querySelector('[data-rc-section-title]');
    if (title) title.textContent = labels[section];
    window.history.replaceState(null, '', `${window.location.pathname}#${section}`);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  app.querySelectorAll('[data-rc-tab], [data-rc-go]').forEach((control) => control.addEventListener('click', () => activate(control.dataset.rcTab || control.dataset.rcGo)));
	const initial = window.location.hash.slice(1);
	if (labels[initial]) activate(initial);
	const setListState = (name, state = '') => { const shell = app.querySelector(`[data-rc-${name}-shell]`); const list = app.querySelector(`[data-rc-${name}-list]`); const loading = app.querySelector(`[data-rc-${name}-loading]`); const error = app.querySelector(`[data-rc-${name}-error]`); const success = app.querySelector(`[data-rc-${name}-success]`); const empty = app.querySelector(`[data-rc-${name}-empty]`); if (!shell) return; shell.setAttribute('aria-busy', state === 'loading' ? 'true' : 'false'); if (loading) loading.hidden = state !== 'loading'; if (error) error.hidden = state !== 'error'; if (success) success.hidden = state !== 'success'; if (empty) empty.hidden = state !== 'empty'; if (list) list.hidden = state === 'loading' || state === 'error' || state === 'success' || state === 'empty'; };
	if (/^orders-(loading|error|success|empty)$/.test(requestedState)) { activate('orders'); setListState('orders', requestedState.replace('orders-', '')); }
	if (/^menu-(loading|error|success|empty)$/.test(requestedState)) { activate('menu'); setListState('menu', requestedState.replace('menu-', '')); }
	app.querySelectorAll('[data-rc-retry-list]').forEach((button) => button.addEventListener('click', () => { const name = button.dataset.rcRetryList; setListState(name, 'success'); }));
	app.querySelectorAll('[data-rc-dismiss-list-success]').forEach((button) => button.addEventListener('click', () => { const name = button.dataset.rcDismissListSuccess; setListState(name); app.querySelector(`[data-rc-${name}-list]`)?.focus?.(); }));

	const service = app.querySelector('[data-rc-service-toggle]');
	if (service) service.addEventListener('click', async () => {
		const paused = service.getAttribute('aria-pressed') !== 'true';
		service.disabled = true; service.setAttribute('aria-busy', 'true'); const dismissLoading = notify(paused ? 'Mise en pause du restaurant…' : 'Réouverture du restaurant…', 'loading');
		try {
			const data = await post('restocommerce_toggle_vendor_service', { paused: paused ? 1 : 0 });
			service.classList.toggle('is-paused', Boolean(data.paused));
			service.setAttribute('aria-pressed', data.paused ? 'true' : 'false');
			const label = service.querySelector('span'); if (label) label.textContent = data.paused ? 'Fermé' : 'Ouvert'; dismissLoading(); notify(data.message || 'Statut du restaurant mis à jour.', 'success');
		} catch (error) { dismissLoading(); notify(error.message, 'error', () => service.click()); } finally { service.disabled = false; service.removeAttribute('aria-busy'); }
	});

  const statusClass = (state) => `rc-vendor-order-row`;
  app.querySelectorAll('[data-rc-order-advance]').forEach((button) => button.addEventListener('click', async () => {
    const row = button.closest('[data-rc-order]'); if (!row) return;
		button.disabled = true; button.setAttribute('aria-busy', 'true'); const dismissLoading = notify('Mise à jour de la commande…', 'loading');
    try {
      const data = await post('restocommerce_vendor_advance_order', { order_id: row.dataset.rcOrder });
      const status = row.querySelector('[data-rc-order-status]');
      if (status) { status.dataset.rcOrderStatus = data.state; status.textContent = data.label; }
      if (data.action) button.childNodes[0].nodeValue = data.action; else button.remove();
			if (data.state === 'completed') {
				app.querySelectorAll('[data-rc-active-orders], [data-rc-order-count]').forEach((counter) => { const value = Math.max(0, Number(counter.textContent || 0) - 1); counter.textContent = String(value); if (!value && counter.matches('[data-rc-order-count]')) counter.remove(); });
			}
			dismissLoading(); notify(`Commande ${data.label.toLowerCase()}.`, 'success');
		} catch (error) { dismissLoading(); notify(error.message, 'error', () => button.click()); } finally { if (button.isConnected) { button.disabled = false; button.removeAttribute('aria-busy'); } }
	}));

  app.querySelectorAll('[data-rc-product-toggle]').forEach((button) => button.addEventListener('click', async () => {
    const row = button.closest('[data-rc-product]'); if (!row) return;
		const available = button.dataset.rcAvailable !== '1'; button.disabled = true; button.setAttribute('aria-busy', 'true'); const dismissLoading = notify('Mise à jour de la disponibilité…', 'loading');
    try {
      const data = await post('restocommerce_vendor_toggle_product', { product_id: row.dataset.rcProduct, available: available ? 1 : 0 });
      button.dataset.rcAvailable = data.available ? '1' : '0'; button.classList.toggle('is-available', Boolean(data.available)); button.classList.toggle('is-unavailable', !data.available);
			const label = button.querySelector('span'); if (label) label.textContent = data.label; dismissLoading(); notify(`Plat ${data.label.toLowerCase()}.`, 'success');
		} catch (error) { dismissLoading(); notify(error.message, 'error', () => button.click()); } finally { button.disabled = false; button.removeAttribute('aria-busy'); }
	}));
})();
