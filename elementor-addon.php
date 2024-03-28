<?php

/**
 * Plugin Name: Elementor Addon para Novidade Saudável
 * Description: Elementos customizáveis para Novidade Saudável
 * Version:     2.0
 * Author:      BeeGo | Walfrido Oliveira
 * Author URI:  https://beego.dev
 * Text Domain: elementor-addon
 */

function register_elementor_ns_widget($widgets_manager)
{

	/*require_once( __DIR__ . '/widgets/custom-title-widget.php' );
	require_once( __DIR__ . '/widgets/custom-text-widget.php' );
	require_once( __DIR__ . '/widgets/custom-button-widget.php' );
	require_once( __DIR__ . '/widgets/custom-list-widget.php' );
	require_once( __DIR__ . '/widgets/custom-accordion-widget.php' );
	require_once( __DIR__ . '/widgets/image-grid-widget.php' );
	require_once( __DIR__ . '/widgets/archor-widget.php' );*/

	require_once(__DIR__ . '/widgets/top-bar-widget.php');
	require_once(__DIR__ . '/widgets/custom-carousel-widget.php');
	require_once(__DIR__ . '/widgets/posts-widget.php');
	require_once(__DIR__ . '/widgets/whatsapp-float.php');
	require_once(__DIR__ . '/widgets/woo-archive-grid.php');
	require_once(__DIR__ . '/widgets/woo-filters.php');
	require_once(__DIR__ . '/widgets/woo-title-category.php');
	require_once(__DIR__ . '/widgets/woo-sugestao-uso.php');

	/*$widgets_manager->register( new \Elementor_Custom_Title_Widget() );
	$widgets_manager->register( new \Elementor_Custom_Text_Widget() );
	$widgets_manager->register( new \Elementor_Custom_Button_Widget() );
	$widgets_manager->register( new \Elementor_Custom_List_Widget() );
	$widgets_manager->register( new \Elementor_Custom_Accordion_Widget() );
	$widgets_manager->register( new \Elementor_Image_Grid_Widget() );
	$widgets_manager->register( new \Elementor_Anchor_Widget() );*/

	$widgets_manager->register(new \Elementor_Topo_Bar_Widget());
	$widgets_manager->register(new \Elementor_Carousel_Widget());
	$widgets_manager->register(new \Elementor_Posts_Widget());
	$widgets_manager->register(new \Elementor_Posts_Widget());
	$widgets_manager->register(new \Elementor_Whatsapp_Float_Widget());
	$widgets_manager->register(new \Elementor_Woo_Archive_Grid_Widget());
	$widgets_manager->register(new \Elementor_Woo_Filters_Widget());
	$widgets_manager->register(new \Elementor_Woo_Title_Category_Widget());
	$widgets_manager->register(new \Elementor_Woo_Sugestao_Uso_Widget());
}
add_action('elementor/widgets/register', 'register_elementor_ns_widget');

function register_widget_styles()
{
	wp_register_style('elementor-addon-ns-style', plugins_url('assets/css/styles.css?v=' . time(), __FILE__), [], false);
	wp_enqueue_style('elementor-addon-ns-style');
}
add_action('wp_enqueue_scripts', 'register_widget_styles');

function register_widget_scripts()
{
	wp_register_script('elementor-addon-ns-script', plugins_url('assets/js/script.js?v=' . time(), __FILE__), array('jquery'), false);
	wp_enqueue_script('elementor-addon-ns-script');
}
add_action('elementor/frontend/after_register_scripts', 'register_widget_scripts');

function woo_product_load_more()
{
	$args = [
		'post_type' => 'product',
		'posts_per_page' => 16,
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => $_POST['paged'],
	];

	$args = set_product_args($_POST, $args);

	$ajaxposts = new WP_Query($args);

	$response = '';

	if ($ajaxposts->have_posts()) {
		ob_start();
		while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
			$product = wc_get_product(get_the_ID());
			if ($product) :
				$price = $product->get_price(); ?>

				<div class="woo-item">
					<div class="woo-thumbnail">
						<a href="<?php echo get_the_permalink()  ?>">
							<?php echo get_the_post_thumbnail() ?>
						</a>
					</div>
					<div class="woo-title">
						<h2>
							<a href="<?php echo get_the_permalink()  ?>"><?php echo get_the_title() ?></a>
						</h2>
					</div>
					<div class="woo-price">
						<p class="price">
							<?php echo wc_price($price) ?>
						</p>
					</div>
					<div class="woo-btn-buy"></div>
				</div>
			<?php endif;
		endwhile;
		$response = ob_get_clean();
	}

	return wp_send_json([
		'render' => $response,
		'found_posts' => $ajaxposts->found_posts,
		'post_count' => $ajaxposts->post_count,
	]);
}
add_action('wp_ajax_woo_product_load_more', 'woo_product_load_more');
add_action('wp_ajax_nopriv_woo_product_load_more', 'woo_product_load_more');

function woo_search_product()
{
	$args = [
		'post_type' => 'product',
		'posts_per_page' => 16,
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => 1,
	];

	$args = set_product_args($_POST, $args);

	$ajaxposts = new WP_Query($args);

	$response = '';

	if ($ajaxposts->have_posts()) {
		ob_start();
		while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
			$product = wc_get_product(get_the_ID());
			if ($product) :
				$price = $product->get_price(); ?>

				<div class="woo-item">
					<div class="woo-thumbnail">
						<a href="<?php echo get_the_permalink()  ?>">
							<?php echo get_the_post_thumbnail() ?>
						</a>
					</div>
					<div class="woo-title">
						<h2>
							<a href="<?php echo get_the_permalink()  ?>"><?php echo get_the_title() ?></a>
						</h2>
					</div>
					<div class="woo-price">
						<p class="price">
							<?php echo wc_price($price) ?>
						</p>
					</div>
					<div class="woo-btn-buy"></div>
				</div>
      <?php endif;
		endwhile;
		$response = ob_get_clean();
	}

	return wp_send_json([
		'render' => $response,
		'found_posts' => $ajaxposts->found_posts,
		'post_count' => $ajaxposts->post_count,
	]);
}
add_action('wp_ajax_woo_search_product', 'woo_search_product');
add_action('wp_ajax_nopriv_woo_search_product', 'woo_search_product');

if (!function_exists('set_product_args')) {
	function set_product_args($post, $args) {
		if (isset($post['product_cat'])) {
			$args['tax_query'] = array(
				array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $post['product_cat'],
				),
			);
		}
	
		if (isset($post['categories'])) {
			$args['tax_query'] = array(
				array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $post['categories'],
				'operator' => 'IN',
				),
			);
		}
	
		if (isset($post['tags'])) {
			$args['tax_query'] = array(
				array(
				'taxonomy' => 'product_tag',
				'field' => 'slug',
				'terms' => $post['tags'],
				'operator' => 'IN',
				),
			);
		}
	
		if (isset($post['s'])) {
			$args['s'] = $post['s'];
		}
	
		if (isset($post['orderby'])) {
			$args = set_order_product($post['orderby'], $args);
		}

		return $args;
	}
}

if (!function_exists('set_order_product')) {
	function set_order_product($orderby, $args) {
		switch ($orderby) {
			case 'price':
				$args['orderby'] = 'meta_value_num';
        $args['order'] = 'ASC';
        $args['meta_key'] = '_price';
				break;
			
			case 'price-desc':
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'DESC';
				$args['meta_key'] = '_price';
				break;

			case 'date':
				$args['orderby'] = 'date';
				$args['order'] = 'DESC';
				break;

			case 'popularity':
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'DESC';
				$args['meta_key'] = 'total_sales';
				break;

			case 'title':
				$args['orderby'] = 'title';
				$args['order'] = 'ASC';
				break;

			case 'title_desc':
				$args['orderby'] = 'title';
				$args['order'] = 'DESC';
				break;
		}
		return $args;
	}
}