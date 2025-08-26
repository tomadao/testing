<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</ul>
<?php if ( ! isset( $_GET['showall'] ) ) { // if show all is not set ?>
	<?php if (false !== strpos($_SERVER['REQUEST_URI'], '?')) { // There is a query string (including cases when it's empty) ?>
		<div class="flex justify-center mt-4">
			<a class="button button-primary button-primary--red" href="<?php echo $_SERVER['REQUEST_URI']; ?>&showall=1#products">Show All Products</a>
		</div>
	<?php } else { ?>
		<div class="flex justify-center mt-4">
			<a class="button button-primary button-primary--red" href="<?php echo $_SERVER['REQUEST_URI']; ?>/?showall=1#products">Show All Products</a>
		</div>
	<?php } ?>
<?php } ?>