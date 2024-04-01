<?php
class Elementor_Posts_Filters_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'posts-filters_widget';
  }

  public function get_title()
  {
    return esc_html__('Adicona filtros de posts', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-checkout';
  }

  public function get_categories()
  {
    return ['basic', 'posts'];
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

    if(isset(get_queried_object()->term_id)) {
      $term_id = get_queried_object()->term_id;
    }

?>
    <div class="posts-filters">
      <div class="posts-filters-wrapper">
        <form class="posts-ordering" method="get">
          <div class="filter-group">
            <h3>Filtro</h3>
            <div class="search-filter">
              <label class="elementor-screen-only" for="s">Pesquisar</label>
              <input type="text" name="s" id="s" placeholder="Procurar artigos" value="<?php if (isset($_GET['s'])) echo $_GET['s'] ?>">
              <button type="button" aria-label="Pesquisar">
                <i aria-hidden="true" class="fas fa-search"></i>
                <span class="elementor-screen-only">Pesquisar</span>
              </button>
            </div>
          </div>
          <div class="filter-group">
            <div class="dropdown-check-list">
              <span class="anchor">Tags</span>
              <?php
              $args = array(
                'orderby'    => 'slug',
                'hide_empty' => false,
              );
              $product_tags = get_terms('post_tag', $args);
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
              <span class="anchor">Categoria</span>
              <?php
              $categories = get_terms("category", array(
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
    <div class="posts-filters">
      <div class="posts-filters-wrapper">
        <form class="posts-ordering" method="get">
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
