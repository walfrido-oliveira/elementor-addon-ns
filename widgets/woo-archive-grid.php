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
          <div class="button-filter-toggle-mobile">
            <button type="button">
              <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 1.5C0 1.22386 0.223858 1 0.5 1H14.5C14.7761 1 15 1.22386 15 1.5V2.5C15 2.77614 14.7761 3 14.5 3H0.5C0.223858 3 0 2.77614 0 2.5V1.5Z" fill="#333333"/>
                <path d="M6.5 4C6.22386 4 6 3.77614 6 3.5V0.5C6 0.223858 6.22386 5.57818e-08 6.5 4.37112e-08L7.5 0C7.77614 -1.20706e-08 8 0.223858 8 0.5V3.5C8 3.77614 7.77614 4 7.5 4H6.5Z" fill="#333333"/>
                <path d="M10.5 9C10.2239 9 10 8.77614 10 8.5V5.5C10 5.22386 10.2239 5 10.5 5H11.5C11.7761 5 12 5.22386 12 5.5V8.5C12 8.77614 11.7761 9 11.5 9H10.5Z" fill="#333333"/>
                <path d="M2.5 14C2.22386 14 2 13.7761 2 13.5L2 10.5C2 10.2239 2.22386 10 2.5 10H3.5C3.77614 10 4 10.2239 4 10.5V13.5C4 13.7761 3.77614 14 3.5 14H2.5Z" fill="#333333"/>
                <path d="M0 6.5C0 6.22386 0.223858 6 0.5 6H14.5C14.7761 6 15 6.22386 15 6.5V7.5C15 7.77614 14.7761 8 14.5 8H0.5C0.223858 8 0 7.77614 0 7.5V6.5Z" fill="#333333"/>
                <path d="M0 11.5C0 11.2239 0.223858 11 0.5 11H14.5C14.7761 11 15 11.2239 15 11.5V12.5C15 12.7761 14.7761 13 14.5 13H0.5C0.223858 13 0 12.7761 0 12.5V11.5Z" fill="#333333"/>
              </svg>
              Filtro
            </button>
          </div>
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
