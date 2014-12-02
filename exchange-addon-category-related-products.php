<?php
/*
 * Plugin Name: iThemes Exchange - Category Related Products
 * Version: 1.0.1
 * Description: Display related products based on categories
 * Plugin URI: http://tywayne.com
 * Author: Ty Carlson
 * Author URI: http://tywayne.com
 * Text Domain: exchange-addon-category-related-products
*/

/**
 * Define the version number
 *
 * @since 1.0.0
*/
define( 'IT_Exchange_Category_Related_Products_Version', '1.0.1' );

/**
 * This registers our plugin as an exchange addon
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_register_category_related_products_addon() {
	$options = array(
		'name'              => __( 'Category Related Products', 'exchange-addon-category-related-products' ),
		'description'       => __( 'Display related products based on iThemes Exchange product categories.', 'exchange-addon-category-related-products' ),
		'author'            => 'Ty Carlson',
		'author_url'        => 'http://tywayne.com/',
		'icon'              => ITUtility::get_url_from_file( dirname( __FILE__ ) . '/lib/images/icon.png' ),
		'file'              => dirname( __FILE__ ) . '/init.php',
		'category'          => 'product-feature',
		'basename'          => plugin_basename( __FILE__ ),
		'settings-callback' => 'it_exchange_category_related_products_addon_print_settings',
	);
	it_exchange_register_addon( 'exchange-category-related-products', $options );
}
add_action( 'it_exchange_register_addons', 'it_exchange_register_category_related_products_addon' );
