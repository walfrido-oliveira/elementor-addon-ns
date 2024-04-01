<?php
class Elementor_Posts_Archive_Grid_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'posts-archive-grid_widget';
  }

  public function get_title()
  {
    return esc_html__('Grid de posts para tela de Arquivo', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-gallery-grid';
  }

  public function get_categories()
  {
    return ['basic', 'posts'];
  }

  public function get_keywords()
  {
    return ['posts'];
  }

  protected function register_controls()
  {

    // Content Tab Start

    $this->start_controls_section(
      'section_archive',
      [
        'label' => esc_html__('Layout', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'columns',
      [
        'label' => esc_html__('Colunas', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 4,
        'step' => 1,
        'default' => 3,
      ]
    );

    $this->end_controls_section();

    // Content Tab End

  }

  protected function render()
  {
    global $wp_query;

    $settings = $this->get_settings_for_display();

    if (have_posts()) : ?>

      <style>
        .posts-archive-grid .posts-archive-grid-wrapper {
          grid-template-columns: repeat(<?php echo $settings['columns'] ?>, 1fr);
        }
      </style>

      <div class="posts-archive-grid">
        <div class="posts-result-count">
          <p>Mostrando <span id="post_count"><?php echo $wp_query->post_count ?></span> de <span id="found_posts"><?php echo $wp_query->found_posts ?></span> Artigos</p>
        </div>
        <div class="posts-archive-grid-wrapper">
          <?php while (have_posts()) :
            the_post(); ?>
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
          <?php endwhile; ?>
        </div>
        <?php if ($wp_query->post_count < $wp_query->found_posts) : ?>
          <div class="post-read-more">
            <a href="#">Mostrar Mais
              <span class="fas fa-spinner eicon-animation-spin" style="display: none;">
            </a>
            </span>
          </div>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <p class="product-not-found">Nenhum artigo foi encontrado para a atual pesquisa.</p>
    <?php endif; ?>

  <?php
  }

  protected function content_template()
  {
  ?>
    <div class="posts-archive-grid">
      <div class="posts-archive-grid-wrapper">
      </div>
    </div>
<?php
  }
}
