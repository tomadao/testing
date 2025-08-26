<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'col  col--small  w-1/4  sm:w-1/2  xs:w-full  mb-4  xs:mb-4', $product ); ?>>
	<div class="woocommerce-loop-product  rounded-lg">
		<?php

		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		
		do_action( 'woocommerce_before_shop_loop_item' );
		
		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */

		do_action( 'woocommerce_before_single_product_summary' );
				
		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		
		echo '<div class="woocommerce-loop-product__content">';

			do_action( 'woocommerce_shop_loop_item_title' );

			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */

			do_action( 'woocommerce_after_shop_loop_item_title' );
			
			/**
			 * Hook: woocommerce_after_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			
			// do_action( 'woocommerce_after_shop_loop_item' );
			?><a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" class="button">
				<span>View more details</span>
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 15"><title>arrow right icon</title><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 7.982h-16M12 1.965l6.018 6.017L12 14"></path></svg>
			</a><?php

		echo '</div>';
		?>
	</div>
</li>
