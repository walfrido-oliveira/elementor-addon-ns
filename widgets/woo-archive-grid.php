<?php
class Elementor_Woo_Archive_Grid_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'woo-archive-grid_widget';
  }

  public function get_title()
  {
    return esc_html__('Grid de produtos para tela de Arquivo', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-gallery-grid';
  }

  public function get_categories()
  {
    return ['basic', 'woo'];
  }

  public function get_keywords()
  {
    return ['products'];
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
    global $woocommerce, $product, $wp_query;

    $settings = $this->get_settings_for_display();

    if (have_posts()) : ?>

      <style>
        .woo-archive-grid .woo-archive-grid-wrapper {
          grid-template-columns: repeat(<?php echo $settings['columns'] ?>, 1fr);
        }
      </style>

      <div class="woo-archive-grid">
        <div class="woocommerce-result-count">
          <p>Mostrando <span id="post_count"><?php echo $wp_query->post_count ?></span> de <span id="found_posts"><?php echo $wp_query->found_posts ?></span> Produtos</p>
        </div>
        <div class="woo-archive-grid-wrapper">
          <?php while (have_posts()) :
            the_post();
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
            <?php endif; ?>
          <?php endwhile; ?>
        </div>
        <?php if($wp_query->post_count < $wp_query->found_posts) : ?>
        <div class="woo-read-more">
          <a href="#">Mostrar Mais
            <span class="fas fa-spinner eicon-animation-spin" style="display: none;">
          </a>
          </span>
        </div>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <p class="product-not-found">Nenhum produto foi encontrado para a atual pesquisa.</p>
    <?php endif; ?>

  <?php
  }

  protected function content_template()
  {
  ?>
    <div class="woo-archive-grid">
      <div class="woo-archive-grid-wrapper">
      </div>
    </div>
<?php
  }
}
