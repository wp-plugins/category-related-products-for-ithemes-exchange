<?php
/**
 * Functions and hooks related to settings
 * @since 1.0.0
*/


/**
 * Enqueue scripts for admin page
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_category_related_products_enqueue_admin_scripts( $prefix ) {
	if ( empty( $prefix ) || 'exchange_page_it-exchange-addons' != $prefix ) {
		return;
	}

	if ( empty( $_GET['add-on-settings'] ) || 'exchange-category-related-products' != $_GET['add-on-settings'] ) {
		return;
	}

	// Enqueue CSS
	wp_enqueue_style( 'it-exchange-addon-category-related-products-settings', ITUtility::get_url_from_file( dirname( __FILE__ ) ) . '/css/category-related-products-settings.css' );
}
add_action( 'admin_enqueue_scripts', 'it_exchange_category_related_products_enqueue_admin_scripts' );

/**
 * This function prints the settings page
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_category_related_products_addon_print_settings() {
	$settings = it_exchange_get_option( 'category_related_products', true );
	$form_options = array(
		'id'      => 'it-exchange-addon-category-related-products-settings',
		'action'  => 'admin.php?page=it-exchange-addons&add-on-settings=exchange-category-related-products',
	);
	$form                      = new ITForm( array(), array( 'prefix' => 'it-exchange-addon-category-related-products' ) );
	
	$category_related_products_count      = empty( $settings['count'] ) ? '3' : $settings['count'];
	$category_related_products_width_int  = empty( $settings['width-int'] ) ? '30' : $settings['width-int'];
	$category_related_products_width_unit = empty( $settings['width-unit'] ) ? '%' : $settings['width-unit'];

	?>
	<div class="wrap">
		<?php ITUtility::screen_icon( 'it-exchange' ); ?>
		<h2><?php _e( 'Category Related Products Settings', 'exchange-addon-category-related-products' ); ?></h2>

		<?php do_action( 'it_exchange_category_related_products_settings_page_top' ); ?>
		<?php do_action( 'it_exchange_addon_settings_page_top' ); ?>
		<div class="postbox-container">
		<?php $form->start_form( $form_options, 'it-exchange-category-related-products-settings' ); ?>

		<?php
		do_action( 'it_exchange_category_related_products_settings_form_top' );
		if ( ! empty( $_POST['__it-form-prefix'] ) && 'it-exchange-addon-category-related-products' == $_POST['__it-form-prefix'] )
			ITUtility::show_status_message( __( 'Options Saved', 'exchange-addon-category-related-products' ) );

		?>
		
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="category-related-products-count"><?php _e( 'Related Products Count', 'exchange-addon-category-related-products' ) ?></label></th>
					<td>
						<?php 
							$field_options = array(
								'id'      => 'count',
								'class'   => 'small-text',
								'value'   => $category_related_products_count
							);
						?>
						<?php $form->add_text_box( 'count', $field_options ); ?>
			
						<label for="category-related-products-count">
							<span class="description"><?php _e( 'How many related products would you like to display?', 'exchange-addon-category-related-products' ); ?></span>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="category-related-products-width"><?php _e( 'Related Product Width', 'exchange-addon-category-related-products' ) ?></label></th>
					<td>
						<?php 
							$field_options = array(
								'id'      => 'width-int',
								'class'   => 'small-text',
								'value'   => $category_related_products_width_int
							);
						?>
						<?php $form->add_text_box( 'width-int', $field_options ); ?>
						
						<div class="radio-options">
							<div class="radio-option">
								<?php
									$radio_options = array(
										'id'      => 'width-unit-percent',
										'value'   => '%',
										'class'   => 'width-unit-percent',
									);
									if ( '%' == $category_related_products_width_unit ) { $radio_options['checked'] = true; }
									$form->add_radio( 'width-unit', $radio_options );
								?>
								<label for="width-unit-percent">%</label>
							</div>
							
							<div class="radio-option">
								<?php
									$radio_options = array(
										'id'      => 'width-unit-px',
										'value'   => 'px',
										'class'   => 'width-unit-px',
									);
									if ( 'px' == $category_related_products_width_unit ) { $radio_options['checked'] = true; }
									$form->add_radio( 'width-unit', $radio_options );
								?>
								<label for="width-unit-px">px</label>
							</div>
						</div>
						
						<label for="category-related-products-width">
							<span class="description"><?php _e( 'Width of each product in the related products list', 'exchange-addon-category-related-products' ); ?></span>
						</label>
					</td>
				</tr>
			</tbody>
		</table>
		
		<?php $form->add_submit( 'category-related-products', array( 'value' => 'Save Settings' ) ); ?>
		<?php do_action( 'it_exchange_category_related_products_settings_form_bottom' ); ?>
		<?php $form->end_form(); ?>
		</div>
		<?php do_action( 'it_exchange_addon_settings_page_bottom' ); ?>
		<?php do_action( 'it_exchange_category_related_products_settings_page_bottom' ); ?>
	</div>
	<?php
}


/**
 * Saves the form settings
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_category_related_products_addon_save_settings() {
	// Abandon if not updating our settings
	if ( empty( $_POST['__it-form-prefix'] ) || 'it-exchange-addon-category-related-products' !== $_POST['__it-form-prefix'] )
		return;

	// Check the nonce
	check_admin_referer( 'it-exchange-category-related-products-settings' );

	// Get submitted values
	$values = ITForm::get_post_data();

	// Save values
	it_exchange_save_option( 'category_related_products', $values );
}
add_action( 'admin_init', 'it_exchange_category_related_products_addon_save_settings' );