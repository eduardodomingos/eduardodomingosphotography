<?php
/**
 * The sidebar containing the CTA's Header widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eduardo_Domingos_Photography
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div class="site-header__widget-area">
	<div class="wrap">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div>
</div>
