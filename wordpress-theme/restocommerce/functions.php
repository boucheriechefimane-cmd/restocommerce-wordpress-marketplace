<?php
/**
 * Direction « Le Comptoir Éditorial » : thème de présentation minimal, typographie
 * éditoriale et interactions légères, alimenté sans duplication par WooCommerce/WCFM.
 */
defined( 'ABSPATH' ) || exit;

function restocommerce_theme_setup() : void {
	load_theme_textdomain( 'restocommerce', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' ); add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 96, 'width' => 96, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'woocommerce' ); add_theme_support( 'wc-product-gallery-lightbox' ); add_theme_support( 'wc-product-gallery-slider' ); add_theme_support( 'align-wide' ); add_theme_support( 'responsive-embeds' );
	register_nav_menus( array( 'primary' => __( 'Navigation principale', 'restocommerce' ), 'footer' => __( 'Navigation de pied de page', 'restocommerce' ) ) );
}
add_action( 'after_setup_theme', 'restocommerce_theme_setup' );

function restocommerce_asset_version( string $relative_path ) : string { $path = get_template_directory() . $relative_path; return file_exists( $path ) ? (string) filemtime( $path ) : wp_get_theme()->get( 'Version' ); }
function restocommerce_cart_count() : int { return ( class_exists( 'WooCommerce' ) && WC()->cart ) ? (int) WC()->cart->get_cart_contents_count() : 0; }

function restocommerce_enqueue_assets() : void {
	wp_enqueue_style( 'restocommerce-fonts', 'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Manrope:wght@400;500;600;700;800&display=swap', array(), null );
	if ( function_exists( 'restocommerce_is_vendor_dashboard_home' ) && restocommerce_is_vendor_dashboard_home() ) { return; }
	wp_enqueue_style( 'restocommerce', get_stylesheet_uri(), array(), restocommerce_asset_version( '/style.css' ) );
	wp_enqueue_style( 'restocommerce-frontend', get_template_directory_uri() . '/assets/css/frontend.css', array( 'restocommerce-fonts', 'restocommerce' ), restocommerce_asset_version( '/assets/css/frontend.css' ) );
	wp_enqueue_style( 'restocommerce-quick-view-configurator', get_template_directory_uri() . '/assets/css/quick-view-configurator.css', array( 'restocommerce-frontend' ), restocommerce_asset_version( '/assets/css/quick-view-configurator.css' ) );
	wp_enqueue_style( 'restocommerce-product-configurator', get_template_directory_uri() . '/assets/css/product-configurator.css', array( 'restocommerce-quick-view-configurator' ), restocommerce_asset_version( '/assets/css/product-configurator.css' ) );
	wp_enqueue_style( 'restocommerce-cart-drawer', get_template_directory_uri() . '/assets/css/cart-drawer.css', array( 'restocommerce-product-configurator' ), restocommerce_asset_version( '/assets/css/cart-drawer.css' ) );
	wp_enqueue_style( 'restocommerce-wcfm-store', get_template_directory_uri() . '/assets/css/wcfm-store.css', array( 'restocommerce-frontend' ), restocommerce_asset_version( '/assets/css/wcfm-store.css' ) );
	if ( is_front_page() ) { wp_enqueue_style( 'restocommerce-home-editorial', get_template_directory_uri() . '/assets/css/home-editorial.css', array( 'restocommerce-frontend' ), restocommerce_asset_version( '/assets/css/home-editorial.css' ) ); }
	$micro_parity_dependencies = array( 'restocommerce-frontend' );
	if ( restocommerce_current_store_vendor() || is_product() ) { wp_enqueue_style( 'restocommerce-storefront', get_template_directory_uri() . '/assets/css/storefront.css', array( 'restocommerce-frontend' ), restocommerce_asset_version( '/assets/css/storefront.css' ) ); wp_enqueue_style( 'restocommerce-vendor-reviews', get_template_directory_uri() . '/assets/css/vendor-reviews.css', array( 'restocommerce-storefront' ), restocommerce_asset_version( '/assets/css/vendor-reviews.css' ) ); wp_enqueue_style( 'restocommerce-vendor-palettes-public', get_template_directory_uri() . '/assets/css/vendor-palettes.css', array( 'restocommerce-storefront' ), restocommerce_asset_version( '/assets/css/vendor-palettes.css' ) ); $micro_parity_dependencies[] = 'restocommerce-storefront'; }
	if ( is_cart() || ( is_checkout() && ! is_order_received_page() ) ) { wp_enqueue_style( 'restocommerce-commerce-flows', get_template_directory_uri() . '/assets/css/commerce-flows.css', array( 'restocommerce-frontend' ), restocommerce_asset_version( '/assets/css/commerce-flows.css' ) ); $micro_parity_dependencies[] = 'restocommerce-commerce-flows'; }
	if ( is_front_page() ) { $micro_parity_dependencies[] = 'restocommerce-home-editorial'; }
	wp_enqueue_style( 'restocommerce-micro-parity', get_template_directory_uri() . '/assets/css/micro-parity.css', $micro_parity_dependencies, restocommerce_asset_version( '/assets/css/micro-parity.css' ) );
	wp_enqueue_style( 'restocommerce-accessibility-remediation', get_template_directory_uri() . '/assets/css/accessibility-remediation.css', array( 'restocommerce-micro-parity', 'restocommerce-cart-drawer' ), restocommerce_asset_version( '/assets/css/accessibility-remediation.css' ) );
	wp_enqueue_style( 'restocommerce-ux-foundations', get_template_directory_uri() . '/assets/css/ux-foundations.css', array( 'restocommerce-accessibility-remediation' ), restocommerce_asset_version( '/assets/css/ux-foundations.css' ) );
	if ( function_exists( 'is_order_received_page' ) && is_order_received_page() ) { wp_enqueue_style( 'restocommerce-order-tracking', get_template_directory_uri() . '/assets/css/order-tracking.css', array( 'restocommerce-ux-foundations' ), restocommerce_asset_version( '/assets/css/order-tracking.css' ) ); wp_enqueue_style( 'restocommerce-vendor-reviews-received', get_template_directory_uri() . '/assets/css/vendor-reviews.css', array( 'restocommerce-order-tracking' ), restocommerce_asset_version( '/assets/css/vendor-reviews.css' ) ); wp_enqueue_script( 'restocommerce-vendor-reviews', get_template_directory_uri() . '/assets/js/vendor-reviews.js', array(), restocommerce_asset_version( '/assets/js/vendor-reviews.js' ), true ); wp_localize_script( 'restocommerce-vendor-reviews', 'restocommerceReview', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'restocommerce_vendor_review' ) ) ); }
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_script( 'restocommerce-interactions', get_template_directory_uri() . '/assets/js/cart.js', array( 'jquery', 'wc-add-to-cart', 'wc-cart-fragments' ), restocommerce_asset_version( '/assets/js/cart.js' ), true );
		wp_localize_script( 'restocommerce-interactions', 'restocommerceTheme', array( 'cartUrl' => wc_get_cart_url(), 'checkoutUrl' => wc_get_checkout_url(), 'ajaxUrl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'restocommerce_quick_view' ) ) );
	}
}
add_action( 'wp_enqueue_scripts', 'restocommerce_enqueue_assets' );

/** Direction « Atelier du Service » : l’habillage WCFM reste ciblé aux routes vendeur et ne charge aucun composant sur la marketplace publique. */
function restocommerce_is_vendor_dashboard() : bool {
	if ( ! is_user_logged_in() || ! function_exists( 'wcfm_is_vendor' ) || ! wcfm_is_vendor() ) { return false; }
	$path = trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );
	return 'store-manager' === $path || 0 === strpos( $path, 'store-manager/' );
}

function restocommerce_is_vendor_dashboard_home() : bool {
	if ( ! restocommerce_is_vendor_dashboard() ) { return false; }
	$path = trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );
	return 'store-manager' === $path;
}

function restocommerce_vendor_service_is_paused( int $vendor_id ) : bool {
	return $vendor_id > 0 && 'yes' === get_user_meta( $vendor_id, 'restocommerce_service_paused', true );
}

/** Direction « Atelier du Service » : la page d’accueil vendeur emploie son propre DOM, WCFM reste le moteur des données et autorisations. */
function restocommerce_vendor_store_name( int $vendor_id ) : string {
	$name = '';
	if ( function_exists( 'wcfmmp_get_store' ) ) {
		$store = wcfmmp_get_store( $vendor_id );
		if ( is_object( $store ) && method_exists( $store, 'get_shop_name' ) ) { $name = (string) $store->get_shop_name(); }
	}
	if ( ! $name ) {
		$settings = get_user_meta( $vendor_id, 'wcfmmp_profile_settings', true );
		if ( is_array( $settings ) && ! empty( $settings['store_name'] ) ) { $name = (string) $settings['store_name']; }
	}
	if ( ! $name ) { $name = (string) get_user_meta( $vendor_id, 'store_name', true ); }
	if ( ! $name ) { $name = (string) wp_get_current_user()->display_name; }
	return $name ?: __( 'Mon restaurant', 'restocommerce' );
}

function restocommerce_vendor_owns_product( int $vendor_id, int $product_id ) : bool {
	return $vendor_id > 0 && $product_id > 0 && $vendor_id === (int) get_post_field( 'post_author', $product_id );
}

/** Direction « Atelier du Service » : vocabulaire concret, une décision à la fois et règles de menu persistées par restaurant. */
function restocommerce_vendor_default_dish_categories() : array {
	return array(
		array( 'slug' => 'plats', 'label' => __( 'Plats', 'restocommerce' ), 'icon' => '🍲' ),
		array( 'slug' => 'entrees', 'label' => __( 'Entrées', 'restocommerce' ), 'icon' => '🥗' ),
		array( 'slug' => 'boissons', 'label' => __( 'Boissons', 'restocommerce' ), 'icon' => '🥤' ),
		array( 'slug' => 'desserts', 'label' => __( 'Desserts', 'restocommerce' ), 'icon' => '🍮' ),
		array( 'slug' => 'petit-dejeuner', 'label' => __( 'Petit déjeuner', 'restocommerce' ), 'icon' => '☕' ),
	);
}

function restocommerce_vendor_option_groups( int $vendor_id ) : array {
	$groups = get_user_meta( $vendor_id, 'restocommerce_vendor_option_groups', true );
	return is_array( $groups ) ? array_values( array_filter( $groups, 'is_array' ) ) : array();
}

function restocommerce_vendor_palettes() : array {
	return array(
		'comptoir' => array( 'label' => __( 'Comptoir éditorial', 'restocommerce' ), 'description' => __( 'Ivoire, vert service et terre cuite.', 'restocommerce' ) ),
		'safran'    => array( 'label' => __( 'Safran de médina', 'restocommerce' ), 'description' => __( 'Sable clair, bleu nuit et épice chaude.', 'restocommerce' ) ),
		'jardin'    => array( 'label' => __( 'Jardin de saison', 'restocommerce' ), 'description' => __( 'Vert feuille, crème végétale et brique.', 'restocommerce' ) ),
		'nuit'      => array( 'label' => __( 'Service du soir', 'restocommerce' ), 'description' => __( 'Nuit profonde, ivoire et cuivre.', 'restocommerce' ) ),
	);
}

function restocommerce_vendor_palette( int $vendor_id ) : string {
	$palette = sanitize_key( (string) get_user_meta( $vendor_id, 'restocommerce_vendor_palette', true ) );
	return array_key_exists( $palette, restocommerce_vendor_palettes() ) ? $palette : 'comptoir';
}

function restocommerce_vendor_save_option_groups( int $vendor_id, array $groups ) : void {
	update_user_meta( $vendor_id, 'restocommerce_vendor_option_groups', array_values( $groups ) );
}

function restocommerce_vendor_menu_library( int $vendor_id ) : array {
	$categories = array();
	foreach ( restocommerce_vendor_products_for_dashboard( $vendor_id ) as $product ) {
		$terms = get_the_terms( $product['id'], 'product_cat' );
		if ( ! $terms || is_wp_error( $terms ) ) { continue; }
		foreach ( $terms as $term ) {
			$categories[ $term->term_id ] = array( 'id' => (int) $term->term_id, 'name' => $term->name, 'enabled' => 'no' !== get_user_meta( $vendor_id, 'restocommerce_category_' . $term->term_id . '_enabled', true ) );
		}
	}
	return array( 'categories' => array_values( $categories ), 'options' => restocommerce_vendor_option_groups( $vendor_id ) );
}

function restocommerce_vendor_category_is_enabled( int $vendor_id, int $term_id ) : bool {
	return 'no' !== get_user_meta( $vendor_id, 'restocommerce_category_' . $term_id . '_enabled', true );
}

function restocommerce_vendor_product_option_groups( int $product_id, bool $only_enabled = false ) : array {
	$group_ids = get_post_meta( $product_id, 'restocommerce_option_group_ids', true );
	if ( ! is_array( $group_ids ) || ! $group_ids ) { return array(); }
	$vendor_id = (int) get_post_field( 'post_author', $product_id );
	$groups = restocommerce_vendor_option_groups( $vendor_id );
	$index = array(); foreach ( $groups as $group ) { if ( ! empty( $group['id'] ) ) { $index[ (string) $group['id'] ] = $group; } }
	$result = array();
	foreach ( $group_ids as $group_id ) {
		if ( empty( $index[ (string) $group_id ] ) ) { continue; }
		$group = $index[ (string) $group_id ];
		if ( $only_enabled && empty( $group['enabled'] ) ) { continue; }
		$result[] = $group;
	}
	return $result;
}

function restocommerce_vendor_order_items( WC_Order $order, int $vendor_id ) : array {
	$items = array();
	foreach ( $order->get_items( 'line_item' ) as $item ) {
		$product_id = $item->get_variation_id() ?: $item->get_product_id();
		if ( ! restocommerce_vendor_owns_product( $vendor_id, (int) $product_id ) ) { continue; }
		$items[] = $item;
	}
	return $items;
}

function restocommerce_vendor_order_state( WC_Order $order, int $vendor_id ) : string {
	$stored = (string) $order->get_meta( '_restocommerce_vendor_state_' . $vendor_id, true );
	if ( in_array( $stored, array( 'confirm', 'cooking', 'ready', 'completed' ), true ) ) { return $stored; }
	$status = $order->get_status();
	if ( in_array( $status, array( 'completed', 'cancelled', 'refunded', 'failed' ), true ) ) { return 'completed'; }
	if ( 'processing' === $status ) { return 'cooking'; }
	return 'confirm';
}

function restocommerce_vendor_order_label( string $state ) : string {
	return array( 'confirm' => __( 'À confirmer', 'restocommerce' ), 'cooking' => __( 'En cuisine', 'restocommerce' ), 'ready' => __( 'Prête', 'restocommerce' ), 'completed' => __( 'Terminée', 'restocommerce' ) )[ $state ] ?? __( 'À confirmer', 'restocommerce' );
}

function restocommerce_vendor_order_action_label( string $state ) : string {
	return array( 'confirm' => __( 'Accepter', 'restocommerce' ), 'cooking' => __( 'Prête', 'restocommerce' ), 'ready' => __( 'Terminer', 'restocommerce' ) )[ $state ] ?? '';
}

function restocommerce_vendor_orders( int $vendor_id, int $limit = 100 ) : array {
	if ( ! function_exists( 'wc_get_orders' ) ) { return array(); }
	$orders = wc_get_orders( array( 'limit' => $limit, 'orderby' => 'date', 'order' => 'DESC', 'status' => array_keys( wc_get_order_statuses() ) ) );
	$rows   = array();
	foreach ( $orders as $order ) {
		if ( ! $order instanceof WC_Order ) { continue; }
		$items = restocommerce_vendor_order_items( $order, $vendor_id );
		if ( ! $items ) { continue; }
		$quantity = 0; $amount = 0.0; $names = array();
		foreach ( $items as $item ) { $quantity += (int) $item->get_quantity(); $amount += (float) $item->get_total() + (float) $item->get_total_tax(); $names[] = $item->get_name(); }
		$date = $order->get_date_created();
		$rows[] = array(
			'id'       => $order->get_id(),
			'number'   => '#' . $order->get_order_number(),
			'customer' => trim( $order->get_billing_first_name() . ' ' . ( $order->get_billing_last_name() ? mb_substr( $order->get_billing_last_name(), 0, 1 ) . '.' : '' ) ) ?: __( 'Client', 'restocommerce' ),
			'time'     => $date ? wp_date( 'H:i', $date->getTimestamp() ) : '—',
			'items'    => $quantity . ' ' . _n( 'plat', 'plats', $quantity, 'restocommerce' ) . ( $names ? ' · ' . implode( ', ', array_slice( $names, 0, 2 ) ) : '' ),
			'amount'   => $amount,
			'total'    => wc_price( $amount ),
			'state'    => restocommerce_vendor_order_state( $order, $vendor_id ),
			'timestamp'=> $date ? $date->getTimestamp() : 0,
		);
	}
	return $rows;
}

/** Direction « Atelier du Service » : journal additif des événements métier, sans purge ni écrasement des alertes existantes. */
function restocommerce_vendor_order_vendor_ids( WC_Order $order ) : array {
	$vendor_ids = array();
	foreach ( $order->get_items( 'line_item' ) as $item ) {
		$product_id = $item->get_variation_id() ?: $item->get_product_id();
		$vendor_id  = $product_id ? (int) get_post_field( 'post_author', $product_id ) : 0;
		if ( $vendor_id > 0 ) { $vendor_ids[] = $vendor_id; }
	}
	return array_values( array_unique( $vendor_ids ) );
}

function restocommerce_vendor_notification_records( int $vendor_id, int $limit = 40 ) : array {
	$records = array_filter( get_user_meta( $vendor_id, 'restocommerce_vendor_notification', false ), 'is_array' );
	usort( $records, static function( array $a, array $b ) : int { return (int) ( $b['createdAt'] ?? 0 ) <=> (int) ( $a['createdAt'] ?? 0 ); } );
	return array_slice( $records, 0, $limit );
}

function restocommerce_vendor_append_notification( int $vendor_id, WC_Order $order, string $event ) : void {
	$notification_id = 'order-' . $order->get_id() . '-' . sanitize_key( $event );
	foreach ( get_user_meta( $vendor_id, 'restocommerce_vendor_notification', false ) as $record ) {
		if ( is_array( $record ) && $notification_id === ( $record['id'] ?? '' ) ) { return; }
	}
	$status = str_replace( 'wc-', '', $order->get_status() );
	$label  = wc_get_order_status_name( 'wc-' . $status );
	$copy   = 'received' === $event
		? sprintf( __( 'La commande #%s attend votre prise en charge.', 'restocommerce' ), $order->get_order_number() )
		: sprintf( __( 'La commande #%1$s est maintenant « %2$s ».', 'restocommerce' ), $order->get_order_number(), $label );
	add_user_meta( $vendor_id, 'restocommerce_vendor_notification', array(
		'id'        => $notification_id,
		'orderId'   => (int) $order->get_id(),
		'event'     => sanitize_key( $event ),
		'title'     => 'received' === $event ? __( 'Nouvelle commande', 'restocommerce' ) : __( 'Commande mise à jour', 'restocommerce' ),
		'message'   => $copy,
		'createdAt' => time(),
	), false );
}

function restocommerce_vendor_record_new_order_notifications( int $order_id ) : void {
	$order = function_exists( 'wc_get_order' ) ? wc_get_order( $order_id ) : false;
	if ( ! $order instanceof WC_Order ) { return; }
	foreach ( restocommerce_vendor_order_vendor_ids( $order ) as $vendor_id ) { restocommerce_vendor_append_notification( $vendor_id, $order, 'received' ); }
}
add_action( 'woocommerce_new_order', 'restocommerce_vendor_record_new_order_notifications', 20 );

function restocommerce_vendor_record_order_status_notifications( int $order_id, string $old_status, string $new_status, $order = null ) : void {
	$order = $order instanceof WC_Order ? $order : ( function_exists( 'wc_get_order' ) ? wc_get_order( $order_id ) : false );
	if ( ! $order instanceof WC_Order || $old_status === $new_status ) { return; }
	foreach ( restocommerce_vendor_order_vendor_ids( $order ) as $vendor_id ) { restocommerce_vendor_append_notification( $vendor_id, $order, 'status-' . sanitize_key( $new_status ) ); }
}
add_action( 'woocommerce_order_status_changed', 'restocommerce_vendor_record_order_status_notifications', 20, 4 );

function restocommerce_vendor_notification_preferences( int $vendor_id ) : array {
	$preferences = get_user_meta( $vendor_id, 'restocommerce_vendor_notification_preferences', true );
	return array( 'sound' => ! empty( $preferences['sound'] ), 'vibration' => ! empty( $preferences['vibration'] ) );
}

function restocommerce_vendor_products_for_dashboard( int $vendor_id ) : array {
	if ( ! function_exists( 'wc_get_product' ) ) { return array(); }
	$ids = get_posts( array( 'post_type' => 'product', 'post_status' => array( 'publish', 'draft', 'private' ), 'author' => $vendor_id, 'posts_per_page' => -1, 'fields' => 'ids', 'orderby' => 'menu_order date', 'order' => 'DESC' ) );
	$rows = array();
	foreach ( $ids as $id ) {
		$product = wc_get_product( $id ); if ( ! $product ) { continue; }
		$terms = get_the_terms( $id, 'product_cat' ); $category = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'À la carte', 'restocommerce' );
		$rows[] = array( 'id' => $product->get_id(), 'name' => $product->get_name(), 'category' => $category, 'price' => $product->get_price_html() ?: wc_price( (float) $product->get_price() ), 'available' => $product->is_in_stock() );
	}
	return $rows;
}

/** Direction « Atelier du Service » : des conseils issus seulement de l’historique WooCommerce du restaurant, jamais de valeurs de démonstration. */
function restocommerce_vendor_insights( int $vendor_id ) : array {
	$now = current_time( 'timestamp' ); $week = 7 * DAY_IN_SECONDS; $month = 30 * DAY_IN_SECONDS; $cutoff = $now - ( 365 * DAY_IN_SECONDS );
	$orders = function_exists( 'wc_get_orders' ) ? wc_get_orders( array( 'limit' => -1, 'orderby' => 'date', 'order' => 'DESC', 'date_created' => '>=' . gmdate( 'Y-m-d H:i:s', $cutoff ), 'status' => array_keys( wc_get_order_statuses() ) ) ) : array();
	$excluded_statuses = array( 'cancelled', 'failed', 'refunded', 'trash' ); $weekly_products = array(); $last_sold = array(); $current_week = 0.0; $previous_week = 0.0; $current_month = 0.0; $previous_month = 0.0; $real_orders = 0;
	foreach ( $orders as $order ) {
		if ( ! $order instanceof WC_Order || in_array( $order->get_status(), $excluded_statuses, true ) ) { continue; }
		$date = $order->get_date_created(); $timestamp = $date ? $date->getTimestamp() : 0; if ( ! $timestamp ) { continue; }
		$items = restocommerce_vendor_order_items( $order, $vendor_id ); if ( ! $items ) { continue; }
		++$real_orders; $amount = 0.0;
		foreach ( $items as $item ) { $product_id = (int) ( $item->get_variation_id() ?: $item->get_product_id() ); $amount += (float) $item->get_total() + (float) $item->get_total_tax(); if ( $product_id ) { $last_sold[ $product_id ] = max( $timestamp, (int) ( $last_sold[ $product_id ] ?? 0 ) ); if ( $timestamp >= $now - $week ) { $weekly_products[ $product_id ] = ( $weekly_products[ $product_id ] ?? 0 ) + (int) $item->get_quantity(); } } }
		if ( $timestamp >= $now - $week ) { $current_week += $amount; } elseif ( $timestamp >= $now - ( 2 * $week ) ) { $previous_week += $amount; }
		if ( $timestamp >= $now - $month ) { $current_month += $amount; } elseif ( $timestamp >= $now - ( 2 * $month ) ) { $previous_month += $amount; }
	}
	arsort( $weekly_products ); $top_product_id = $weekly_products ? (int) array_key_first( $weekly_products ) : 0; $top_product = $top_product_id ? wc_get_product( $top_product_id ) : false;
	$inactive = array(); foreach ( restocommerce_vendor_products_for_dashboard( $vendor_id ) as $product ) { $last = (int) ( $last_sold[ $product['id'] ] ?? 0 ); $days = $last ? max( 0, (int) floor( ( $now - $last ) / DAY_IN_SECONDS ) ) : null; if ( null === $days || $days >= 14 ) { $inactive[] = array( 'name' => $product['name'], 'days' => $days ); } }
	usort( $inactive, static function( array $a, array $b ) : int { return ( $b['days'] ?? 100000 ) <=> ( $a['days'] ?? 100000 ); } );
	$trend = static function( float $current, float $previous ) : array { return array( 'current' => $current, 'previous' => $previous, 'change' => $previous > 0 ? round( ( ( $current - $previous ) / $previous ) * 100 ) : null ); };
	return array( 'historyCount' => $real_orders, 'topProduct' => $top_product ? array( 'name' => $top_product->get_name(), 'quantity' => (int) ( $weekly_products[ $top_product_id ] ?? 0 ) ) : null, 'inactive' => array_slice( $inactive, 0, 3 ), 'weekTrend' => $trend( $current_week, $previous_week ), 'monthTrend' => $trend( $current_month, $previous_month ) );
}

function restocommerce_vendor_dashboard_data( int $vendor_id ) : array {
	$orders = restocommerce_vendor_orders( $vendor_id ); $products = restocommerce_vendor_products_for_dashboard( $vendor_id );
	$today_start = strtotime( 'today', current_time( 'timestamp' ) ); $yesterday_start = strtotime( 'yesterday', current_time( 'timestamp' ) );
	$today_sales = 0.0; $yesterday_sales = 0.0; $today_orders = array(); $hourly = array_combine( range( 11, 22 ), array_fill( 0, 12, 0 ) );
	foreach ( $orders as $order ) {
		if ( $order['timestamp'] >= $today_start ) { $today_sales += $order['amount']; $today_orders[] = $order; $hour = (int) wp_date( 'G', $order['timestamp'] ); if ( isset( $hourly[ $hour ] ) ) { $hourly[ $hour ]++; } }
		elseif ( $order['timestamp'] >= $yesterday_start ) { $yesterday_sales += $order['amount']; }
	}
	$active = count( array_filter( $orders, static fn( $order ) => 'completed' !== $order['state'] ) );
	$average = $today_orders ? $today_sales / count( $today_orders ) : 0.0;
	$change = $yesterday_sales > 0 ? round( ( ( $today_sales - $yesterday_sales ) / $yesterday_sales ) * 100 ) : null;
	return array( 'store_name' => restocommerce_vendor_store_name( $vendor_id ), 'orders' => $orders, 'products' => $products, 'menu_library' => restocommerce_vendor_menu_library( $vendor_id ), 'active_orders' => $active, 'today_count' => count( $today_orders ), 'today_sales' => $today_sales, 'yesterday_sales' => $yesterday_sales, 'average' => $average, 'change' => $change, 'hourly' => $hourly, 'insights' => restocommerce_vendor_insights( $vendor_id ), 'is_paused' => restocommerce_vendor_service_is_paused( $vendor_id ), 'average_delay' => max( 1, (int) get_user_meta( $vendor_id, 'restocommerce_average_delay', true ) ?: 18 ) );
}

function restocommerce_enqueue_vendor_dashboard_assets() : void {
	if ( ! restocommerce_is_vendor_dashboard() ) { return; }
	if ( ! restocommerce_is_vendor_dashboard_home() ) {
		wp_enqueue_script( 'restocommerce-vendor-wcfm-form-fix', get_template_directory_uri() . '/assets/js/vendor-wcfm-form-fix.js', array(), restocommerce_asset_version( '/assets/js/vendor-wcfm-form-fix.js' ), true );
		return;
	}
	$vendor_id = get_current_user_id();
	wp_enqueue_style( 'restocommerce-vendor-dashboard-app', get_template_directory_uri() . '/assets/css/vendor-dashboard-app.css', array( 'restocommerce-fonts' ), restocommerce_asset_version( '/assets/css/vendor-dashboard-app.css' ) );
	wp_enqueue_style( 'restocommerce-vendor-product-wizard', get_template_directory_uri() . '/assets/css/vendor-product-wizard.css', array( 'restocommerce-vendor-dashboard-app' ), restocommerce_asset_version( '/assets/css/vendor-product-wizard.css' ) );
	wp_enqueue_style( 'restocommerce-vendor-product-wizard-a11y', get_template_directory_uri() . '/assets/css/vendor-product-wizard-a11y.css', array( 'restocommerce-vendor-product-wizard' ), restocommerce_asset_version( '/assets/css/vendor-product-wizard-a11y.css' ) );
	wp_enqueue_style( 'restocommerce-vendor-onboarding', get_template_directory_uri() . '/assets/css/vendor-onboarding.css', array( 'restocommerce-vendor-dashboard-app' ), restocommerce_asset_version( '/assets/css/vendor-onboarding.css' ) );
	wp_enqueue_style( 'restocommerce-vendor-guidance', get_template_directory_uri() . '/assets/css/vendor-guidance.css', array( 'restocommerce-vendor-dashboard-app' ), restocommerce_asset_version( '/assets/css/vendor-guidance.css' ) );
	wp_enqueue_style( 'restocommerce-vendor-notifications', get_template_directory_uri() . '/assets/css/vendor-notifications.css', array( 'restocommerce-vendor-dashboard-app' ), restocommerce_asset_version( '/assets/css/vendor-notifications.css' ) );
	wp_enqueue_style( 'restocommerce-vendor-reviews-dashboard', get_template_directory_uri() . '/assets/css/vendor-reviews.css', array( 'restocommerce-vendor-dashboard-app' ), restocommerce_asset_version( '/assets/css/vendor-reviews.css' ) );
	wp_enqueue_style( 'restocommerce-vendor-insights', get_template_directory_uri() . '/assets/css/vendor-insights.css', array( 'restocommerce-vendor-dashboard-app' ), restocommerce_asset_version( '/assets/css/vendor-insights.css' ) );
	wp_enqueue_style( 'restocommerce-vendor-palettes-dashboard', get_template_directory_uri() . '/assets/css/vendor-palettes.css', array( 'restocommerce-vendor-dashboard-app' ), restocommerce_asset_version( '/assets/css/vendor-palettes.css' ) );
	wp_enqueue_script( 'restocommerce-vendor-dashboard-app', get_template_directory_uri() . '/assets/js/vendor-dashboard-app.js', array(), restocommerce_asset_version( '/assets/js/vendor-dashboard-app.js' ), true );
	wp_enqueue_script( 'restocommerce-vendor-product-wizard', get_template_directory_uri() . '/assets/js/vendor-product-wizard.js', array( 'restocommerce-vendor-dashboard-app' ), restocommerce_asset_version( '/assets/js/vendor-product-wizard.js' ), true );
	wp_enqueue_script( 'restocommerce-vendor-onboarding', get_template_directory_uri() . '/assets/js/vendor-onboarding.js', array( 'restocommerce-vendor-dashboard-app', 'restocommerce-vendor-product-wizard' ), restocommerce_asset_version( '/assets/js/vendor-onboarding.js' ), true );
	$support_url = function_exists( 'restocommerce_vendor_whatsapp_support_url' ) ? restocommerce_vendor_whatsapp_support_url( $vendor_id, __( 'Bonjour, j’ai besoin d’aide pour gérer ma boutique RestoCommerce.', 'restocommerce' ) ) : '';
	$support_message = __( 'L’aide WhatsApp n’est pas encore configurée pour cette boutique. Consultez le guide ou contactez l’administrateur.', 'restocommerce' );
	wp_localize_script( 'restocommerce-vendor-dashboard-app', 'restocommerceVendorApp', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'restocommerce_vendor_dashboard' ), 'vendorId' => $vendor_id, 'wizard' => array( 'categories' => restocommerce_vendor_default_dish_categories(), 'supportUrl' => $support_url, 'supportUnavailableMessage' => $support_message ), 'guidance' => array( 'tourDismissed' => 'yes' === get_user_meta( $vendor_id, 'restocommerce_vendor_guidance_tour_dismissed', true ), 'supportUrl' => $support_url, 'supportUnavailableMessage' => $support_message ), 'notifications' => array( 'pollInterval' => 45000, 'preferences' => restocommerce_vendor_notification_preferences( $vendor_id ), 'supportUrl' => $support_url, 'supportUnavailableMessage' => $support_message ), 'palettes' => array( 'current' => restocommerce_vendor_palette( $vendor_id ), 'items' => restocommerce_vendor_palettes() ), 'onboarding' => restocommerce_vendor_onboarding_state( $vendor_id ) ) );
}
add_action( 'wp_enqueue_scripts', 'restocommerce_enqueue_vendor_dashboard_assets', 99 );

/** Direction « Atelier du Service » : le cockpit propriétaire ne charge pas les composants publics ni les écrans WCFM remplacés par ce thème. */
function restocommerce_dequeue_vendor_dashboard_legacy_assets() : void {
	if ( ! restocommerce_is_vendor_dashboard_home() ) { return; }
	$styles = array( 'wc-blocks-style', 'woocommerce-layout', 'woocommerce-smallscreen', 'woocommerce-general', 'hostinger-reach-subscription-block', 'jquery-ui', 'buttons', 'dashicons', 'mediaelement', 'wp-mediaelement', 'media-views', 'imgareaselect', 'media', 'upload_css', 'select2_css', 'collapsible_css', 'wcfm_fa_icon_css', 'wcfm_core_css', 'wcfm_menu_css', 'wcfm_menu_slick_css', 'wcfm_responsive_non_float_menu_css', 'wcfm_template_css', 'wcfm_dashboard_css', 'wcfm_dashboard_welcomebox_css', 'wcfm_custom_css', 'wcfm_products_manage_css', 'wcfmvm_per_for_product_css', 'wcfm_product_popup_css' );
	$scripts = array( 'jquery', 'jquery-migrate', 'wc-jquery-blockui', 'wc-js-cookie', 'woocommerce', 'utils', 'moxiejs', 'plupload', 'wc-add-to-cart', 'hostinger-reach-subscription-block-view', 'wc-cart-fragments', 'restocommerce-interactions', 'sourcebuster-js', 'wc-order-attribution', 'jquery-blockui_js', 'jquery-ui-core', 'jquery-ui-datepicker', 'wcfm_core_js', 'wcfm_menu_js', 'jquery-chart_moment_js', 'jquery-chart_js', 'jquery-chart_util_js', 'wcfm_dashboard_js', 'underscore', 'shortcode', 'backbone', 'wp-util', 'wp-backbone', 'media-models', 'wp-plupload', 'jquery-ui-mouse', 'jquery-ui-sortable', 'mediaelement-core', 'mediaelement-migrate', 'wp-mediaelement', 'wp-api-request', 'wp-dom-ready', 'wp-hooks', 'wp-i18n', 'wp-a11y', 'clipboard', 'media-views', 'media-editor', 'media-audiovideo', 'imgareaselect', 'image-edit', 'upload_js', 'select2_js', 'collapsible_js', 'wcfm_products_manage_js', 'wcfmvm_per_for_product_js', 'wcfm_product_popup_js' );
	foreach ( $styles as $handle ) { wp_dequeue_style( $handle ); }
	foreach ( $scripts as $handle ) { wp_dequeue_script( $handle ); }
}
add_action( 'wp_enqueue_scripts', 'restocommerce_dequeue_vendor_dashboard_legacy_assets', 1000 );

/** Direction « Le Comptoir Éditorial » : la fiche restaurant et la fiche plat ont leur propre habillage ; les CSS de back-office ne doivent pas retarder le premier rendu public. */
function restocommerce_dequeue_public_legacy_styles() : void {
	if ( ! restocommerce_current_store_vendor() && ! is_product() ) { return; }
	$styles = array(
		'wc-blocks-style',
		'woocommerce-layout',
		'woocommerce-smallscreen',
		'woocommerce-general',
		'hostinger-reach-subscription-block',
		'jquery-ui-style',
		'wcfm_fa_icon_css',
		'wcfm_core_css',
		'wcfm-leaflet-map-style',
		'wcfm-leaflet-search-style',
		'select2_css',
		'wcfmmp_store_css',
		'wcfmmp_store_responsive_css',
	);
	foreach ( $styles as $handle ) { wp_dequeue_style( $handle ); }
}
add_action( 'wp_enqueue_scripts', 'restocommerce_dequeue_public_legacy_styles', 1000 );

function restocommerce_enqueue_storefront_contrast_hotfix() : void {
	if ( ! restocommerce_current_store_vendor() && ! is_product() ) { return; }
	wp_enqueue_style( 'restocommerce-storefront-contrast-hotfix', get_template_directory_uri() . '/assets/css/storefront-contrast-hotfix.css', array( 'restocommerce-vendor-palettes-public' ), restocommerce_asset_version( '/assets/css/storefront-contrast-hotfix.css' ) );
}
add_action( 'wp_enqueue_scripts', 'restocommerce_enqueue_storefront_contrast_hotfix', 1001 );

add_filter( 'body_class', function( array $classes ) : array {
	if ( restocommerce_is_vendor_dashboard() ) { $classes[] = 'rc-vendor-dashboard'; }
	if ( restocommerce_is_vendor_dashboard_home() ) { $classes[] = 'rc-vendor-dashboard-home'; }
	if ( restocommerce_is_vendor_dashboard_home() ) { $classes[] = 'rc-vendor-palette-' . restocommerce_vendor_palette( get_current_user_id() ); }
	$store_vendor = restocommerce_current_store_vendor();
	if ( $store_vendor instanceof WP_User ) { $classes[] = 'rc-palette-' . restocommerce_vendor_palette( (int) $store_vendor->ID ); }
	elseif ( is_product() ) { $product_vendor_id = (int) get_post_field( 'post_author', get_queried_object_id() ); if ( $product_vendor_id ) { $classes[] = 'rc-palette-' . restocommerce_vendor_palette( $product_vendor_id ); } }
	return $classes;
} );

function restocommerce_ajax_toggle_vendor_service() : void {
	check_ajax_referer( 'restocommerce_vendor_dashboard', 'nonce' );
	if ( ! is_user_logged_in() || ! function_exists( 'wcfm_is_vendor' ) || ! wcfm_is_vendor() ) { wp_send_json_error( array( 'message' => __( 'Cette action est réservée au restaurateur connecté.', 'restocommerce' ) ), 403 ); }
	$vendor_id = get_current_user_id();
	$pause     = ! empty( $_POST['paused'] ) && '1' === (string) $_POST['paused'];
	if ( $pause ) { update_user_meta( $vendor_id, 'restocommerce_service_paused', 'yes' ); } else { delete_user_meta( $vendor_id, 'restocommerce_service_paused' ); }
	wp_send_json_success( array(
		'paused'  => $pause,
		'message' => $pause ? __( 'Le restaurant est en pause. Les nouveaux plats ne peuvent plus être commandés.', 'restocommerce' ) : __( 'Le restaurant est ouvert. Les clients peuvent commander à nouveau.', 'restocommerce' ),
	) );
}
add_action( 'wp_ajax_restocommerce_toggle_vendor_service', 'restocommerce_ajax_toggle_vendor_service' );

function restocommerce_ajax_vendor_advance_order() : void {
	check_ajax_referer( 'restocommerce_vendor_dashboard', 'nonce' );
	$vendor_id = get_current_user_id(); $order = function_exists( 'wc_get_order' ) ? wc_get_order( absint( $_POST['order_id'] ?? 0 ) ) : false;
	if ( ! $order instanceof WC_Order || ! restocommerce_vendor_order_items( $order, $vendor_id ) ) { wp_send_json_error( array( 'message' => __( 'Cette commande n’est pas accessible.', 'restocommerce' ) ), 403 ); }
	$state = restocommerce_vendor_order_state( $order, $vendor_id );
	if ( 'completed' === $state ) { wp_send_json_error( array( 'message' => __( 'Cette commande est déjà terminée.', 'restocommerce' ) ) ); }
	$next = array( 'confirm' => 'cooking', 'cooking' => 'ready', 'ready' => 'completed' )[ $state ];
	$order->update_meta_data( '_restocommerce_vendor_state_' . $vendor_id, $next );
	if ( 'confirm' === $state && ! in_array( $order->get_status(), array( 'processing', 'completed' ), true ) ) { $order->set_status( 'processing' ); }
	if ( 'completed' === $next ) { $order->set_status( 'completed' ); }
	$order->add_order_note( sprintf( __( 'Mise à jour restaurateur : %s.', 'restocommerce' ), restocommerce_vendor_order_label( $next ) ) ); $order->save();
	wp_send_json_success( array( 'state' => $next, 'label' => restocommerce_vendor_order_label( $next ), 'action' => restocommerce_vendor_order_action_label( $next ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_advance_order', 'restocommerce_ajax_vendor_advance_order' );

function restocommerce_ajax_vendor_toggle_product() : void {
	check_ajax_referer( 'restocommerce_vendor_dashboard', 'nonce' );
	$vendor_id = get_current_user_id(); $product_id = absint( $_POST['product_id'] ?? 0 ); $product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : false;
	if ( ! $product || ! restocommerce_vendor_owns_product( $vendor_id, $product_id ) ) { wp_send_json_error( array( 'message' => __( 'Ce plat n’est pas accessible.', 'restocommerce' ) ), 403 ); }
	$available = ! empty( $_POST['available'] ) && '1' === (string) $_POST['available']; $product->set_stock_status( $available ? 'instock' : 'outofstock' ); $product->save();
	wp_send_json_success( array( 'available' => $available, 'label' => $available ? __( 'Disponible', 'restocommerce' ) : __( 'Indisponible', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_toggle_product', 'restocommerce_ajax_vendor_toggle_product' );

/** Direction « Atelier du Service » : le menu est relu après une publication pour éviter un rechargement de page aveugle. */
function restocommerce_ajax_vendor_menu_data() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$products  = array_map(
		static function( array $product ) : array {
			$product['price'] = wp_strip_all_tags( (string) $product['price'] );
			return $product;
		},
		restocommerce_vendor_products_for_dashboard( $vendor_id )
	);
	wp_send_json_success( array( 'products' => $products ) );
}
add_action( 'wp_ajax_restocommerce_vendor_menu_data', 'restocommerce_ajax_vendor_menu_data' );

function restocommerce_vendor_ajax_guard() : int {
	check_ajax_referer( 'restocommerce_vendor_dashboard', 'nonce' );
	if ( ! is_user_logged_in() || ! function_exists( 'wcfm_is_vendor' ) || ! wcfm_is_vendor() ) {
		wp_send_json_error( array( 'message' => __( 'Cette action est réservée au restaurateur connecté.', 'restocommerce' ) ), 403 );
	}
	return get_current_user_id();
}

/** Direction « Atelier du Service » : préférence explicite du restaurateur, jamais une réinitialisation automatique. */
function restocommerce_ajax_vendor_dismiss_guidance_tour() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	update_user_meta( $vendor_id, 'restocommerce_vendor_guidance_tour_dismissed', 'yes' );
	wp_send_json_success( array( 'dismissed' => true, 'message' => __( 'Le guide ne s’affichera plus automatiquement.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_dismiss_guidance_tour', 'restocommerce_ajax_vendor_dismiss_guidance_tour' );

function restocommerce_ajax_vendor_notifications_data() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$seen      = get_user_meta( $vendor_id, 'restocommerce_vendor_notification_seen', true );
	$seen      = is_array( $seen ) ? $seen : array();
	$records   = array_map( static function( array $record ) use ( $seen ) : array {
		$record['isNew'] = empty( $seen[ $record['id'] ?? '' ] );
		$record['time']  = ! empty( $record['createdAt'] ) ? wp_date( get_option( 'time_format' ), (int) $record['createdAt'] ) : '';
		return $record;
	}, restocommerce_vendor_notification_records( $vendor_id ) );
	wp_send_json_success( array( 'notifications' => $records, 'unreadCount' => count( array_filter( $records, static function( array $record ) : bool { return ! empty( $record['isNew'] ); } ) ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_notifications_data', 'restocommerce_ajax_vendor_notifications_data' );

function restocommerce_ajax_vendor_orders_summary() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$orders    = restocommerce_vendor_orders( $vendor_id );
	$active    = count( array_filter( $orders, static function( array $order ) : bool { return 'completed' !== ( $order['state'] ?? '' ); } ) );
	wp_send_json_success( array( 'activeOrders' => $active, 'totalOrders' => count( $orders ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_orders_summary', 'restocommerce_ajax_vendor_orders_summary' );

function restocommerce_ajax_vendor_mark_notifications_seen() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$ids       = array_values( array_filter( array_map( 'sanitize_key', (array) ( $_POST['notification_ids'] ?? array() ) ) ) );
	$known     = wp_list_pluck( restocommerce_vendor_notification_records( $vendor_id, 1000 ), 'id' );
	$seen      = get_user_meta( $vendor_id, 'restocommerce_vendor_notification_seen', true );
	$seen      = is_array( $seen ) ? $seen : array();
	foreach ( $ids as $id ) { if ( in_array( $id, $known, true ) ) { $seen[ $id ] = time(); } }
	update_user_meta( $vendor_id, 'restocommerce_vendor_notification_seen', $seen );
	wp_send_json_success( array( 'message' => __( 'Les alertes sont marquées comme lues.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_mark_notifications_seen', 'restocommerce_ajax_vendor_mark_notifications_seen' );

function restocommerce_ajax_vendor_notification_preferences() : void {
	$vendor_id   = restocommerce_vendor_ajax_guard();
	$preferences = array( 'sound' => ! empty( $_POST['sound'] ), 'vibration' => ! empty( $_POST['vibration'] ) );
	update_user_meta( $vendor_id, 'restocommerce_vendor_notification_preferences', $preferences );
	wp_send_json_success( array( 'preferences' => $preferences ) );
}
add_action( 'wp_ajax_restocommerce_vendor_notification_preferences', 'restocommerce_ajax_vendor_notification_preferences' );

function restocommerce_ajax_vendor_save_palette() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$palette = sanitize_key( (string) ( $_POST['palette'] ?? '' ) );
	if ( ! array_key_exists( $palette, restocommerce_vendor_palettes() ) ) { wp_send_json_error( array( 'message' => __( 'Cette palette n’est pas disponible.', 'restocommerce' ) ), 422 ); }
	update_user_meta( $vendor_id, 'restocommerce_vendor_palette', $palette );
	wp_send_json_success( array( 'palette' => $palette, 'message' => __( 'Votre ambiance est enregistrée pour les écrans RestoCommerce.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_save_palette', 'restocommerce_ajax_vendor_save_palette' );

function restocommerce_ajax_vendor_reviews_data() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	wp_send_json_success( array( 'records' => restocommerce_vendor_review_records( $vendor_id ), 'summary' => restocommerce_vendor_review_summary( $vendor_id ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_reviews_data', 'restocommerce_ajax_vendor_reviews_data' );

function restocommerce_ajax_vendor_flag_review() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$comment_id = absint( $_POST['comment_id'] ?? 0 );
	$comment = $comment_id ? get_comment( $comment_id ) : null;
	if ( ! $comment || 'restocommerce_vendor_review' !== $comment->comment_type || $vendor_id !== (int) get_comment_meta( $comment_id, 'restocommerce_vendor_review_vendor_id', true ) ) { wp_send_json_error( array( 'message' => __( 'Cet avis ne relève pas de votre restaurant.', 'restocommerce' ) ), 403 ); }
	update_comment_meta( $comment_id, 'restocommerce_vendor_review_flagged', 'yes' );
	update_comment_meta( $comment_id, 'restocommerce_vendor_review_flagged_at', current_time( 'mysql', true ) );
	wp_send_json_success( array( 'message' => __( 'Avis signalé pour modération. Il reste conservé jusqu’à examen.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_flag_review', 'restocommerce_ajax_vendor_flag_review' );

function restocommerce_vendor_product_editor_payload( int $vendor_id, int $product_id = 0 ) : array {
	$payload = array(
		'categories' => restocommerce_vendor_default_dish_categories(),
		'library'    => restocommerce_vendor_menu_library( $vendor_id ),
		'product'    => null,
	);
	if ( ! $product_id || ! restocommerce_vendor_owns_product( $vendor_id, $product_id ) ) { return $payload; }
	$product = wc_get_product( $product_id ); if ( ! $product ) { return $payload; }
	$terms = get_the_terms( $product_id, 'product_cat' );
	$payload['product'] = array(
		'id'            => $product_id,
		'name'          => $product->get_name(),
		'description'   => $product->get_short_description() ?: $product->get_description(),
		'price'         => $product->get_regular_price(),
		'url'           => get_permalink( $product_id ),
		'category'      => ( $terms && ! is_wp_error( $terms ) ) ? sanitize_title( $terms[0]->slug ) : '',
		'categoryLabel' => ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '',
		'optionGroups'  => array_values( get_post_meta( $product_id, 'restocommerce_option_group_ids', true ) ?: array() ),
		'imageUrl'      => get_the_post_thumbnail_url( $product_id, 'medium' ) ?: '',
	);
	return $payload;
}

function restocommerce_ajax_vendor_product_editor_data() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$product_id = absint( $_POST['product_id'] ?? 0 );
	if ( $product_id && ! restocommerce_vendor_owns_product( $vendor_id, $product_id ) ) { wp_send_json_error( array( 'message' => __( 'Ce plat ne vous appartient pas.', 'restocommerce' ) ), 403 ); }
	wp_send_json_success( restocommerce_vendor_product_editor_payload( $vendor_id, $product_id ) );
}
add_action( 'wp_ajax_restocommerce_vendor_product_editor_data', 'restocommerce_ajax_vendor_product_editor_data' );

function restocommerce_vendor_get_or_create_category( string $slug, string $custom_label = '' ) : int {
	$label = $custom_label ? $custom_label : '';
	if ( ! $label ) { foreach ( restocommerce_vendor_default_dish_categories() as $category ) { if ( $slug === $category['slug'] ) { $label = $category['label']; break; } } }
	$label = $label ?: __( 'La carte', 'restocommerce' );
	$term = get_term_by( 'slug', sanitize_title( $slug ?: $label ), 'product_cat' );
	if ( ! $term ) { $created = wp_insert_term( $label, 'product_cat', array( 'slug' => sanitize_title( $slug ?: $label ) ) ); return is_wp_error( $created ) ? 0 : (int) $created['term_id']; }
	return (int) $term->term_id;
}

function restocommerce_vendor_saved_product_payload( int $vendor_id, int $product_id, string $fallback_name = '', string $fallback_price = '' ) : array {
	$product = wc_get_product( $product_id );
	if ( ! $product || ! restocommerce_vendor_owns_product( $vendor_id, $product_id ) ) { return array(); }
	$option_groups = array_values( array_filter( array_map( 'sanitize_key', (array) get_post_meta( $product_id, 'restocommerce_option_group_ids', true ) ) ) );
	return array(
		'product' => array(
			'id'           => $product_id,
			'name'         => $product->get_name() ?: $fallback_name,
			'price'        => wp_strip_all_tags( $product->get_price_html() ) ?: $fallback_price,
			'url'          => get_permalink( $product_id ),
			'optionGroups' => $option_groups,
		),
		'message' => __( 'Le plat est publié. Les clients le voient maintenant sur votre carte.', 'restocommerce' ),
	);
}

function restocommerce_ajax_vendor_save_product() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$product_id = absint( $_POST['product_id'] ?? 0 );
	if ( $product_id && ! restocommerce_vendor_owns_product( $vendor_id, $product_id ) ) { wp_send_json_error( array( 'message' => __( 'Ce plat ne vous appartient pas.', 'restocommerce' ) ), 403 ); }
	$name = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$price = wc_format_decimal( wp_unslash( $_POST['price'] ?? '' ) );
	$description = sanitize_textarea_field( wp_unslash( $_POST['description'] ?? '' ) );
	$category = sanitize_title( wp_unslash( $_POST['category'] ?? '' ) );
	$custom_category = sanitize_text_field( wp_unslash( $_POST['custom_category'] ?? '' ) );
	$source_product_id = absint( $_POST['source_product_id'] ?? 0 );
	$source_image_id = $source_product_id && restocommerce_vendor_owns_product( $vendor_id, $source_product_id ) ? (int) get_post_thumbnail_id( $source_product_id ) : 0;
	if ( ! $name || '' === (string) $price || (float) $price < 0 || ( ! $category && ! $custom_category ) ) { wp_send_json_error( array( 'message' => __( 'Ajoutez le nom, le prix et une catégorie avant de publier.', 'restocommerce' ) ) ); }
	if ( ! $product_id && empty( $_FILES['photo']['name'] ) && ! $source_image_id ) { wp_send_json_error( array( 'message' => __( 'Ajoutez une photo avant de publier ce plat.', 'restocommerce' ) ) ); }
	if ( $product_id && ! get_post_thumbnail_id( $product_id ) && empty( $_FILES['photo']['name'] ) ) { wp_send_json_error( array( 'message' => __( 'Ajoutez une photo avant de publier ce plat.', 'restocommerce' ) ) ); }
	$request_key = sanitize_text_field( wp_unslash( $_POST['request_key'] ?? '' ) );
	$lock_key = $request_key ? '_restocommerce_product_submit_' . substr( hash( 'sha256', $request_key ), 0, 40 ) : '';
	if ( $lock_key ) {
		$existing = (string) get_user_meta( $vendor_id, $lock_key, true );
		if ( ctype_digit( $existing ) ) {
			$existing_payload = restocommerce_vendor_saved_product_payload( $vendor_id, (int) $existing, $name, wc_price( (float) $price ) );
			if ( $existing_payload ) { wp_send_json_success( $existing_payload ); }
		}
		if ( 'pending' === $existing ) { wp_send_json_error( array( 'message' => __( 'La publication est déjà en cours. Patientez quelques secondes.', 'restocommerce' ) ), 409 ); }
		if ( ! $existing && ! add_user_meta( $vendor_id, $lock_key, 'pending', true ) ) { wp_send_json_error( array( 'message' => __( 'La publication est déjà en cours. Patientez quelques secondes.', 'restocommerce' ) ), 409 ); }
		if ( 'retry' === $existing ) { update_user_meta( $vendor_id, $lock_key, 'pending' ); }
	}
	$uploaded_photo_id = 0;
	if ( ! empty( $_FILES['photo']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php'; require_once ABSPATH . 'wp-admin/includes/image.php'; require_once ABSPATH . 'wp-admin/includes/media.php';
		$uploaded_photo_id = media_handle_upload( 'photo', 0 );
		if ( is_wp_error( $uploaded_photo_id ) ) { if ( $lock_key ) { update_user_meta( $vendor_id, $lock_key, 'retry' ); } wp_send_json_error( array( 'message' => __( 'La photo doit être une image lisible. Réessayez avec une autre photo.', 'restocommerce' ) ) ); }
	}
	$term_id = restocommerce_vendor_get_or_create_category( $category, $custom_category );
	if ( ! $term_id ) { if ( $lock_key ) { update_user_meta( $vendor_id, $lock_key, 'retry' ); } wp_send_json_error( array( 'message' => __( 'Cette catégorie ne peut pas être créée.', 'restocommerce' ) ) ); }
	$product = $product_id ? wc_get_product( $product_id ) : new WC_Product_Simple();
	if ( ! $product ) { if ( $lock_key ) { update_user_meta( $vendor_id, $lock_key, 'retry' ); } wp_send_json_error( array( 'message' => __( 'Ce plat ne peut pas être préparé pour le moment.', 'restocommerce' ) ) ); }
	$product->set_name( $name ); $product->set_regular_price( $price ); $product->set_price( $price ); $product->set_description( $description ); $product->set_short_description( $description ); $product->set_status( $product_id ? get_post_status( $product_id ) : 'draft' ); $product->set_catalog_visibility( 'visible' ); $product->set_stock_status( 'instock' );
	$saved_id = $product->save();
	if ( ! $product_id ) { wp_update_post( array( 'ID' => $saved_id, 'post_author' => $vendor_id ) ); }
	wp_set_object_terms( $saved_id, array( $term_id ), 'product_cat', false );
		$raw_groups = $_POST['option_groups'] ?? array();
		if ( is_string( $raw_groups ) ) { $raw_groups = json_decode( wp_unslash( $raw_groups ), true ); }
		$raw_groups = is_array( $raw_groups ) ? $raw_groups : array();
	$valid_groups = array(); foreach ( restocommerce_vendor_option_groups( $vendor_id ) as $group ) { if ( ! empty( $group['id'] ) && in_array( (string) $group['id'], array_map( 'strval', $raw_groups ), true ) ) { $valid_groups[] = (string) $group['id']; } }
	update_post_meta( $saved_id, 'restocommerce_option_group_ids', $valid_groups );
	if ( $uploaded_photo_id ) {
		wp_update_post( array( 'ID' => $uploaded_photo_id, 'post_parent' => $saved_id ) );
		set_post_thumbnail( $saved_id, $uploaded_photo_id );
	} elseif ( ! $product_id && $source_image_id ) {
		set_post_thumbnail( $saved_id, $source_image_id );
	}
	$product = wc_get_product( $saved_id ); if ( $product ) { $product->set_status( 'publish' ); $product->save(); }
	if ( $lock_key ) { update_user_meta( $vendor_id, $lock_key, (string) $saved_id ); }
	wp_send_json_success( restocommerce_vendor_saved_product_payload( $vendor_id, $saved_id, $name, wc_price( (float) $price ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_save_product', 'restocommerce_ajax_vendor_save_product' );

function restocommerce_ajax_vendor_save_option_group() : void {
	$vendor_id = restocommerce_vendor_ajax_guard();
	$group_id = sanitize_key( wp_unslash( $_POST['group_id'] ?? '' ) ); $title = sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) );
	$choices = array_values( array_filter( array_map( 'sanitize_text_field', (array) json_decode( wp_unslash( $_POST['choices'] ?? '[]' ), true ) ) ) );
	$required = ! empty( $_POST['required'] ) && '1' === (string) $_POST['required']; $max = sanitize_text_field( wp_unslash( $_POST['max_choices'] ?? 'unlimited' ) );
	if ( ! $title || count( $choices ) < 2 || ( 'unlimited' !== $max && (int) $max < 1 ) ) { wp_send_json_error( array( 'message' => __( 'Donnez un nom et au moins deux choix simples à cette option.', 'restocommerce' ) ) ); }
	$max = 'unlimited' === $max ? 'unlimited' : min( 3, (string) absint( $max ) );
	$groups = restocommerce_vendor_option_groups( $vendor_id ); $group_id = $group_id ?: 'option-' . wp_generate_password( 8, false, false );
	$next = array( 'id' => $group_id, 'title' => $title, 'choices' => $choices, 'required' => $required, 'max' => $max, 'enabled' => true ); $found = false;
	foreach ( $groups as $index => $group ) { if ( $group_id === (string) ( $group['id'] ?? '' ) ) { $groups[ $index ] = $next; $found = true; break; } }
	if ( ! $found ) { $groups[] = $next; }
	restocommerce_vendor_save_option_groups( $vendor_id, $groups ); wp_send_json_success( array( 'group' => $next, 'message' => __( 'Cette option est prête à être proposée.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_save_option_group', 'restocommerce_ajax_vendor_save_option_group' );

function restocommerce_ajax_vendor_toggle_menu_library() : void {
	$vendor_id = restocommerce_vendor_ajax_guard(); $kind = sanitize_key( wp_unslash( $_POST['kind'] ?? '' ) ); $id = sanitize_text_field( wp_unslash( $_POST['id'] ?? '' ) ); $enabled = ! empty( $_POST['enabled'] ) && '1' === (string) $_POST['enabled'];
	if ( 'category' === $kind && absint( $id ) ) { update_user_meta( $vendor_id, 'restocommerce_category_' . absint( $id ) . '_enabled', $enabled ? 'yes' : 'no' ); wp_send_json_success( array( 'enabled' => $enabled, 'message' => $enabled ? __( 'Cette catégorie est visible.', 'restocommerce' ) : __( 'Cette catégorie est en pause.', 'restocommerce' ) ) ); }
	if ( 'option' === $kind && $id ) { $groups = restocommerce_vendor_option_groups( $vendor_id ); foreach ( $groups as $index => $group ) { if ( $id === (string) ( $group['id'] ?? '' ) ) { $groups[ $index ]['enabled'] = $enabled; restocommerce_vendor_save_option_groups( $vendor_id, $groups ); wp_send_json_success( array( 'enabled' => $enabled, 'message' => $enabled ? __( 'Cette option est disponible.', 'restocommerce' ) : __( 'Cette option est en pause.', 'restocommerce' ) ) ); } } }
	wp_send_json_error( array( 'message' => __( 'Cette mise à jour ne peut pas être enregistrée.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_toggle_menu_library', 'restocommerce_ajax_vendor_toggle_menu_library' );

function restocommerce_ajax_vendor_archive_product() : void {
	$vendor_id = restocommerce_vendor_ajax_guard(); $product_id = absint( $_POST['product_id'] ?? 0 ); $product = wc_get_product( $product_id );
	if ( ! $product || ! restocommerce_vendor_owns_product( $vendor_id, $product_id ) ) { wp_send_json_error( array( 'message' => __( 'Ce plat n’est pas accessible.', 'restocommerce' ) ), 403 ); }
	$product->set_status( 'draft' ); $product->set_catalog_visibility( 'hidden' ); $product->set_stock_status( 'outofstock' ); $product->save();
	wp_send_json_success( array( 'message' => __( 'Le plat de recette est archivé.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_vendor_archive_product', 'restocommerce_ajax_vendor_archive_product' );

add_filter( 'woocommerce_is_purchasable', function( bool $purchasable, WC_Product $product ) : bool {
	$vendor_id = (int) get_post_field( 'post_author', $product->get_id() );
	return restocommerce_vendor_service_is_paused( $vendor_id ) ? false : $purchasable;
}, 20, 2 );
add_filter( 'wp_resource_hints', function( array $urls, string $relation_type ) : array { if ( 'preconnect' === $relation_type ) { $urls[] = array( 'href' => 'https://fonts.googleapis.com' ); $urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' ); } return $urls; }, 10, 2 );

function restocommerce_cart_summary() : string {
	$count = restocommerce_cart_count();
	return $count ? sprintf( _n( '%d article prêt à commander', '%d articles prêts à commander', $count, 'restocommerce' ), $count ) : __( 'Le panier est encore vide.', 'restocommerce' );
}

function restocommerce_render_cart_drawer() : string {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) { return ''; }
	$items = WC()->cart->get_cart();
	ob_start();
	?>
	<div class="rc-cart-drawer-content">
		<div class="rc-cart-drawer-lines">
			<?php if ( empty( $items ) ) : ?>
				<div class="rc-cart-empty-state"><span aria-hidden="true">⌁</span><b><?php esc_html_e( 'À votre appétit.', 'restocommerce' ); ?></b><p><?php esc_html_e( 'Ajoutez un plat depuis le menu pour commencer.', 'restocommerce' ); ?></p></div>
			<?php else : foreach ( $items as $cart_item_key => $cart_item ) : ?>
				<?php $product = $cart_item['data'] ?? null; if ( ! $product instanceof WC_Product || ! $product->exists() ) { continue; } $quantity = max( 1, (int) ( $cart_item['quantity'] ?? 1 ) ); $image_id = $product->get_image_id(); if ( ! $image_id && $product->is_type( 'variation' ) ) { $parent = wc_get_product( $product->get_parent_id() ); $image_id = $parent ? $parent->get_image_id() : 0; } $image = wp_get_attachment_image( $image_id, 'woocommerce_thumbnail', false, array( 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ) ); ?>
				<article class="rc-cart-line"><div class="rc-cart-line-media"><?php echo $image ? wp_kses_post( $image ) : wc_placeholder_img(); ?></div><div class="rc-cart-line-copy"><div><h3><?php echo esc_html( $product->get_name() ); ?></h3><strong><?php echo wp_kses_post( WC()->cart->get_product_subtotal( $product, $quantity ) ); ?></strong></div><p><?php echo esc_html( sprintf( _n( '%d portion', '%d portions', $quantity, 'restocommerce' ), $quantity ) ); ?></p></div><a class="rc-cart-line-remove" href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Retirer %s du panier', 'restocommerce' ), $product->get_name() ) ); ?>">×</a></article>
			<?php endforeach; endif; ?>
		</div>
		<footer class="rc-cart-drawer-footer"><div class="rc-cart-total"><span><?php esc_html_e( 'Sous-total estimé', 'restocommerce' ); ?></span><strong><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></strong></div><p><?php esc_html_e( 'La commande sera récapitulée dans WhatsApp. Vous confirmerez ensuite avec le restaurant.', 'restocommerce' ); ?></p><a class="rc-cart-checkout" href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php esc_html_e( 'Finaliser sur WhatsApp', 'restocommerce' ); ?><span aria-hidden="true">→</span></a></footer>
	</div>
	<?php
	return (string) ob_get_clean();
}

function restocommerce_cart_fragments( array $fragments ) : array {
	ob_start(); ?><span data-rc-cart-count><?php echo esc_html( restocommerce_cart_count() ); ?></span><?php $fragments['span[data-rc-cart-count]'] = ob_get_clean();
	ob_start(); ?><span data-rc-cart-summary><?php echo esc_html( restocommerce_cart_summary() ); ?></span><?php $fragments['span[data-rc-cart-summary]'] = ob_get_clean();
	$fragments['div[data-rc-mini-cart]'] = '<div class="rc-cart-drawer-body" data-rc-mini-cart>' . restocommerce_render_cart_drawer() . '</div>';
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'restocommerce_cart_fragments' );

function restocommerce_quick_view_button() : void {
	global $product; if ( ! $product instanceof WC_Product ) { return; }
	printf( '<button class="rc-quick-view-trigger" type="button" data-rc-quick-product="%d">%s</button>', (int) $product->get_id(), esc_html__( 'Aperçu rapide', 'restocommerce' ) );
}
add_action( 'woocommerce_after_shop_loop_item', 'restocommerce_quick_view_button', 7 );

function restocommerce_render_product_configurator( WC_Product $product, string $context = 'quick' ) : string {
	$attributes     = $product->is_type( 'variable' ) ? $product->get_variation_attributes() : array();
	$variations     = $product->is_type( 'variable' ) ? $product->get_available_variations() : array();
	$variation_data = array_map( function( array $variation ) : array {
		return array( 'id' => absint( $variation['variation_id'] ?? 0 ), 'attributes' => (array) ( $variation['attributes'] ?? array() ), 'price' => wp_strip_all_tags( (string) ( $variation['price_html'] ?? '' ) ) );
	}, $variations );
	$custom_groups  = restocommerce_vendor_product_option_groups( $product->get_id(), true );
	$needs_options  = ! empty( $attributes ) || (bool) array_filter( $custom_groups, static fn( $group ) => ! empty( $group['required'] ) );
	$image          = wp_get_attachment_image( $product->get_image_id(), 'woocommerce_single', false, array( 'alt' => '' ) );
	$price_text     = wp_strip_all_tags( $product->get_price_html() );

	ob_start();
	if ( 'quick' === $context ) : ?>
		<article class="rc-quick-product rc-quick-product--config">
			<div class="rc-quick-product-media"><?php echo $image ? wp_kses_post( $image ) : wc_placeholder_img(); ?></div>
			<div class="rc-quick-product-details">
				<p class="rc-eyebrow"><?php esc_html_e( 'À la carte', 'restocommerce' ); ?></p><h2><?php echo esc_html( $product->get_name() ); ?></h2>
				<div class="price" data-rc-quick-price><?php echo wp_kses_post( $product->get_price_html() ); ?></div><p><?php echo wp_kses_post( wp_trim_words( $product->get_short_description() ?: $product->get_description(), 24 ) ); ?></p>
	<?php endif; ?>
		<form class="rc-quick-order-form<?php echo 'inline' === $context ? ' rc-inline-product-configurator' : ''; ?>" data-rc-quick-order-form data-rc-base-price="<?php echo esc_attr( $price_text ); ?>"<?php if ( $variation_data ) : ?> data-rc-variations="<?php echo esc_attr( wp_json_encode( $variation_data ) ); ?>"<?php endif; ?>>
			<input type="hidden" name="product_id" value="<?php echo esc_attr( (string) $product->get_id() ); ?>"><input type="hidden" name="variation_id" value="0" data-rc-variation-id>
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<?php $attribute_field_name = 0 === strpos( $attribute_name, 'attribute_' ) ? $attribute_name : 'attribute_' . sanitize_title( $attribute_name ); $attribute_label = wc_attribute_label( str_replace( 'attribute_', '', $attribute_name ) ); ?>
				<fieldset class="rc-quick-option-set" data-rc-option-set><legend><?php echo esc_html( $attribute_label ); ?><span><?php esc_html_e( 'Obligatoire', 'restocommerce' ); ?></span></legend><div class="rc-quick-option-grid">
					<?php foreach ( $options as $option ) : ?><?php $option_id = wp_unique_id( 'rc-quick-option-' ); ?><input id="<?php echo esc_attr( $option_id ); ?>" type="radio" name="<?php echo esc_attr( $attribute_field_name ); ?>" value="<?php echo esc_attr( $option ); ?>" required><label for="<?php echo esc_attr( $option_id ); ?>"><span></span><?php echo esc_html( $option ); ?></label><?php endforeach; ?>
				</div></fieldset>
			<?php endforeach; ?>
			<?php foreach ( $custom_groups as $group ) : ?>
				<?php $group_id = sanitize_key( (string) ( $group['id'] ?? '' ) ); $group_title = (string) ( $group['title'] ?? __( 'Vos choix', 'restocommerce' ) ); $max_choices = (string) ( $group['max'] ?? 'unlimited' ); $group_choices = array_values( array_filter( (array) ( $group['choices'] ?? array() ) ) ); if ( ! $group_id || ! $group_choices ) { continue; } ?>
				<fieldset class="rc-quick-option-set rc-quick-option-set--multi" data-rc-extra-option-set data-rc-extra-required="<?php echo ! empty( $group['required'] ) ? '1' : '0'; ?>" data-rc-extra-max="<?php echo esc_attr( $max_choices ); ?>"><legend><?php echo esc_html( $group_title ); ?><span><?php echo esc_html( ! empty( $group['required'] ) ? __( 'Obligatoire', 'restocommerce' ) : __( 'Facultatif', 'restocommerce' ) ); ?><?php echo 'unlimited' !== $max_choices ? ' · ' . sprintf( __( '%s choix maximum', 'restocommerce' ), $max_choices ) : ''; ?></span></legend><div class="rc-quick-option-grid">
					<?php foreach ( $group_choices as $choice ) : ?><?php $choice_id = wp_unique_id( 'rc-extra-option-' ); ?><input id="<?php echo esc_attr( $choice_id ); ?>" type="checkbox" name="rc_option_<?php echo esc_attr( $group_id ); ?>[]" value="<?php echo esc_attr( $choice ); ?>"><label for="<?php echo esc_attr( $choice_id ); ?>"><span></span><?php echo esc_html( $choice ); ?></label><?php endforeach; ?>
				</div></fieldset>
			<?php endforeach; ?>
			<?php $quantity_id = wp_unique_id( 'rc-quick-quantity-' ); ?><div class="rc-quick-quantity-row"><label for="<?php echo esc_attr( $quantity_id ); ?>"><?php esc_html_e( 'Quantité', 'restocommerce' ); ?></label><input id="<?php echo esc_attr( $quantity_id ); ?>" type="number" name="quantity" min="1" value="1"></div>
			<label class="rc-quick-note"><span><?php esc_html_e( 'Une demande pour la cuisine', 'restocommerce' ); ?><small><?php esc_html_e( 'facultatif', 'restocommerce' ); ?></small></span><textarea name="restocommerce_note" rows="2" maxlength="240" placeholder="<?php esc_attr_e( 'Ex. sans oignons, sauce à part…', 'restocommerce' ); ?>"></textarea></label>
			<div class="rc-quick-conditions"><label><input type="checkbox" name="rc_menu_confirmation" value="1" required><span></span><b><?php esc_html_e( 'Je vérifie mes choix avant de commander.', 'restocommerce' ); ?></b></label><p><?php esc_html_e( 'Les demandes particulières sont transmises à la cuisine et restent soumises à sa disponibilité. Pour toute allergie, contactez également le restaurant.', 'restocommerce' ); ?></p></div>
			<p class="rc-quick-form-status" data-rc-quick-status role="status" aria-live="polite"></p>
			<button class="rc-solid-button rc-quick-add-button" type="submit" data-rc-quick-submit<?php if ( $needs_options ) : ?> disabled<?php endif; ?>><span data-rc-quick-add-label><?php echo esc_html( $needs_options ? __( 'Choisissez vos options', 'restocommerce' ) : __( 'Ajouter au panier', 'restocommerce' ) ); ?></span><strong data-rc-quick-add-price><?php echo esc_html( $needs_options ? '' : $price_text ); ?></strong></button>
		</form>
	<?php if ( 'quick' === $context ) : ?></div></article><?php endif;
	return (string) ob_get_clean();
}

function restocommerce_ajax_quick_view() : void {
	check_ajax_referer( 'restocommerce_quick_view', 'nonce' );
	$product = wc_get_product( absint( $_POST['product_id'] ?? 0 ) );
	if ( ! $product || ! $product->is_purchasable() ) { wp_send_json_error( array( 'message' => __( 'Ce plat n’est pas disponible actuellement.', 'restocommerce' ) ) ); }
	wp_send_json_success( array( 'html' => restocommerce_render_product_configurator( $product ) ) );
}
add_action( 'wp_ajax_restocommerce_quick_view', 'restocommerce_ajax_quick_view' ); add_action( 'wp_ajax_nopriv_restocommerce_quick_view', 'restocommerce_ajax_quick_view' );

function restocommerce_ajax_quick_add_to_cart() : void {
	check_ajax_referer( 'restocommerce_quick_view', 'nonce' );
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) { wc_load_cart(); }
	$product_id = absint( $_POST['product_id'] ?? 0 );
	$quantity = max( 1, absint( $_POST['quantity'] ?? 1 ) );
	$product = wc_get_product( $product_id );
	if ( ! $product || ! $product->is_purchasable() ) { wp_send_json_error( array( 'message' => __( 'Ce plat n’est plus disponible.', 'restocommerce' ) ) ); }
	$vendor_id = (int) get_post_field( 'post_author', $product_id );
	$terms = get_the_terms( $product_id, 'product_cat' );
	if ( $terms && ! is_wp_error( $terms ) ) { foreach ( $terms as $term ) { if ( ! restocommerce_vendor_category_is_enabled( $vendor_id, (int) $term->term_id ) ) { wp_send_json_error( array( 'message' => __( 'Cette famille de plats est momentanément en pause.', 'restocommerce' ) ) ); } } }

	$variation_id = 0;
	$variation_attributes = array();
	if ( $product->is_type( 'variable' ) ) {
		$variation_id = absint( $_POST['variation_id'] ?? 0 );
		$variation = wc_get_product( $variation_id );
		if ( ! $variation || $variation->get_parent_id() !== $product_id || ! $variation->is_purchasable() ) { wp_send_json_error( array( 'message' => __( 'Choisissez une option disponible avant d’ajouter ce plat.', 'restocommerce' ) ) ); }
		foreach ( $product->get_variation_attributes() as $attribute_name => $options ) {
			$attribute_field_name = 0 === strpos( $attribute_name, 'attribute_' ) ? $attribute_name : 'attribute_' . sanitize_title( $attribute_name );
			$value = wc_clean( wp_unslash( $_POST[ $attribute_field_name ] ?? '' ) );
			if ( '' === $value || ! in_array( $value, $options, true ) ) { wp_send_json_error( array( 'message' => __( 'Veuillez compléter toutes les options obligatoires.', 'restocommerce' ) ) ); }
			$variation_attributes[ $attribute_field_name ] = $value;
		}
	}
	$choice_data = array();
	foreach ( restocommerce_vendor_product_option_groups( $product_id, true ) as $group ) {
		$group_id = sanitize_key( (string) ( $group['id'] ?? '' ) ); if ( ! $group_id ) { continue; }
		$field = 'rc_option_' . $group_id; $selected = array_values( array_unique( array_filter( array_map( 'wc_clean', (array) ( $_POST[ $field ] ?? array() ) ) ) ) ); $choices = array_values( array_filter( (array) ( $group['choices'] ?? array() ) ) ); $max = (string) ( $group['max'] ?? 'unlimited' );
		if ( ! empty( $group['required'] ) && ! $selected ) { wp_send_json_error( array( 'message' => sprintf( __( 'Choisissez au moins une option pour %s.', 'restocommerce' ), $group['title'] ?? __( 'ce choix', 'restocommerce' ) ) ) ); }
		if ( array_diff( $selected, $choices ) || ( 'unlimited' !== $max && count( $selected ) > (int) $max ) ) { wp_send_json_error( array( 'message' => sprintf( __( 'Respectez le nombre de choix pour %s.', 'restocommerce' ), $group['title'] ?? __( 'ce choix', 'restocommerce' ) ) ) ); }
		if ( $selected ) { $choice_data[ (string) ( $group['title'] ?? __( 'Options', 'restocommerce' ) ) ] = $selected; }
	}

	$cart_item_data = array();
	$note = sanitize_textarea_field( wp_unslash( $_POST['restocommerce_note'] ?? '' ) );
	if ( $note ) { $cart_item_data['restocommerce_note'] = $note; $cart_item_data['restocommerce_note_key'] = wp_generate_uuid4(); }
	if ( $choice_data ) { $cart_item_data['restocommerce_choices'] = $choice_data; $cart_item_data['restocommerce_choices_key'] = wp_generate_uuid4(); }
	$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation_attributes, $cart_item_data );
	if ( ! $cart_item_key ) { wp_send_json_error( array( 'message' => __( 'Impossible d’ajouter ce plat au panier.', 'restocommerce' ) ) ); }

	$mini_cart = restocommerce_render_cart_drawer();
	wp_send_json_success( array( 'count' => restocommerce_cart_count(), 'mini_cart' => $mini_cart, 'message' => __( 'Plat ajouté au panier.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_quick_add_to_cart', 'restocommerce_ajax_quick_add_to_cart' ); add_action( 'wp_ajax_nopriv_restocommerce_quick_add_to_cart', 'restocommerce_ajax_quick_add_to_cart' );

function restocommerce_ajax_cart_drawer() : void {
	check_ajax_referer( 'restocommerce_quick_view', 'nonce' );
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) { wc_load_cart(); }
	wp_send_json_success( array( 'count' => restocommerce_cart_count(), 'summary' => restocommerce_cart_summary(), 'html' => restocommerce_render_cart_drawer() ) );
}
add_action( 'wp_ajax_restocommerce_cart_drawer', 'restocommerce_ajax_cart_drawer' ); add_action( 'wp_ajax_nopriv_restocommerce_cart_drawer', 'restocommerce_ajax_cart_drawer' );

add_filter( 'woocommerce_get_item_data', function( array $item_data, array $cart_item ) : array {
	if ( ! empty( $cart_item['restocommerce_note'] ) ) { $item_data[] = array( 'key' => __( 'Note cuisine', 'restocommerce' ), 'value' => esc_html( $cart_item['restocommerce_note'] ) ); }
	if ( ! empty( $cart_item['restocommerce_choices'] ) && is_array( $cart_item['restocommerce_choices'] ) ) { foreach ( $cart_item['restocommerce_choices'] as $label => $choices ) { $item_data[] = array( 'key' => esc_html( $label ), 'value' => esc_html( implode( ', ', (array) $choices ) ) ); } }
	return $item_data;
}, 10, 2 );

add_action( 'woocommerce_checkout_create_order_line_item', function( WC_Order_Item_Product $item, string $cart_item_key, array $values ) : void {
	if ( ! empty( $values['restocommerce_note'] ) ) { $item->add_meta_data( __( 'Note cuisine', 'restocommerce' ), sanitize_textarea_field( $values['restocommerce_note'] ), true ); }
	if ( ! empty( $values['restocommerce_choices'] ) && is_array( $values['restocommerce_choices'] ) ) { foreach ( $values['restocommerce_choices'] as $label => $choices ) { $item->add_meta_data( sanitize_text_field( $label ), implode( ', ', array_map( 'sanitize_text_field', (array) $choices ) ), true ); } }
}, 10, 3 );

/** Direction « Atelier du Service » : suivi public limité à la page de reçu WooCommerce et à sa clé de commande, sans nouveau jeton réutilisable. */
function restocommerce_order_tracking_has_valid_key( WC_Order $order ) : bool {
	$provided_key = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : '';
	return $provided_key && hash_equals( $order->get_order_key(), (string) $provided_key );
}

function restocommerce_order_tracking_steps( string $state, string $order_status ) : array {
	$steps = array(
		'confirm'   => __( 'Reçue', 'restocommerce' ),
		'cooking'   => __( 'En préparation', 'restocommerce' ),
		'ready'     => __( 'Prête', 'restocommerce' ),
		'completed' => __( 'Récupérée / livrée', 'restocommerce' ),
	);
	if ( in_array( $order_status, array( 'cancelled', 'failed', 'refunded' ), true ) ) {
		return array( 'closed' => __( 'Commande clôturée', 'restocommerce' ) );
	}
	$current_index = array_search( $state, array_keys( $steps ), true );
	$current_index = false === $current_index ? 0 : $current_index;
	$rows = array(); $index = 0;
	foreach ( $steps as $key => $label ) { $rows[] = array( 'key' => $key, 'label' => $label, 'active' => $index <= $current_index, 'current' => $index === $current_index ); ++$index; }
	return $rows;
}

function restocommerce_order_tracking_whatsapp_url( WC_Order $order ) : string {
	if ( ! function_exists( 'restocommerce_order_whatsapp_number' ) ) { return ''; }
	$number = restocommerce_order_whatsapp_number( $order );
	if ( ! $number ) { return ''; }
	$message = sprintf( __( 'Bonjour, je consulte le suivi de ma commande #%1$s. Pouvez-vous m’aider si besoin ?', 'restocommerce' ), $order->get_order_number() );
	return 'https://wa.me/' . rawurlencode( $number ) . '?text=' . rawurlencode( $message );
}

function restocommerce_render_order_tracking( $order_id ) : void {
	$order = function_exists( 'wc_get_order' ) ? wc_get_order( $order_id ) : false;
	if ( ! $order instanceof WC_Order || ! restocommerce_order_tracking_has_valid_key( $order ) ) { return; }
	$vendor_ids = restocommerce_vendor_order_vendor_ids( $order );
	if ( ! $vendor_ids ) { return; }
	$whatsapp_url = restocommerce_order_tracking_whatsapp_url( $order );
	?>
	<section class="rc-order-tracking" aria-labelledby="rc-order-tracking-title">
		<header><p><?php esc_html_e( 'Suivi de commande', 'restocommerce' ); ?></p><h2 id="rc-order-tracking-title"><?php esc_html_e( 'La cuisine vous tient au courant.', 'restocommerce' ); ?></h2><span><?php echo esc_html( sprintf( __( 'Commande #%s', 'restocommerce' ), $order->get_order_number() ) ); ?></span></header>
		<?php foreach ( $vendor_ids as $vendor_id ) : $state = restocommerce_vendor_order_state( $order, $vendor_id ); $steps = restocommerce_order_tracking_steps( $state, $order->get_status() ); ?>
			<article class="rc-order-tracking-card"><h3><?php echo esc_html( restocommerce_vendor_store_name( $vendor_id ) ); ?></h3><ol class="rc-order-tracking-steps">
				<?php foreach ( $steps as $step ) : ?><li class="<?php echo ! empty( $step['active'] ) ? 'is-active' : ''; ?> <?php echo ! empty( $step['current'] ) ? 'is-current' : ''; ?>"><i aria-hidden="true"></i><span><?php echo esc_html( $step['label'] ); ?></span><?php if ( ! empty( $step['current'] ) ) : ?><b class="screen-reader-text"><?php esc_html_e( 'Étape actuelle', 'restocommerce' ); ?></b><?php endif; ?></li><?php endforeach; ?>
			</ol></article>
		<?php endforeach; ?>
		<?php if ( $whatsapp_url ) : ?><a class="rc-order-tracking-whatsapp" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Question sur ma commande via WhatsApp', 'restocommerce' ); ?> →</a><?php else : ?><p class="rc-order-tracking-note"><?php esc_html_e( 'Le contact WhatsApp du restaurant n’est pas configuré. Consultez les étapes ci-dessus ou contactez la maison par son canal habituel.', 'restocommerce' ); ?></p><?php endif; ?>
	</section>
	<?php
}
add_action( 'woocommerce_thankyou', 'restocommerce_render_order_tracking', 25 );

/** Direction « Atelier du Service » : seuls les clients disposant du reçu d’une commande terminée peuvent déposer un avis, une fois par restaurant. */
function restocommerce_vendor_review_records( int $vendor_id, int $limit = 80 ) : array {
	$comments = get_comments( array( 'type' => 'restocommerce_vendor_review', 'status' => 'approve', 'number' => $limit, 'orderby' => 'comment_date_gmt', 'order' => 'DESC', 'meta_key' => 'restocommerce_vendor_review_vendor_id', 'meta_value' => $vendor_id ) );
	$rows = array();
	foreach ( $comments as $comment ) {
		$rating = (int) get_comment_meta( $comment->comment_ID, 'restocommerce_vendor_review_rating', true );
		if ( $rating < 1 || $rating > 5 ) { continue; }
		$rows[] = array( 'id' => (int) $comment->comment_ID, 'rating' => $rating, 'content' => $comment->comment_content, 'date' => get_comment_date( get_option( 'date_format' ), $comment ), 'flagged' => 'yes' === get_comment_meta( $comment->comment_ID, 'restocommerce_vendor_review_flagged', true ) );
	}
	return $rows;
}

function restocommerce_vendor_review_summary( int $vendor_id ) : array {
	$records = restocommerce_vendor_review_records( $vendor_id );
	$ratings = array_column( $records, 'rating' );
	return array( 'count' => count( $ratings ), 'average' => $ratings ? round( array_sum( $ratings ) / count( $ratings ), 1 ) : 0.0 );
}

function restocommerce_vendor_order_has_review( WC_Order $order, int $vendor_id ) : bool {
	$comments = get_comments( array( 'type' => 'restocommerce_vendor_review', 'status' => 'all', 'post_id' => $order->get_id(), 'number' => 1, 'meta_key' => 'restocommerce_vendor_review_vendor_id', 'meta_value' => $vendor_id, 'fields' => 'ids' ) );
	return ! empty( $comments );
}

function restocommerce_ajax_submit_vendor_review() : void {
	check_ajax_referer( 'restocommerce_vendor_review', 'nonce' );
	$order = function_exists( 'wc_get_order' ) ? wc_get_order( absint( $_POST['order_id'] ?? 0 ) ) : false;
	$key = isset( $_POST['order_key'] ) ? wc_clean( wp_unslash( $_POST['order_key'] ) ) : '';
	$vendor_id = absint( $_POST['vendor_id'] ?? 0 );
	$rating = absint( $_POST['rating'] ?? 0 );
	$content = sanitize_textarea_field( wp_unslash( $_POST['content'] ?? '' ) );
	if ( ! $order instanceof WC_Order || ! $key || ! hash_equals( $order->get_order_key(), $key ) || 'completed' !== $order->get_status() || ! in_array( $vendor_id, restocommerce_vendor_order_vendor_ids( $order ), true ) ) { wp_send_json_error( array( 'message' => __( 'Cet avis ne peut pas être associé à cette commande.', 'restocommerce' ) ), 403 ); }
	if ( restocommerce_vendor_order_has_review( $order, $vendor_id ) ) { wp_send_json_error( array( 'message' => __( 'Un avis a déjà été enregistré pour ce restaurant et cette commande.', 'restocommerce' ) ), 409 ); }
	if ( $rating < 1 || $rating > 5 || '' === $content ) { wp_send_json_error( array( 'message' => __( 'Choisissez une note et écrivez votre retour.', 'restocommerce' ) ), 422 ); }
	$comment_id = wp_insert_comment( array( 'comment_post_ID' => $order->get_id(), 'comment_content' => $content, 'comment_type' => 'restocommerce_vendor_review', 'comment_approved' => 1, 'comment_author' => __( 'Client vérifié', 'restocommerce' ), 'user_id' => get_current_user_id() ) );
	if ( ! $comment_id ) { wp_send_json_error( array( 'message' => __( 'Votre avis ne peut pas être enregistré pour le moment.', 'restocommerce' ) ), 500 ); }
	update_comment_meta( $comment_id, 'restocommerce_vendor_review_vendor_id', $vendor_id );
	update_comment_meta( $comment_id, 'restocommerce_vendor_review_order_id', $order->get_id() );
	update_comment_meta( $comment_id, 'restocommerce_vendor_review_rating', $rating );
	update_comment_meta( $comment_id, 'restocommerce_vendor_review_verified', 'yes' );
	wp_send_json_success( array( 'message' => __( 'Merci. Votre avis vérifié a été publié.', 'restocommerce' ) ) );
}
add_action( 'wp_ajax_restocommerce_submit_vendor_review', 'restocommerce_ajax_submit_vendor_review' );
add_action( 'wp_ajax_nopriv_restocommerce_submit_vendor_review', 'restocommerce_ajax_submit_vendor_review' );

function restocommerce_render_vendor_review_form( $order_id ) : void {
	$order = function_exists( 'wc_get_order' ) ? wc_get_order( $order_id ) : false;
	if ( ! $order instanceof WC_Order || ! restocommerce_order_tracking_has_valid_key( $order ) || 'completed' !== $order->get_status() ) { return; }
	$vendor_ids = array_filter( restocommerce_vendor_order_vendor_ids( $order ), static function( int $vendor_id ) use ( $order ) : bool { return ! restocommerce_vendor_order_has_review( $order, $vendor_id ); } );
	if ( ! $vendor_ids ) { return; }
	?>
	<section class="rc-order-review" aria-labelledby="rc-order-review-title"><header><p><?php esc_html_e( 'Votre retour', 'restocommerce' ); ?></p><h2 id="rc-order-review-title"><?php esc_html_e( 'Comment était votre expérience ?', 'restocommerce' ); ?></h2><span><?php esc_html_e( 'Votre avis est lié à cette commande terminée.', 'restocommerce' ); ?></span></header><?php foreach ( $vendor_ids as $vendor_id ) : ?><form data-rc-vendor-review><input type="hidden" name="order_id" value="<?php echo esc_attr( (string) $order->get_id() ); ?>"><input type="hidden" name="order_key" value="<?php echo esc_attr( $order->get_order_key() ); ?>"><input type="hidden" name="vendor_id" value="<?php echo esc_attr( (string) $vendor_id ); ?>"><h3><?php echo esc_html( restocommerce_vendor_store_name( $vendor_id ) ); ?></h3><fieldset><legend><?php esc_html_e( 'Votre note', 'restocommerce' ); ?></legend><div class="rc-order-review-rating"><?php for ( $rating = 5; $rating >= 1; --$rating ) : ?><label><input type="radio" name="rating" value="<?php echo esc_attr( (string) $rating ); ?>"> <span><?php echo esc_html( sprintf( _n( '%d étoile', '%d étoiles', $rating, 'restocommerce' ), $rating ) ); ?></span></label><?php endfor; ?></div></fieldset><label class="rc-order-review-copy"><span><?php esc_html_e( 'Votre retour', 'restocommerce' ); ?></span><textarea name="content" rows="4" maxlength="1200" required></textarea></label><button type="submit"><?php esc_html_e( 'Publier mon avis vérifié', 'restocommerce' ); ?></button><p data-rc-review-feedback role="status" aria-live="polite"></p></form><?php endforeach; ?></section>
	<?php
}
add_action( 'woocommerce_thankyou', 'restocommerce_render_vendor_review_form', 30 );

function restocommerce_preload_lcp_image() : void { if ( ! is_front_page() || ! has_post_thumbnail( get_queried_object_id() ) ) { return; } $image = wp_get_attachment_image_url( get_post_thumbnail_id( get_queried_object_id() ), 'full' ); if ( $image ) { printf( "<link rel='preload' as='image' href='%s' fetchpriority='high'>\n", esc_url( $image ) ); } }
add_action( 'wp_head', 'restocommerce_preload_lcp_image', 1 );
function restocommerce_restaurant_schema() : void { if ( ! is_front_page() ) { return; } printf( "<script type='application/ld+json'>%s</script>\n", wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'Restaurant', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) ); }
add_action( 'wp_head', 'restocommerce_restaurant_schema', 20 );
function restocommerce_dynamic_urls() : array { return class_exists( 'WooCommerce' ) ? array_filter( array( wc_get_cart_url(), wc_get_checkout_url(), wc_get_page_permalink( 'myaccount' ) ) ) : array(); }

function restocommerce_store_slug_from_request() : string {
	$path = trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );
	$parts = explode( '/', $path );
	return ( isset( $parts[0], $parts[1] ) && in_array( $parts[0], array( 'restaurant', 'store' ), true ) ) ? sanitize_title( $parts[1] ) : '';
}
function restocommerce_store_request_uses_legacy_wcfm_route() : bool {
	$path = trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );
	return 0 === strpos( $path, 'store/' );
}
function restocommerce_current_store_vendor() : ?WP_User {
	static $vendor = null; static $checked = false;
	if ( $checked ) { return $vendor; } $checked = true; $slug = restocommerce_store_slug_from_request();
	if ( ! $slug ) { return null; }
	$vendor = get_user_by( 'slug', $slug );
	if ( ! $vendor ) { $vendor = get_user_by( 'login', $slug ); }
	return $vendor instanceof WP_User ? $vendor : null;
}
/** Direction « Le Comptoir Éditorial » : précharger la candidate responsive qui sera réellement choisie pour le héros, jamais le PNG source pleine taille. */
function restocommerce_preload_storefront_responsive_hero() : void {
	$vendor = restocommerce_current_store_vendor();
	if ( ! $vendor ) { return; }
	$profile = (array) get_user_meta( (int) $vendor->ID, 'wcfmmp_profile_settings', true );
	$image_id = absint( $profile['banner'] ?? $profile['list_banner'] ?? 0 );
	if ( ! $image_id && function_exists( 'restocommerce_vendor_products' ) ) {
		$products = restocommerce_vendor_products( (int) $vendor->ID );
		if ( ! empty( $products[0] ) ) { $image_id = (int) get_post_thumbnail_id( $products[0]->get_id() ); }
	}
	if ( ! $image_id ) { return; }
	$href = wp_get_attachment_image_url( $image_id, 'medium_large' );
	$srcset = wp_get_attachment_image_srcset( $image_id, 'full' );
	if ( ! $href ) { return; }
	printf(
		"<link rel='preload' as='image' href='%1\$s' imagesrcset='%2\$s' imagesizes='100vw' fetchpriority='high'>\n",
		esc_url( $href ),
		esc_attr( $srcset ?: '' )
	);
}
add_action( 'wp_head', 'restocommerce_preload_storefront_responsive_hero', 2 );
function restocommerce_vendor_products( int $vendor_id, int $exclude_product_id = 0 ) : array {
	if ( ! class_exists( 'WooCommerce' ) || ! $vendor_id ) { return array(); }
	$ids = get_posts( array( 'post_type' => 'product', 'post_status' => 'publish', 'author' => $vendor_id, 'posts_per_page' => -1, 'post__not_in' => $exclude_product_id ? array( $exclude_product_id ) : array(), 'fields' => 'ids', 'orderby' => 'menu_order date', 'order' => 'DESC' ) );
	return array_values( array_filter( array_map( static function( $id ) use ( $vendor_id ) { $terms = get_the_terms( $id, 'product_cat' ); if ( $terms && ! is_wp_error( $terms ) ) { foreach ( $terms as $term ) { if ( ! restocommerce_vendor_category_is_enabled( $vendor_id, (int) $term->term_id ) ) { return null; } } } return wc_get_product( $id ); }, $ids ) ) );
}
function restocommerce_store_url_for_vendor( WP_User $vendor ) : string { return home_url( '/restaurant/' . rawurlencode( $vendor->user_nicename ?: $vendor->user_login ) . '/' ); }
/** Les slugs qui ne correspondent à aucun compte ne doivent jamais atteindre le routeur WCFM. */
add_action( 'parse_request', function() : void {
	$slug = restocommerce_store_slug_from_request();
	if ( ! $slug || get_user_by( 'slug', $slug ) || get_user_by( 'login', $slug ) ) { return; }
	status_header( 404 );
	nocache_headers();
	header( 'Content-Type: text/html; charset=' . get_bloginfo( 'charset' ) );
	echo '<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,follow"><title>' . esc_html__( 'Restaurant introuvable', 'restocommerce' ) . '</title><style>body{margin:0;background:#f7f3eb;color:#173f35;font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}.rc-page-not-found{box-sizing:border-box;min-height:100vh;display:grid;place-items:center;padding:24px}.rc-ui-state{max-width:640px;padding:clamp(32px,8vw,72px);background:#fffdf8;border:1px solid #d7cdbd;box-shadow:0 18px 50px rgba(23,63,53,.12)}.rc-eyebrow{margin:0 0 16px;color:#853725;font-size:.78rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}.rc-ui-state h1{margin:0;font-family:Georgia,serif;font-size:clamp(2rem,7vw,4.25rem);line-height:1.02}.rc-ui-state p:not(.rc-eyebrow){margin:20px 0 0;max-width:44ch;line-height:1.6}.rc-ui-state-action{display:inline-block;margin-top:28px;padding:13px 18px;background:#173f35;color:#fffdf8;font-weight:800;text-decoration:none}.rc-ui-state-action:focus-visible{outline:3px solid #853725;outline-offset:4px}</style></head><body><main class="rc-page-content rc-page-not-found"><section class="rc-ui-state rc-ui-state--error"><p class="rc-eyebrow">' . esc_html__( 'Restaurant introuvable', 'restocommerce' ) . '</p><h1>' . esc_html__( 'Cette table est introuvable.', 'restocommerce' ) . '</h1><p>' . esc_html__( 'Elle a peut-être changé d’adresse. Découvrez les autres restaurants du quartier.', 'restocommerce' ) . '</p><a class="rc-ui-state-action" href="' . esc_url( home_url( '/#restaurants' ) ) . '">' . esc_html__( 'Voir les restaurants', 'restocommerce' ) . '</a></section></main></body></html>';
	exit;
}, 0 );
/** Route publique non résolue : répondre avant le routeur WCFM, avec un vrai statut 404 plutôt qu’une erreur serveur. */
add_action( 'template_redirect', function() : void {
	if ( ! restocommerce_store_slug_from_request() || restocommerce_current_store_vendor() ) { return; }
	global $wp_query;
	if ( $wp_query instanceof WP_Query ) { $wp_query->set_404(); }
	status_header( 404 );
	nocache_headers();
	get_header();
	echo '<main class="rc-page-content rc-page-not-found"><section class="rc-ui-state rc-ui-state--error"><div><span class="rc-ui-state-mark" aria-hidden="true">!</span><p class="rc-eyebrow">' . esc_html__( 'Restaurant introuvable', 'restocommerce' ) . '</p><h1>' . esc_html__( 'Cette table est introuvable.', 'restocommerce' ) . '</h1><p>' . esc_html__( 'Elle a peut-être changé d’adresse. Découvrez les autres restaurants du quartier.', 'restocommerce' ) . '</p><a class="rc-ui-state-action" href="' . esc_url( home_url( '/#restaurants' ) ) . '">' . esc_html__( 'Voir les restaurants', 'restocommerce' ) . '</a></div></section></main>';
	get_footer();
	exit;
}, 0 );
add_action( 'template_redirect', function() : void {
	if ( ! restocommerce_store_request_uses_legacy_wcfm_route() ) { return; }
	$vendor = restocommerce_current_store_vendor();
	if ( ! $vendor ) { return; }
	wp_safe_redirect( restocommerce_store_url_for_vendor( $vendor ), 301 );
	exit;
}, 1 );
add_filter( 'pre_get_document_title', function( string $title ) : string {
	$vendor = restocommerce_current_store_vendor();
	if ( ! $vendor ) { return $title; }
	$cuisine = sanitize_text_field( (string) get_user_meta( (int) $vendor->ID, 'restocommerce_cuisine', true ) );
	$label = restocommerce_vendor_store_name( (int) $vendor->ID ) . ( $cuisine ? ' — ' . $cuisine : '' );
	return $label . ' | ' . get_bloginfo( 'name' );
} );
add_action( 'wp_head', function() : void {
	$vendor = restocommerce_current_store_vendor();
	if ( ! $vendor ) { return; }
	$profile = (array) get_user_meta( (int) $vendor->ID, 'wcfmmp_profile_settings', true );
	$description = sanitize_textarea_field( (string) ( $profile['description'] ?? get_user_meta( (int) $vendor->ID, 'restocommerce_store_description', true ) ?? '' ) );
	printf( "<link rel='canonical' href='%s'>\n", esc_url( restocommerce_store_url_for_vendor( $vendor ) ) );
	if ( $description ) { printf( "<meta name='description' content='%s'>\n", esc_attr( wp_trim_words( $description, 28, '' ) ) ); }
}, 1 );
add_filter( 'template_include', function( string $template ) : string {
	if ( restocommerce_is_vendor_dashboard_home() ) { return get_template_directory() . '/vendor-dashboard.php'; }
	$store_vendor = restocommerce_current_store_vendor();
	if ( $store_vendor ) { global $wp_query; if ( $wp_query instanceof WP_Query ) { $wp_query->is_404 = false; } status_header( 200 ); return get_template_directory() . '/storefront.php'; }
	if ( restocommerce_store_slug_from_request() ) { global $wp_query; if ( $wp_query instanceof WP_Query ) { $wp_query->set_404(); } status_header( 404 ); return $template; }
	if ( is_product() ) { return get_template_directory() . '/single-product.php'; }
	return $template;
}, 99 );
add_filter( 'the_content', function( string $content ) : string {
	if ( ! in_the_loop() || ! is_main_query() || is_admin() ) { return $content; }
	if ( is_cart() ) {
		return '<div class="rc-flow-page rc-cart-flow"><header class="rc-flow-heading"><div><p class="rc-eyebrow">' . esc_html__( 'Votre sélection', 'restocommerce' ) . '</p><h2>' . esc_html__( 'Le panier du comptoir.', 'restocommerce' ) . '</h2></div><p>' . esc_html__( 'Vérifiez vos plats et leurs options avant de poursuivre. Vous confirmerez directement avec le restaurant.', 'restocommerce' ) . '</p></header>' . do_shortcode( '[woocommerce_cart]' ) . '</div>';
	}
	if ( is_checkout() && ! is_order_received_page() ) {
		return '<div class="rc-flow-page rc-checkout-flow"><header class="rc-flow-heading"><div><p class="rc-eyebrow">' . esc_html__( 'Dernière étape', 'restocommerce' ) . '</p><h2>' . esc_html__( 'Confirmez avec la maison.', 'restocommerce' ) . '</h2></div><p>' . esc_html__( 'Vos coordonnées servent uniquement à préparer votre demande. La confirmation finale passe par WhatsApp.', 'restocommerce' ) . '</p></header>' . do_shortcode( '[woocommerce_checkout]' ) . '</div>';
	}
	return $content;
}, 50 );
