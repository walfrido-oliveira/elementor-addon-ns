<?php
/**
 * Plugin Name: Elementor Addon para Novidade Saudável
 * Description: Elementos customizáveis para Novidade Saudável
 * Version:     1.0.1
 * Author:      BeeGo | Walfrido Oliveira
 * Author URI:  https://beego.dev
 * Text Domain: elementor-addon
 */

function register_elementor_ns_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/custom-title-widget.php' );
	require_once( __DIR__ . '/widgets/custom-text-widget.php' );
	require_once( __DIR__ . '/widgets/custom-button-widget.php' );
	require_once( __DIR__ . '/widgets/custom-list-widget.php' );
	require_once( __DIR__ . '/widgets/custom-accordion-widget.php' );
	require_once( __DIR__ . '/widgets/image-grid-widget.php' );
	require_once( __DIR__ . '/widgets/archor-widget.php' );

	$widgets_manager->register( new \Elementor_Custom_Title_Widget() );
	$widgets_manager->register( new \Elementor_Custom_Text_Widget() );
	$widgets_manager->register( new \Elementor_Custom_Button_Widget() );
	$widgets_manager->register( new \Elementor_Custom_List_Widget() );
	$widgets_manager->register( new \Elementor_Custom_Accordion_Widget() );
	$widgets_manager->register( new \Elementor_Image_Grid_Widget() );
	$widgets_manager->register( new \Elementor_Anchor_Widget() );

}
add_action( 'elementor/widgets/register', 'register_elementor_ns_widget');