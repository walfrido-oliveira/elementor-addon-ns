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
    global $woocommerce, $product, $wp_query;

    $settings = $this->get_settings_for_display();
    $term_id = "";

    if(isset(get_queried_object()->term_id)) {
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
        <form class="woocommerce-ordering" method="get">
          <div class="filter-group">
            <label for="orderby">Ordena por</label>
            <select name="orderby" id="orderby" class="woo-orderby" aria-label="Pedido da loja">
              <?php foreach ($filters as $key => $value) : ?>
                <option value="<?php echo $key ?>" <?php if (isset($_GET['orderby'])) : if ($_GET['orderby'] == $key) : ?> selected="selected" <?php endif; endif; ?>><?php echo $value ?></option>
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
