<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>

<?php
	// ACF page builder
if(!is_product_category() ){
	$shopPageID = '883';

	if( have_rows('row', $shopPageID) ):
		$row_count = 1; while ( have_rows('row', $shopPageID) ) : the_row();

		if( get_sub_field('add_to_in_page_nav') ):
			$rowID = get_sub_field('block_id');
		else:
			$rowID = 'row-' . $row_count;
		endif;

		include get_template_directory() . '/page-builder/'. get_row_layout() .'/' . get_row_layout() . '.php';

	$row_count++; endwhile; endif;

} else {

	$cate = get_queried_object();
	$cateID = $cate->term_id;
	$thumb = get_term_meta( $cateID, 'thumbnail_id', true );
	$title = esc_html( $cate->name );
	$description = wpautop($cate->description);

	if($thumb) {
		$image = wp_get_attachment_url( $thumb );
	}
	else {
		$image = '/wp-content/themes/JBcommercial/assets/img/cat__thumb-default.jpg';
	}
?>

<section class="img-content  mb-16  xs:mb-12 ">
    <div class="container">
        <div class="row  flex  justify-between  items-center  xs:flex-wrap image-text">
            <div class="col  w-14  img-content__img  xs:w-full  xs:order-first xs:mb-8">
                <div class="img-border  relative">
                    <div class="img-wrap  rounded">
						<?php echo '<img src="'. $image .'" class="object-fit  image  lazyload" alt="View '. $title .' category"/>' ?>
                    </div>
                </div>
            </div>

            <div class="col  w-10  xs:w-full  flex  justify-end">
                <div class="img-content__content  w-full  xs:text-center">
					<header class="title  title--small  title--left  title--red  flex  items-start">
						<h2 class="font-extrabold  leading-tight  flex-1  mb-8">
							<?php echo $title; ?>
						</h2>
					</header>

                    <?php if( $description ): ?>
                        <article class="description">
                            <?php echo $description; ?>
                        </article>
                    <?php endif; ?>
                </div>    
            </div>
        </div>
    </div>
</section>
<?php } ?>

<?php 
$term = get_queried_object();

$children = get_terms( $term->taxonomy, array(
'parent'    => $term->term_id,
'hide_empty' => false
) );
// print_r($children); // uncomment to examine for debugging
if($children) { // get_terms will return false if tax does not exist or term wasn't found.
    // term has children
?>
<section class="cta-blocks  bg-black-05  mb-12  pt-8  pb-12">
	<div class="container">
		<h4 class="size-l  font-extrabold  mb-7">
			Shop By Category
		</h4>
		
		<?php
			$taxonomy     = 'product_cat';
			$orderby      = 'menu_order';  
			$show_count   = 0;      // 1 for yes, 0 for no
			$pad_counts   = 0;      // 1 for yes, 0 for no
			$hierarchical = 1;      // 1 for yes, 0 for no  
			$title        = '';  
			$empty        = 0;

			$cate = get_queried_object();
			if(is_product_category() ){
				$cateID = $cate->term_id;
				$args = array(
					'taxonomy'     => $taxonomy,
					'orderby'      => $orderby,
					'show_count'   => $show_count,
					'pad_counts'   => $pad_counts,
					'hierarchical' => $hierarchical,
					'title_li'     => $title,
					'hide_empty'   => $empty,
					'child_of'     => $cateID,
				);				

			} else {
				$parent   = 0;

				$args = array(
					'taxonomy'     => $taxonomy,
					'orderby'      => $orderby,
					'show_count'   => $show_count,
					'pad_counts'   => $pad_counts,
					'hierarchical' => $hierarchical,
					'title_li'     => $title,
					'hide_empty'   => $empty,
					'parent'       => $parent
				);				
			}

			$all_categories = get_categories( $args );

			echo '<div class="row--large categories flex  justify-start  flex-wrap">';

			$i=1;

			foreach ($all_categories as $cat) {

				// if($cat->category_parent == 0) {
					$category_id = $cat->term_id;
					$parent_term = get_term( $category_id, 'category' );
					$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );

					if($i < 7) {
						$hide = '';
					} else {
						$hide = 'hidden';
					}

					if($thumbnail_id) {
						$image = wp_get_attachment_url( $thumbnail_id );
					}
					else {
						$image = '/wp-content/themes/JBcommercial/assets/img/cat__thumb-default.jpg';
					}
					
					echo 
					'<div class="col  w-4  md:w-1/4  sm:w-1/2  mb-8 ">
						<a href="'. get_term_link($cat->slug, 'product_cat') .'" class="cta-blocks__item  cta-blocks__item--primary  cta-blocks__item--small  h-full  relative  block  rounded  bg-black  shadow" title="View '. $cat->name .' category">
							<figure class="content  content--small  absolute  w-full  text-center  z-10">
								<h4 class="text-white  heading  heading--small  font-extrabold  break-words  xs:mb-0  mb-8">
									'. $cat->name .'
								</h4>

								<div class="button  button-icon  button-icon--small  button-icon-primary  button-icon-primary--white  mx-auto  xs:hidden">
									<span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 15"><title>arrow icon next</title><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 7.982h-16M12 1.965l6.018 6.017L12 14"></path></svg></span>
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 19"><title>plus icon</title><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.657v-16M1 9.657h16"></path></svg>
                                </div>
							</figure>
							

							<img src="'. $image .'" class="object-fit  image  lazyload" alt="View '. $cat->name .' category"/>
						</a>
					</div>';
				// }

				$i++;				
			}

			echo '</div>';
		?>
	</div>
</section>

<?php if(get_field('finance_page_link', 'options')) { ?>
	<?php $button = get_field('finance_page_link', 'options'); ?>
	<div class="floating-sidebar">
		<a href="<?php echo $button['url']; ?>" class="button button-primary button-primary--red">
			<span><?php echo $button['title']; ?></span>
		</a>
	</div>
<?php } ?>

<?php }

/* start Woocommerce loop  */

echo '<div class="container  mb-32  xs:mb-12">';

	if ( woocommerce_product_loop() ) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		*/

		echo '<div class="woocommerce-filter-bar  flex  justify-between  items-center  mb-10  xs:flex-wrap">';
			if ( is_active_sidebar( 'shop-sidebar-widget' ) ) :
				echo '<div id="shop-sidebar-widget-area" class="shop-sidebar-widget widget-area" role="complementary">';
					dynamic_sidebar( 'shop-sidebar-widget' );
				echo '</div>';
			endif;

			do_action( 'woocommerce_before_shop_loop' );
		echo '</div>';

		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();

				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action( 'woocommerce_shop_loop' );

				wc_get_template_part( 'content', 'product' );
			}
		}

		woocommerce_product_loop_end();

		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */

		do_action( 'woocommerce_after_shop_loop' );

	} else {
		
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */

		do_action( 'woocommerce_no_products_found' );
	}

	/**
	 * Hook: woocommerce_after_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */

	do_action( 'woocommerce_after_main_content' );

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */

	// do_action( 'woocommerce_sidebar' );

echo '</div>';

?>


<section class="mb-24  xs:mb-4">
	<div class="container">
		<?php if( have_rows('logos' , 'option') ): ?>
			<?php $itemCount = 0; while ( have_rows('logos' , 'option') ): the_row();?>
				<?php if( $itemCount % 6 == 0): ?>
					<div class="logo-section logo-section-special flex  sm:flex-wrap  items-center  justify-center">
				<?php endif; ?>

					<div class="logo-section__item  mb-12">
						<div class="logo  mx-auto">
							<?php echo img_sizes(get_sub_field('image'), ['default' => '500', 'lazy_load' => true, 'object_fit' => 'w-full']); ?>
						</div>
					</div>

				<?php if( $itemCount % 6 == 5) : ?>
					</div>
				<?php endif; ?>
			<?php $itemCount++; endwhile; ?>
		<?php endif; ?>
	</div>
</section>


<?php /* include Instagram */ ?>

<?php if( have_rows('social', 'option') ): ?>
    <?php while( have_rows('social', 'option') ): the_row();
        $instagram = get_sub_field('instagram');
        $text = get_sub_field('instagram_feed_text');
        $instagram_account = get_sub_field('instagram_feed_account');
    ?>
        <section class="instagram  mb-24  xs:mb-12">
            <div class="container">
                <div class="row  flex  xs:flex-wrap  justify-between  items-center">
                    <div class="col  w-7  sm:w-1/2  xs:w-full  xs:mb-6">
                        <div class="instagram__icon  mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 26 26"><title>instagram icon</title><path fill="currentColor" d="M25.061 8.022c-.095-1.95-.538-3.679-1.962-5.106-1.423-1.427-3.148-1.87-5.094-1.966-1.677-.095-3.339-.08-5.016-.08S9.651.855 7.974.95c-1.946.095-3.671.54-5.095 1.966C1.455 4.343 1.014 6.072.917 8.022.823 9.703.837 11.37.837 13.05c0 1.681-.014 3.346.08 5.027.095 1.95.538 3.68 1.962 5.107s3.149 1.87 5.095 1.966c1.677.095 3.338.08 5.015.08 1.677 0 3.339.015 5.016-.08 1.946-.095 3.67-.54 5.094-1.966 1.424-1.427 1.866-3.156 1.962-5.107.095-1.68.08-3.346.08-5.027 0-1.68.015-3.346-.08-5.027zm-2.595 12.211a4.15 4.15 0 01-2.31 2.315c-1.598.635-5.396.492-7.167.492-1.77 0-5.569.143-7.167-.492a4.139 4.139 0 01-2.31-2.315c-.633-1.602-.49-5.409-.49-7.184 0-1.774-.143-5.581.49-7.183a4.149 4.149 0 012.31-2.316c1.599-.634 5.396-.491 7.167-.491s5.57-.143 7.168.491a4.137 4.137 0 012.31 2.316c.632 1.602.49 5.409.49 7.183 0 1.775.142 5.582-.49 7.184z"/><path fill="#484848" d="M19.477 5.089a1.454 1.454 0 00-1.346.9 1.462 1.462 0 001.062 1.991 1.453 1.453 0 001.495-.62 1.462 1.462 0 00-1.211-2.271zM12.989 6.802a6.224 6.224 0 00-3.464 1.053 6.262 6.262 0 00-.945 9.613 6.23 6.23 0 006.794 1.355 6.237 6.237 0 002.798-2.302 6.26 6.26 0 001.05-3.471A6.254 6.254 0 0017.4 8.63a6.225 6.225 0 00-4.41-1.828zm0 10.308a4.044 4.044 0 01-3.743-2.506 4.069 4.069 0 01.879-4.425 4.047 4.047 0 016.915 2.871 4.073 4.073 0 01-1.19 2.868 4.054 4.054 0 01-2.861 1.192z"/></svg>
                        </div>

                        <?php if ($text): ?>
                            <span>
                                <?php echo $text; ?>
                            </span>
                        <?php endif; ?>
                    
                        <?php if ($instagram): ?>
                            <a href="<?php echo $instagram; ?>" class="button  button-tertiary  text-left  mt-8" title="Follow us on Instagram" target="_blank" rel="noopener">
                                <span>
                                    Follow us on Instagram
                                </span>
                            
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 15"><title>arrow right icon</title><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 7.982h-16M12 1.965l6.018 6.017L12 14"></path></svg>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="col  w-15  sm:w-1/2  xs:w-full">
                        <?php if ($instagram_account): ?>
                            <div class="row--small  flex  sm:flex-wrap  instagram__feed  js-instagram-feed" id="instafeed" data-account="<?php echo $instagram_account; ?>">
                            </div>
                        <?php else :?>
                            <p class="text-center">
                                Please add an instagram ID in the CMS
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endwhile ;?>
<?php endif ;?>

<?php get_footer( 'shop' ); ?>