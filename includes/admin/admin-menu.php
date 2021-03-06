<?php
/**
 * WP Download Codes Plugin
 *
 * FILE
 * includes/admin/admin-menu.php
 *
 * DESCRIPTION
 * Creates the admin menu.
 */

/**
 * Initializes scripts and stylesheets
 */
function dc_admin_init() {
	wp_register_script( 'wp-download-codes-script', plugins_url( 'wp-download-codes/resources/js/wp-download-codes.js' ), array( 'jquery' ) );
	wp_register_style( 'wp-download-codes-stylesheet', plugins_url( 'wp-download-codes/resources/css/wp-download-codes.css' ) );
}

/**
 * Creates the dc admin menu hooked with the administration menu
 */
function dc_admin_menu() {

    dc_init_capabilities();

	$hooknames = array();

	// Main menu (start with "Manage Releases")
	$hooknames[] = add_menu_page(
	    'Manage Releases',
        'Download Codes',
        DC_CAPABILITY,
        'dc-manage-releases',
        'dc_manage_releases',
        plugins_url( 'wp-download-codes/resources/icon.png' )
    );

	// Manage releases
	$hooknames[] = add_submenu_page(
	    'dc-manage-releases',
        'Manage Releases',
        'Manage Releases',
        DC_CAPABILITY,
        'dc-manage-releases',
        'dc_manage_releases'
    );

	// Manage codes
	$hooknames[] = add_submenu_page(
	    'dc-manage-releases',
        'Manage Download Codes',
        'Manage Codes',
        DC_CAPABILITY,
        'dc-manage-codes',
        'dc_manage_codes'
    );

	// General settings
	$hooknames[] = add_submenu_page(
	    'dc-manage-releases',
        'Download Code Settings',
        'Settings',
        DC_CAPABILITY,
        'dc-manage-settings',
        'dc_manage_settings'
    );

	// Help
	$hooknames[] = add_submenu_page(
	    'dc-manage-releases',
        'Download Codes Help',
        'Help',
        DC_CAPABILITY,
        'dc-help',
        'dc_help'
    );

	// Load external files
	foreach ( $hooknames as $hookname )
	{
		add_action( "admin_print_scripts-$hookname", 'dc_resources_admin_head' );
	}
}

/**
 * Adds JS and CSS to WP header for dc pages
 */
function dc_resources_admin_head() {
	wp_enqueue_script( 'wp-download-codes-script' );
	wp_enqueue_style( 'wp-download-codes-stylesheet' );
}

/**
 * @param bool|string [$menuSlug] – The Menu Slug – Default is 'dc-manage-releases'
 * @param array [$arg] - A list of Arguments added to the URL
 *
 * @return string
 */
function dc_admin_url( $menuSlug = false, $arg = array() ) {

    if ( empty( $arg ) && is_array( $menuSlug ) ) {
        $arg = $menuSlug;
        $menuSlug = false;
    }

    if ( ! $menuSlug ) {
        $menuSlug = 'dc-manage-releases';
    }
    if ( !is_array( $arg ) ) {
        $arg = array();
    }

    $url = menu_page_url( $menuSlug, false );

    return add_query_arg( $arg, $url );
}
