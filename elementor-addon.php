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

	require_once(__DIR__ . '/widgets/top-bar-widget.php');
	require_once(__DIR__ . '/widgets/custom-carousel-widget.php');
	require_once(__DIR__ . '/widgets/posts-widget.php');
	require_once(__DIR__ . '/widgets/whatsapp-float.php');
	require_once(__DIR__ . '/widgets/woo-archive-grid.php');
	require_once(__DIR__ . '/widgets/posts-archive-grid.php');
	require_once(__DIR__ . '/widgets/woo-filters.php');
	require_once(__DIR__ . '/widgets/posts-filters.php');
	require_once(__DIR__ . '/widgets/woo-title-category.php');
	require_once(__DIR__ . '/widgets/woo-sugestao-uso.php');

	$widgets_manager->register(new \Elementor_Topo_Bar_Widget());
	$widgets_manager->register(new \Elementor_Carousel_Widget());
	$widgets_manager->register(new \Elementor_Posts_Widget());
	$widgets_manager->register(new \Elementor_Posts_Widget());
	$widgets_manager->register(new \Elementor_Whatsapp_Float_Widget());
	$widgets_manager->register(new \Elementor_Woo_Archive_Grid_Widget());
	$widgets_manager->register(new \Elementor_Posts_Archive_Grid_Widget());
	$widgets_manager->register(new \Elementor_Woo_Filters_Widget());
	$widgets_manager->register(new \Elementor_posts_Filters_Widget());
	$widgets_manager->register(new \Elementor_Woo_Title_Category_Widget());
	$widgets_manager->register(new \Elementor_Woo_Sugestao_Uso_Widget());
}
add_action('elementor/widgets/register', 'register_elementor_ns_widget');

function register_widget_styles()
{
	wp_register_style('elementor-addon-ns-style', plugins_url('assets/css/styles.css?v=' . time(), __FILE__), [], false);
	wp_register_style('elementor-addon-ns-style-mobile', plugins_url('assets/css/styles-mobile.css?v=' . time(), __FILE__), [], false);
	wp_enqueue_style('elementor-addon-ns-style');
	wp_enqueue_style('elementor-addon-ns-style-mobile');
}
add_action('wp_enqueue_scripts', 'register_widget_styles');

function register_widget_scripts()
{
	wp_register_script('elementor-addon-ns-script', plugins_url('assets/js/script.js?v=' . time(), __FILE__), array('jquery'), false);
	wp_enqueue_script('elementor-addon-ns-script');
}
add_action('elementor/frontend/after_register_scripts', 'register_widget_scripts');

function woo_search_product()
{
	$args = [
		'post_type' => 'product',
		'posts_per_page' => 16,
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => isset($_POST['paged']) ? $_POST['paged'] : 1,
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

function search_posts()
{
	$args = [
		'post_type' => 'post',
		'posts_per_page' => 16,
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => isset($_POST['paged']) ? $_POST['paged'] : 1,
	];

	$args = set_post_args($_POST, $args);

	$ajaxposts = new WP_Query($args);

	$response = '';

	if ($ajaxposts->have_posts()) {
		ob_start();
		while ($ajaxposts->have_posts()) : $ajaxposts->the_post(); ?>
    <div class="post-item">
    <div class="post-thumbnail">
      <a href="<?php echo get_the_permalink()  ?>">
        <?php echo get_the_post_thumbnail() ?>
      </a>
    </div>
    <div class="post-content">
      <div class="post-cats">
        <ul class="post-categories">
        <?php 
          $categories = get_the_category(); 
          foreach( $categories as $category ) : ?>
            <li>
              <a href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>" 
              alt="<?php echo esc_attr( sprintf( __( 'Ver todos os posts de %s', 'textdomain' ), $category->name ) ) ?>"><?php echo esc_html( $category->name ) ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <header class="header">
        <h2 class="post-title">
          <a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a>
        </h2>
      </header>
    </div>
  </div>
		<?php endwhile;
		$response = ob_get_clean();
	}

	return wp_send_json([
		'render' => $response,
		'found_posts' => $ajaxposts->found_posts,
		'post_count' => $ajaxposts->post_count,
	]);
}
add_action('wp_ajax_search_posts', 'search_posts');
add_action('wp_ajax_nopriv_search_posts', 'search_posts');

if (!function_exists('set_post_args')) {
	function set_post_args($post, $args) {
		if (isset($post['category'])) {
			$args['tax_query'] = array(
				array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => $post['category'],
				),
			);
		}
	
		if (isset($post['categories'])) {
			$args['tax_query'] = array(
				array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => $post['categories'],
				'operator' => 'IN',
				),
			);
		}
	
		if (isset($post['tags'])) {
			$args['tax_query'] = array(
				array(
				'taxonomy' => 'post_tag',
				'field' => 'slug',
				'terms' => $post['tags'],
				'operator' => 'IN',
				),
			);
		}
	
		if (isset($post['s'])) {
			$args['s'] = $post['s'];
		}
	
		return $args;
	}
}

function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Certificações', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Certificação', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Certificações', 'text_domain' ),
		'name_admin_bar'        => __( 'Certificações', 'text_domain' ),
		'archives'              => __( 'Arquivo', 'text_domain' ),
		'attributes'            => __( 'Atributos', 'text_domain' ),
		'parent_item_colon'     => __( 'Parente:', 'text_domain' ),
		'all_items'             => __( 'Todos', 'text_domain' ),
		'add_new_item'          => __( 'Adicionar nova certificação', 'text_domain' ),
		'add_new'               => __( 'Adicionar nova certificação', 'text_domain' ),
		'new_item'              => __( 'Adicionar nova certificação', 'text_domain' ),
		'edit_item'             => __( 'Editar certificação', 'text_domain' ),
		'update_item'           => __( 'Atualizar', 'text_domain' ),
		'view_item'             => __( 'Visualizar', 'text_domain' ),
		'view_items'            => __( 'Visualizar', 'text_domain' ),
		'search_items'          => __( 'Producrar', 'text_domain' ),
		'not_found'             => __( 'Não achado', 'text_domain' ),
		'not_found_in_trash'    => __( 'Não achado na lixeira', 'text_domain' ),
		'featured_image'        => __( 'Imagem de destaque', 'text_domain' ),
		'set_featured_image'    => __( '', 'text_domain' ),
		'remove_featured_image' => __( '', 'text_domain' ),
		'use_featured_image'    => __( '', 'text_domain' ),
		'insert_into_item'      => __( '', 'text_domain' ),
		'uploaded_to_this_item' => __( '', 'text_domain' ),
		'items_list'            => __( '', 'text_domain' ),
		'items_list_navigation' => __( '', 'text_domain' ),
		'filter_items_list'     => __( '', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Certificação', 'text_domain' ),
		'description'           => __( 'Certificações de Terceiros', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'cestificacoes', $args );

}
add_action( 'init', 'custom_post_type', 0 );