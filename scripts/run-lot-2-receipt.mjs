import { chromium, firefox, webkit } from 'playwright';
import AxeBuilder from '@axe-core/playwright';
import pixelmatch from 'pixelmatch';
import { PNG } from 'pngjs';
import fs from 'node:fs/promises';
import path from 'node:path';

const origin = (process.env.RC_ORIGIN || 'https://aliceblue-bison-433987.hostingersite.com').replace(/\/$/, '');
const username = process.env.RC_VENDOR_USER;
const password = process.env.RC_VENDOR_PASSWORD;
if (!username || !password) throw new Error('RC_VENDOR_USER et RC_VENDOR_PASSWORD sont requis pour la recette vendeur réelle.');
const receiptRoot = path.resolve(process.env.RC_QA_OUT || path.join(process.cwd(), 'docs', 'receipts', 'lot-2-artifacts'));
const runId = `lot2-${Date.now()}`;
const dishName = `Plat recette ${runId}`;
const png = Buffer.from('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9JfhYAAAAASUVORK5CYII=', 'base64');
const engines = [
  ['chromium', chromium, { executablePath: '/usr/bin/chromium', args: ['--disable-dev-shm-usage', '--disable-gpu'] }],
  ['firefox', firefox, {}],
  ['webkit', webkit, {}],
];
const widths = [390, 768, 1440, 1920];
const results = { runId, dishName, origin, startedAt: new Date().toISOString(), checks: {}, screens: [], axe: {}, cleanup: {} };
const staleProductIds = (process.env.RC_ARCHIVE_IDS || '').split(',').map((id) => Number(id.trim())).filter(Boolean);
let activeBrowser;

await fs.mkdir(receiptRoot, { recursive: true });
const safe = (text) => String(text).replace(/[^a-z0-9-]/gi, '-');
const saveShot = async (page, name) => { const destination = path.join(receiptRoot, `${safe(name)}.png`); await page.evaluate(async () => { await document.fonts?.ready; }); await page.screenshot({ path: destination, fullPage: true, animations: 'disabled' }); results.screens.push(destination); return destination; };
const post = async (page, action, fields = {}) => page.evaluate(async ({ action, fields }) => {
  const data = new FormData(); data.append('action', action); data.append('nonce', window.restocommerceVendorApp?.nonce || window.restocommerceTheme?.nonce || '');
  Object.entries(fields).forEach(([key, value]) => data.append(key, Array.isArray(value) || typeof value === 'object' ? JSON.stringify(value) : String(value)));
  const response = await fetch(window.restocommerceVendorApp?.ajaxUrl || window.restocommerceTheme?.ajaxUrl || '/wp-admin/admin-ajax.php', { method: 'POST', body: data, credentials: 'same-origin' });
  return response.json();
}, { action, fields });
const login = async (page) => {
  await page.goto(`${origin}/wp-login.php`, { waitUntil: 'domcontentloaded', timeout: 60000 });
  if (await page.locator('#user_login').count()) {
    await page.locator('#user_login').fill(username); await page.locator('#user_pass').fill(password);
    await Promise.all([page.waitForLoadState('domcontentloaded'), page.locator('#wp-submit').click()]);
  }
  await page.goto(`${origin}/store-manager/`, { waitUntil: 'domcontentloaded', timeout: 60000 });
  await page.locator('[data-rc-vendor-app]').waitFor({ state: 'visible', timeout: 30000 });
};
const axeSnapshot = async (page, label) => {
  const axe = await new AxeBuilder({ page }).withTags(['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa']).analyze();
  results.axe[label] = axe.violations.map((violation) => ({ id: violation.id, impact: violation.impact, nodes: violation.nodes.map((node) => node.target) }));
  if (axe.violations.length) throw new Error(`${label}: ${axe.violations.length} violation(s) axe.`);
};
const goNext = async (page) => { await page.locator('[data-rc-wizard-next]').click(); };
const openWizard = async (page) => {
  await page.locator('[data-rc-tab="menu"]:visible').first().click();
  await page.locator('[data-rc-open-product-wizard]:visible').first().click();
  await page.locator('[data-rc-product-wizard][open]').waitFor({ state: 'visible' });
};
const fillNewDish = async (page) => {
  await page.locator('[data-rc-wizard-photo]').setInputFiles({ name: 'plat-recette.png', mimeType: 'image/png', buffer: png });
  await page.locator('dialog [data-rc-wizard-next]').click();
  await page.locator('[data-rc-wizard-category="plats"]').click(); await goNext(page);
  await page.locator('[data-rc-wizard-name]').fill(dishName); await page.locator('[data-rc-wizard-description]').fill('Créé par la recette réelle du Lot 2.'); await goNext(page);
  await page.locator('[data-rc-wizard-price]').fill('89'); await goNext(page);
  await page.locator('[data-rc-wizard-new-option]').click();
  await page.locator('[data-rc-new-option-title]').fill(`Sauce ${runId}`);
  await page.locator('[data-rc-new-option-choices]').fill('Douce, Piquante, Blanche');
  await page.locator('[data-rc-new-option-required]').check();
	await page.locator('[data-rc-new-option-max="2"]').click();
	await page.locator('[data-rc-wizard-save-option]').click();
	const createdGroup = page.locator('.rc-product-wizard-option').filter({ hasText: `Sauce ${runId}` }); await createdGroup.waitFor({ state: 'visible' }); if (!await createdGroup.locator('[data-rc-wizard-option]').isChecked()) throw new Error('Le choix créé n’est pas sélectionné pour le plat avant publication.');
  await goNext(page);
  await page.locator('[data-rc-wizard-next]').click();
  await page.waitForLoadState('domcontentloaded');
  await page.locator('[data-rc-vendor-app]').waitFor({ state: 'visible', timeout: 30000 });
};
const continueDuplicate = async (page) => {
  await goNext(page); await goNext(page); await goNext(page); await goNext(page); await goNext(page);
  await page.locator('[data-rc-wizard-next]').click(); await page.waitForLoadState('domcontentloaded');
  await page.locator('[data-rc-vendor-app]').waitFor({ state: 'visible', timeout: 30000 });
};
try {
	activeBrowser = await chromium.launch({ executablePath: '/usr/bin/chromium', headless: true, args: ['--disable-dev-shm-usage', '--disable-gpu'] });
	const context = await activeBrowser.newContext({ viewport: { width: 390, height: 844 } }); const page = await context.newPage();
	await login(page); for (const staleId of staleProductIds) { results.cleanup[`stale-${staleId}`] = await post(page, 'restocommerce_vendor_archive_product', { product_id: staleId }); } await openWizard(page); await axeSnapshot(page, 'chromium-wizard-390-initial'); await page.keyboard.press('Tab'); results.checks.keyboardFocus = await page.evaluate(() => { const active = document.activeElement; const style = active ? getComputedStyle(active) : null; return { element: active?.tagName?.toLowerCase() || '', outlineStyle: style?.outlineStyle || '', outlineWidth: style?.outlineWidth || '' }; }); if ('none' === results.checks.keyboardFocus.outlineStyle || '0px' === results.checks.keyboardFocus.outlineWidth) throw new Error('Le focus clavier de l’assistant n’est pas discernable.');
  results.checks.wizardContract = await page.evaluate(() => ({ dialog: Boolean(document.querySelector('dialog[aria-modal="true"]')), title: document.querySelector('#rc-product-wizard-title')?.textContent?.trim(), progress: document.querySelector('.rc-product-wizard-progress i')?.style.width, support: document.querySelector('.rc-product-wizard-help')?.href, fileCapture: document.querySelector('[data-rc-wizard-photo]')?.getAttribute('capture') }));
  await saveShot(page, `${runId}-wizard-390-photo`);
  await fillNewDish(page);
  await page.locator('[data-rc-tab="menu"]:visible').first().click();
  const productRow = page.locator('[data-rc-product]', { hasText: dishName }).first(); await productRow.waitFor({ state: 'visible', timeout: 30000 });
  const productId = Number(await productRow.getAttribute('data-rc-product')); results.checks.createdProductId = productId;
  const editor = await post(page, 'restocommerce_vendor_product_editor_data', { product_id: productId });
  if (!editor.success) throw new Error('La lecture éditeur du produit créé a échoué.');
  const optionId = editor.data.product.optionGroups[0]; const publicUrl = editor.data.product.url;
  results.checks.realProduct = { id: productId, url: publicUrl, name: editor.data.product.name, price: editor.data.product.price, optionGroups: editor.data.product.optionGroups, image: Boolean(editor.data.product.imageUrl) };
  if (!productId || !optionId || !publicUrl || !editor.data.product.imageUrl) throw new Error('Le produit publié ne possède pas toutes les données attendues.');
  await productRow.locator('[data-rc-duplicate-product]').click(); await page.locator('[data-rc-product-wizard][open]').waitFor({ state: 'visible' }); await continueDuplicate(page);
  await page.locator('[data-rc-tab="menu"]:visible').first().click();
  const duplicateRow = page.locator('[data-rc-product]', { hasText: `Copie de ${dishName}` }).first(); await duplicateRow.waitFor({ state: 'visible', timeout: 30000 });
  const duplicateId = Number(await duplicateRow.getAttribute('data-rc-product')); results.checks.duplicateProductId = duplicateId;
	await page.locator('[data-rc-open-menu-library]:visible').click(); await page.locator('[data-rc-product-wizard][open]').waitFor({ state: 'visible' });
	const toggles = page.locator('[data-rc-wizard-library-toggle]'); const toggleCount = await toggles.count(); if (!toggleCount) throw new Error('Aucune disponibilité de catégorie ou d’option n’est proposée.');
	const optionToggle = page.locator('.rc-product-wizard-library-row').filter({ hasText: `Sauce ${runId}` }).locator('[data-rc-wizard-library-toggle="option"]'); if (!await optionToggle.count()) throw new Error('Le choix Sauce créé n’est pas disponible dans la bibliothèque.');
	const toggleState = (expected) => page.waitForFunction(({ title, expectedState }) => [...document.querySelectorAll('.rc-product-wizard-library-row')].find((row) => row.textContent.includes(title))?.querySelector('[data-rc-wizard-library-toggle="option"]')?.getAttribute('aria-pressed') === expectedState, { title: `Sauce ${runId}`, expectedState: expected }, { timeout: 5000 }); const beforeToggle = await optionToggle.getAttribute('aria-pressed'); await optionToggle.click(); await toggleState('false'); const afterToggle = await page.locator('.rc-product-wizard-library-row').filter({ hasText: `Sauce ${runId}` }).locator('[data-rc-wizard-library-toggle="option"]').getAttribute('aria-pressed'); const toggleStatus = await page.locator('.rc-product-wizard-status').textContent().catch(() => ''); await page.locator('.rc-product-wizard-library-row').filter({ hasText: `Sauce ${runId}` }).locator('[data-rc-wizard-library-toggle="option"]').click(); await toggleState('true'); const restoredToggle = await page.locator('.rc-product-wizard-library-row').filter({ hasText: `Sauce ${runId}` }).locator('[data-rc-wizard-library-toggle="option"]').getAttribute('aria-pressed');
	results.checks.libraryToggle = { count: toggleCount, beforeToggle, afterToggle, restoredToggle, optionToggleDetected: true, toggleStatus }; if (beforeToggle === afterToggle || restoredToggle !== beforeToggle) throw new Error(`Le basculement du choix Sauce ne se reflète pas correctement. ${toggleStatus || ''}`); await page.locator('[data-rc-wizard-close]').click();
	const sourceCategory = editor.data.library.categories.find((category) => category.name === editor.data.product.categoryLabel); if (sourceCategory) { results.checks.categoryEnabledForPublicTest = await post(page, 'restocommerce_vendor_toggle_menu_library', { kind: 'category', id: sourceCategory.id, enabled: 1 }); }
	await page.goto(publicUrl, { waitUntil: 'domcontentloaded', timeout: 60000 }); await page.locator('[data-rc-quick-order-form]').waitFor({ state: 'visible', timeout: 30000 });
  await axeSnapshot(page, 'chromium-client-product-390');
	const sauceSet = page.locator('[data-rc-extra-option-set]').filter({ hasText: `Sauce ${runId}` }); const sauceInputs = sauceSet.locator('input[type="checkbox"]'); const sauceLabels = sauceSet.locator('label');
	await sauceLabels.nth(0).click(); await sauceLabels.nth(1).click(); await sauceLabels.nth(2).click();
  results.checks.clientLimitUi = { selectedAfterThreeAttempts: await sauceSet.locator('input:checked').count(), thirdStillChecked: await sauceInputs.nth(2).isChecked() };
  if (results.checks.clientLimitUi.selectedAfterThreeAttempts !== 2 || results.checks.clientLimitUi.thirdStillChecked) throw new Error('La limite client de deux sauces n’est pas appliquée.');
	const optionFieldName = await sauceInputs.first().getAttribute('name'); const bypass = await page.evaluate(async ({ productId, optionFieldName }) => {
		const data = new FormData(); data.append('action', 'restocommerce_quick_add_to_cart'); data.append('nonce', window.restocommerceTheme.nonce); data.append('product_id', String(productId)); data.append('quantity', '1'); data.append('rc_menu_confirmation', '1'); ['Douce', 'Piquante', 'Blanche'].forEach((choice) => data.append(optionFieldName, choice));
		const response = await fetch(window.restocommerceTheme.ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' }); return response.json();
	}, { productId, optionFieldName });
  results.checks.clientLimitServer = { success: bypass.success, message: bypass.data?.message || '' }; if (bypass.success) throw new Error('Le serveur accepte trois sauces malgré la règle max 2.');
	await page.locator('input[name="rc_menu_confirmation"]').check(); await page.locator('[data-rc-quick-submit]').click(); await page.locator('[data-rc-quick-status]').waitFor({ state: 'visible', timeout: 20000 }); await page.waitForFunction(() => !document.querySelector('[data-rc-quick-status]')?.textContent?.includes('Ajout au panier…'), null, { timeout: 20000 });
	results.checks.clientAdd = await page.locator('[data-rc-quick-status]').textContent(); results.checks.clientCartCount = Number(await page.locator('[data-rc-cart-count]').first().textContent()); if (!/ajout/i.test(results.checks.clientAdd || '') || results.checks.clientCartCount < 1) throw new Error('L’ajout de deux sauces au panier ne s’est pas confirmé.'); await saveShot(page, `${runId}-client-390`);
  await page.goto(`${origin}/store-manager/`, { waitUntil: 'domcontentloaded' }); await page.locator('[data-rc-vendor-app]').waitFor({ state: 'visible' });
  results.cleanup.before = await post(page, 'restocommerce_vendor_archive_product', { product_id: productId }); results.cleanup.duplicate = await post(page, 'restocommerce_vendor_archive_product', { product_id: duplicateId });
  if (!results.cleanup.before.success || !results.cleanup.duplicate.success) throw new Error('L’archivage contrôlé des produits de recette a échoué.');
	await context.close(); await activeBrowser.close(); activeBrowser = null;

	for (const [name, launcher, launchOptions] of engines) {
		activeBrowser = await launcher.launch({ headless: true, ...launchOptions }); const context = await activeBrowser.newContext({ viewport: { width: 390, height: 844 } }); const page = await context.newPage();
    await login(page);
    for (const width of widths) { await page.setViewportSize({ width, height: width < 700 ? 844 : 1000 }); await openWizard(page); await axeSnapshot(page, `${name}-wizard-${width}`); await saveShot(page, `${runId}-${name}-wizard-${width}`); await page.locator('[data-rc-wizard-close]').click(); }
		await context.close(); await activeBrowser.close(); activeBrowser = null;
  }
	  const baseline = results.screens.find((file) => file.endsWith('chromium-wizard-390.png')) || results.screens.find((file) => file.includes('wizard-390'));
	  if (baseline) {
		activeBrowser = await chromium.launch({ executablePath: '/usr/bin/chromium', headless: true, args: ['--disable-dev-shm-usage', '--disable-gpu'] }); const pixelContext = await activeBrowser.newContext({ viewport: { width: 390, height: 844 } }); const pixelPage = await pixelContext.newPage(); await login(pixelPage); await openWizard(pixelPage); const currentShot = await saveShot(pixelPage, `${runId}-pixel-current-390`); const first = PNG.sync.read(await fs.readFile(baseline)); const second = PNG.sync.read(await fs.readFile(currentShot)); if (first.width !== second.width || first.height !== second.height) throw new Error('La comparaison Pixelmatch a reçu des captures de dimensions différentes.'); const changedPixels = pixelmatch(first.data, second.data, null, first.width, first.height, { threshold: 0.1, includeAA: false }); results.checks.pixelmatch = { baseline, currentShot, changedPixels, stable: changedPixels === 0 }; if (!results.checks.pixelmatch.stable) throw new Error(`Pixelmatch détecte ${changedPixels} pixels différents sur l’état initial du wizard.`); await pixelContext.close(); await activeBrowser.close(); activeBrowser = null;
	  }
  results.finishedAt = new Date().toISOString(); await fs.writeFile(path.join(receiptRoot, `${safe(runId)}-results.json`), JSON.stringify(results, null, 2)); console.log(JSON.stringify(results, null, 2));
} catch (error) {
	results.failure = { message: error.message, stack: error.stack }; results.finishedAt = new Date().toISOString(); await fs.writeFile(path.join(receiptRoot, `${safe(runId)}-failure.json`), JSON.stringify(results, null, 2)); console.error(JSON.stringify(results, null, 2)); process.exitCode = 1;
	} finally {
	if (activeBrowser) { await activeBrowser.close().catch(() => {}); }
}
