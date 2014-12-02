<?php
/**
 * Supporting functions
 * @package IT_Exchange_Category_Related_Products
 * @since 1.0.0
*/

/**
 * Gets term IDs for the current product
 *
 * @since 1.0.0
 *
 * @return array $category_ids Array of product term id's
*/
function it_exchange_get_product_categories() {
	// get the exchange product
	global $post;
	$exchange_product = it_exchange_get_product( $post->ID ); 

	// get terms for the it_exchange_category taxonomy
	$categories = wp_get_post_terms( $exchange_product->ID, 'it_exchange_category' );

	// add just the id's from the term object to an array
	$category_ids = array();
	foreach ( $categories as $category ){
		array_push( $category_ids , $category->term_id);
	}
	return $category_ids;
}