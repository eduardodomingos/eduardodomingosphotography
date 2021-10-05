<?php
/**
 * Display Modules
 *
 */
function edp_modules( $post_id = false ) {
	if( ! function_exists( 'get_field' ) )
		return;

	$post_id = $post_id ? intval( $post_id ) : get_the_ID();
	$modules = get_field( 'edp_modules', $post_id );
	if( empty( $modules ) )
		return;

	foreach( $modules as $i => $module )
		edp_module( $module, $i );
}

/**
 * Display Module
 *
 */
function edp_module( $module = array(), $i = false ) {
	if( empty( $module['acf_fc_layout'] ) )
		return;

	//edp_module_open( $module, $i );

	switch( $module['acf_fc_layout'] ) {

		case edp_module_disable( $module ):
			break;
		
		case 'hero':
			edp_get_template_part('template-parts/modules/module', 'hero', array('data' => $module));
			break;

		case 'post_listing':
			edp_get_template_part('template-parts/modules/module', 'post-listing', array('data' => $module));
			break;
	}
	//edp_module_close( $module, $i );
}

/**
 * Module Disable
 * For example disable module save_recipes_cta if use is logged in
 */
function edp_module_disable( $module ) {
	$disable = false;
	// if( 'save_recipes_cta' == $module['acf_fc_layout'] && is_user_logged_in() )
	// 	$disable = true;

	return $disable;
}


/**
 * Has Module
 * Helper function useful for modifying other areas of the theme if a certain modules in use.
 * For instance, on a category landing page you could remove the default category intro if the “Header” module is used
 */
function edp_has_module( $module_to_find = '', $post_id = false ) {
	if( ! function_exists( 'get_field' ) )
		return;

	$post_id = $post_id ? intval( $post_id ) : get_the_ID();
	$modules = get_field( 'edp_modules', $post_id );
	$has_module = false;

	foreach( $modules as $module ) {
		if( $module_to_find == $module['acf_fc_layout'] )
			$has_module = true;
	}

	return $has_module;
}