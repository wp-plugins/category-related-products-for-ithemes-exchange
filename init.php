<?php
/**
 * Inits the add-on when enabled by exchange
 *
 * @since 1.0.0
 * @package IT_Exchange_Category_Related_Products
*/

if ( is_admin() ) {
	include( dirname( __FILE__ ) . '/lib/settings.php' );
}

/**
 * Includes all of our internal helper functions
*/
include( 'lib/functions.php' );

/**
 * WP & Exchange template Hooks
*/
include( 'lib/hooks.php' );
