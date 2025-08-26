<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product; 
$seatHeight = get_post_meta( get_the_ID(), '_seat_height', true );
$seatHeight = str_replace(".0000", "", $seatHeight);


if ( ! $product_attributes ) {
	return;
}
?>
<table class="woocommerce-product-attributes shop_attributes">
<?php if($seatHeight) { ?>
	<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
		<th class="woocommerce-product-attributes-item__label">Seat Height</th>
		<td class="woocommerce-product-attributes-item__value"><?php echo $seatHeight; ?> mm</td>
	</tr>
<?php } ?>
<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : if($product_attribute['label'] == 'Weight' && $product_attribute['value'] == 0 ): else: ?>
		<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
			<th class="woocommerce-product-attributes-item__label"><?php echo wp_kses_post( $product_attribute['label'] ); ?></th>
			<td class="woocommerce-product-attributes-item__value"><?php echo wp_kses_post( $product_attribute['value'] ); ?></td>
		</tr>
	<?php endif; endforeach; ?>
</table>
