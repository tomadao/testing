<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;
$product_image_ids = $product->get_gallery_attachment_ids();

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<figure class="woocommerce-product-gallery__wrapper <?php if ($product_image_ids) :?>woocommerce-product-gallery__wrapper--carousel<?php endif; ?>">
		<div data-flickity="{ 'imagesLoaded':true}" class="<?php if ($product_image_ids) :?>js-product-carousel-image<?php endif; ?>  w-full">
			<?php if ($product_image_ids) :?>
				<?php
					echo '<div class="woocommerce-product-gallery__image  w-full">';
					echo '<img src="'.wp_get_attachment_url( $product->get_image_id() ).'">';
					echo '</div>';
				?>
				<?php foreach( $product_image_ids as $product_image_id ) {
					$image_url = wp_get_attachment_url( $product_image_id );
					echo '<div class="woocommerce-product-gallery__image  w-full">';
					echo '<img src="'.$image_url.'">';
					echo '</div>';
				}?>

			<?php else :?>

				<?php
					if ( $product->get_image_id() ) {
						$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
					} else {
						$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
						$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image  w-full" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
						$html .= '</div>';
					}

					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

					do_action( 'woocommerce_product_thumbnails' );
				?>
				
			<?php endif; ?>
		</div>

		<?php if ($product_image_ids) :?>
			<div data-flickity="{ 'imagesLoaded':true}" class="js-product-carousel-thumbs woocommerce-product-gallery__thumbs w-full">
				<?php 
					echo '<div class="woocommerce-product-gallery__thumb">';
					echo '<div class="woocommerce-product-gallery__image">';
					echo '<img src="'.wp_get_attachment_url( $product->get_image_id() ).'">';
					echo '</div>';
					echo '</div>';
				?>		
				<?php foreach( $product_image_ids as $product_image_id ) {
					$image_url = wp_get_attachment_url( $product_image_id );
					echo '<div class="woocommerce-product-gallery__thumb">';
					echo '<div class="woocommerce-product-gallery__image">';
					echo '<img src="'.$image_url.'">';
					echo '</div>';
					echo '</div>';
				}?>
			</div>
		<?php endif; ?>
	</figure>
</div>
