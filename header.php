<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eduardo_Domingos_Photography
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<header class="site-header">
		<?php get_sidebar('header'); ?>
		<div class="site-header__bar">
			<div class="container">
				<hgroup>
					<h1 class="site-header__logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php $edp_description = get_bloginfo( 'description', 'display' ); ?>
					<?php if ( $edp_description ) : ?>
						<h2 class="screen-reader-text"><?php echo $edp_description; ?></h2>
					<?php endif; ?>
				</hgroup>

				<button class="hamburger hamburger--collapse" type="button" aria-label="Menu" aria-controls="site-header__nav">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
					<span class="screen-reader-text">Menu Principal</span>
				</button>

				<nav id="site-header__nav" class="site-header__nav">
					<h2 class="screen-reader-text">Menu Principal</h2>
					<div class="site-header__search">
						<?php get_search_form(); ?>
					</div>
					<?php bem_menu('menu-1', 'site__header-nav'); ?>
				</nav>
			</div>
		</div>
		<div class="site-header__search site-header__search--desktop">
			<div class="wrap">
				<?php get_search_form(); ?>
			</div>
		</div>
	</header>
