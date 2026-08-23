<?php
/** Direction « Le Comptoir Éditorial » : WooCommerce conserve son cycle natif, avec une enveloppe de lecture maîtrisée. */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="rc-wrap rc-shop-content">
	<?php woocommerce_content(); ?>
</section>
<?php get_footer();
