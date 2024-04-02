<?php
class Elementor_Woo_Filters_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'woo-filters_widget';
  }

  public function get_title()
  {
    return esc_html__('Adicona filtros de produtos', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-checkout';
  }

  public function get_categories()
  {
    return ['basic', 'woo'];
  }

  public function get_keywords()
  {
    return ['products', 'filter'];
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



    $this->end_controls_section();

    // Content Tab End

  }

  protected function render()
  {
    global $wp_query;

    $settings = $this->get_settings_for_display();
    $term_id = "";

    if (isset(get_queried_object()->term_id)) {
      $term_id = get_queried_object()->term_id;
    }

    $filters = [
      "popularity" => "Mais Vendidos",
      "date" => "Ordenar por mais recente",
      "price" => "Menor Preço",
      "price-desc" => "Maior Preço",
      "title" => "A - Z",
      "title_desc" => "Z - A",
    ];

    $product_cat = isset($wp_query->query["product_cat"]) ? $wp_query->query["product_cat"] : null;

?>
    <div class="woo-filters">
      <div class="woo-filters-wrapper">
        <div class="close-filter-mobile">
          <button type="button">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1.42714 9.72487C0.873645 10.2948 1.27752 11.25 2.07201 11.25C2.31843 11.25 2.55405 11.1488 2.72376 10.9702L5.82359 7.70677C6.11882 7.39597 6.61403 7.3954 6.90997 7.70553L10.0286 10.9736C10.197 11.1501 10.4304 11.25 10.6743 11.25C11.4633 11.25 11.8643 10.3015 11.3147 9.73557L8.09011 6.41498C7.80784 6.12431 7.80746 5.662 8.08926 5.37087L11.0962 2.26434C11.6447 1.69762 11.2431 0.75 10.4544 0.75C10.2088 0.75 9.97394 0.85118 9.80522 1.02973L6.92583 4.07699C6.63087 4.38915 6.13453 4.39035 5.83807 4.07963L2.92373 1.0252C2.75604 0.849444 2.52371 0.75 2.28079 0.75C1.49688 0.75 1.09696 1.69112 1.64106 2.25545L4.6445 5.37056C4.92533 5.66183 4.92451 6.12336 4.64264 6.41362L1.42714 9.72487Z" fill="#333333" stroke="#333333" stroke-width="0.5" />
            </svg>
            Fechar Filtro
          </button>
        </div>
        <form class="woocommerce-ordering" method="get">
          <div class="filter-group">
            <label for="orderby">Ordena por</label>
            <select name="orderby" id="orderby" class="woo-orderby" aria-label="Pedido da loja">
              <?php foreach ($filters as $key => $value) : ?>
                <option value="<?php echo $key ?>" <?php if (isset($_GET['orderby'])) : if ($_GET['orderby'] == $key) : ?> selected="selected" <?php endif;
                                                                                                                                            endif; ?>><?php echo $value ?></option>
              <?php endforeach; ?>
            </select>
            <input type="hidden" name="product_cat" id="product_cat" value="<?php echo $product_cat ?>">
          </div>
          <div class="filter-group">
            <h3>Filtro</h3>
            <div class="search-filter">
              <label class="elementor-screen-only" for="s">Pesquisar</label>
              <input type="text" name="s" id="s" placeholder="Procurar produtos" value="<?php if (isset($_GET['s'])) echo $_GET['s'] ?>">
              <button type="button" aria-label="Pesquisar">
                <i aria-hidden="true" class="fas fa-search"></i>
                <span class="elementor-screen-only">Pesquisar</span>
              </button>
            </div>
          </div>
          <div class="filter-group">
            <div class="dropdown-check-list">
              <span class="anchor">Atributos</span>
              <?php
              $args = array(
                'orderby'    => 'slug',
                'hide_empty' => false,
              );
              $product_tags = get_terms('product_tag', $args);
              ?>
              <ul class="items tags">
                <?php foreach ($product_tags as $key => $tag) : ?>
                  <li>
                    <label class="custom-checkbox"><?php echo $tag->name ?>
                      <input class="tag" type="checkbox" name="tag_<?php echo $tag->slug ?>" id="tag_<?php echo $tag->slug ?>" value="<?php echo $tag->slug ?>" />
                      <span class="checkmark"></span>
                    </label>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="dropdown-check-list">
              <span class="anchor">Ajuda com</span>
              <?php
              $categories = get_terms("product_cat", array(
                'parent'    => $term_id,
                'hide_empty' => false,
              ));
              ?>
              <ul class="items categories">
                <?php foreach ($categories as $key => $category) : ?>
                  <li>
                    <label class="custom-checkbox"><?php echo $category->name ?>
                      <input class="category" type="checkbox" name="category_<?php echo $category->slug ?>" id="category_<?php echo $category->slug ?>" value="<?php echo $category->slug ?>" />
                      <span class="checkmark"></span>
                    </label>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </form>
      </div>
    </div>

  <?php
  }

  protected function content_template()
  {
  ?>
    <div class="woo-filters">
      <div class="woo-filters-wrapper">
        <form class="woocommerce-ordering" method="get">
          <div class="filter-group">
            <select name="orderby" class="orderby" aria-label="Pedido da loja">
              <option value="menu_order">Ordenação padrão</option>
              <option value="popularity">Ordenar por popularidade</option>
              <option value="date">Ordenar por mais recente</option>
              <option value="price" selected="selected">Ordenar por preço: menor para maior</option>
              <option value="price-desc">Ordenar por preço: maior para menor</option>
            </select>
          </div>
          <div class="filter-group">
            <h3>Filtro</h3>
            <div class="search-filter">
              <label class="elementor-screen-only" for="s">Pesquisar</label>
              <input type="text" name="s" id="s" placeholder="Procurar produtos" value="<?php if (isset($_GET['s'])) echo $_GET['s'] ?>">
              <button type="button" aria-label="Pesquisar">
                <i aria-hidden="true" class="fas fa-search"></i>
                <span class="elementor-screen-only">Pesquisar</span>
              </button>
            </div>
          </div>
          <div class="filter-group">
          </div>
        </form>
      </div>
    </div>
<?php
  }
}
