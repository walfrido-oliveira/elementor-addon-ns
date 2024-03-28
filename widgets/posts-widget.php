<?php
class Elementor_Posts_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'posts_widget';
  }

  public function get_title()
  {
    return esc_html__('Posts em blocos', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-gallery-grid';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['grid', 'post'];
  }

  protected function register_controls()
  {

    $posts = get_posts([
      'post_type'  => 'post'
    ]);

    foreach ($posts as $post) {
      $options[$post->ID] = $post->post_title;
    }

    // Content Tab Start

    $this->start_controls_section(
      'content_section',
      [
        'label' => esc_html__('Conteúdo', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'posts',
      [
        'label' => esc_html__('Posts', 'textdomain'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'label_block' => true,
        'multiple' => true,
        'options' => $options,
        'default' => ['title', 'description'],
      ]
    );

    $this->add_control(
      'position',
      [
        'label' => esc_html__('Posição', 'textdomain'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'solid',
				'options' => [
					'first' => esc_html__( 'Primeiro maior', 'textdomain' ),
					'second'  => esc_html__( 'Segundo maior', 'textdomain' ),
				],
      ]
    );

    $this->end_controls_section();

    // Content Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();

    if ($settings['posts']) : ?>
      <div class="posts">
        <?php foreach ($settings['posts'] as $index => $item) : ?>
          <div class="post-wrapper post-item-<?php echo $index ?> <?php if($settings['position'] == 'first' && $index == 0) echo 'featured' ?> <?php if($settings['position'] == 'second' && $index == 1) echo 'featured' ?>">
            <div class="post">
              <div class="thumb">
                <a href="<?php echo get_permalink($item) ?>"><?php echo get_the_post_thumbnail($item) ?></a>
              </div>
              <div class="post-content">
                <div class="post-cats">
                  <ul class="post-categories">
                  <?php 
                    $categories = get_the_category($item); 
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
                    <a href="<?php echo get_permalink($item) ?>"><?php echo get_the_title($item) ?></a>
                  </h2>
                </header>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php
  }

  protected function content_template()
  {
  ?>
    <# if ( settings.list.length ) { #>
      <div class="posts">
        <# _.each( settings.list, function( item, index ) { #>
          <div class="post-wrapper post-item-{{ index }}">
              <div class="post">
                <div class="thumb"></div>
                <div class="post-content">
                  <div class="post-cats">
                    
                  </div>
                  <header class="header">
                    <h2 class="post-title"></h2>
                  </header>
                </div>
              </div>
          </div>
          <# }); #>
      </div>
      <# } #>
    <?php
  }
}
