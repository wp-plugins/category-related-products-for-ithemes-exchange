<?php
/**
 * Enqueues scripts/styles to the product page
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_category_related_products_addon_enqueue_scripts() {
	// enqueue stylesheet on product page
	if ( it_exchange_is_page( 'product' ) ) {
		wp_enqueue_style( 'it-exchange-category-related-products-frontend', ITUtility::get_url_from_file( dirname( __FILE__ ) ) . '/css/category-related-products-frontend.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'it_exchange_category_related_products_addon_enqueue_scripts' );


/**
 * Outputs related products on the product page
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_category_related_posts() {
	
	/* 
	  store current product ID before we start a new loop 
	  so that we can exclude it from the related product list
	*/
	global $post;
	$current_product_id = $post->ID;

	// get the settings for display
	$settings  = it_exchange_get_option( 'category_related_products' );
	$count     = $settings['count'];

	if ( $settings['width-int'] && $settings['width-unit'] ) {
		$width = $settings['width-int'] . $settings['width-unit'];
	} else {
		$width = '30%';
	}
	
	// setup the args for a new related products loop
	$args = array(
		'showposts'    => $count,
		'post_type'    => 'it_exchange_prod',
		'orderby'      => 'rand',
		'post__not_in' => array( $current_product_id ),
		'tax_query'    => array(
			array(
				'taxonomy' => 'it_exchange_category',
				'field'    => 'id', 
				'terms'    => it_exchange_get_product_categories(),
				'operator' => 'IN'
			)
		)
	);

	$the_query = new WP_Query( $args );
?>

	<?php // the loop for related products ?>
	<?php if ( $the_query->have_posts() ) : ?>
	
		<?php // Heading above the related products list. The heading text is filterable with it_exchange_category_related_product_heading ?>
		<?php do_action( 'it_exchange_category_related_product_before_heading' ); ?>
		<h3 class="it-exchange-category-related-products-heading">
			<?php $heading = apply_filters( 'it_exchange_category_related_product_heading', __( 'Related Products', 'exchange-addon-category-related-products' ) ); ?>
			<?php echo $heading; ?>
		</h3>
		<?php do_action( 'it_exchange_category_related_product_after_heading' ); ?>
		
		<?php do_action( 'it_exchange_category_related_product_before_product_list' ); ?>
		<ul class="it-exchange-category-related-product-list">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		
			<?php // setup the exchange product so we have access to the API ?>
			<?php $exchange_product = it_exchange_get_product( $post->ID ); ?>
			<?php $GLOBALS['it_exchange']['product'] = $exchange_product; ?>
			<li class="it-exchange-category-related-product <?php echo ( ! it_exchange( 'product', 'has-images' ) ) ? ' no-images' : 'has-images'; ?>" style="max-width:<?php echo $width; ?>">
				<?php do_action( 'it_exchange_category_related_product_before_featured_image' ); ?>
				<?php if ( it_exchange( 'product', 'has-featured-image' ) ) : ?>
					<a class="it-exchange-category-related-product-feature-image" href="<?php it_exchange( 'product', 'permalink', array( 'format' => 'url' ) ); ?>">
						<?php it_exchange( 'product', 'featured-image', array( 'size' => 'large' ) ); ?>
					</a>
				<?php endif; ?>
				<?php do_action( 'it_exchange_category_related_product_before_featured_image' ); ?>
				
				<?php do_action( 'it_exchange_category_related_product_before_product_title' ); ?>
				<?php it_exchange( 'product', 'title' ); ?>
				<?php do_action( 'it_exchange_category_related_product_after_product_title' ); ?>
			</li>
			
		<?php endwhile; ?>
		</ul>
		<?php do_action( 'it_exchange_category_related_product_after_product_list' ); ?>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
	
<?php
}
// hook into template after it_exchange_content_product_after_product_advanced_loop
add_action( 'it_exchange_content_product_after_product_advanced_loop', 'it_exchange_category_related_posts' );


/**
 * Check to see if Product Categories core addon is enabled, if it is not, enable it.
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_category_related_posts_enable_core_category_addon() {
	$enabled_addons = it_exchange_get_enabled_addons();
	
	if ( ! $enabled_addons['taxonomy-type-category'] ) {
		it_exchange_enable_addon( 'taxonomy-type-category' );
	}
}
add_action( 'it_exchange_enabled_addons_loaded', 'it_exchange_category_related_posts_enable_core_category_addon' );
