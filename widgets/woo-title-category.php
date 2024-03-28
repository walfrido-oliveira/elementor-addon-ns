<?php
class Elementor_Woo_Title_Category_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'Woo_Title_Category_widget';
  }

  public function get_title()
  {
    return esc_html__('Mostra título da Categoria do produto', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-t-letter';
  }

  public function get_categories()
  {
    return ['basic', 'woo'];
  }

  public function get_keywords()
  {
    return ['woo'];
  }

  protected function register_controls()
  {

    // Content Tab Start

    $this->start_controls_section(
      'content_section',
      [
        'label' => esc_html__('Conteúdo', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->end_controls_section();

    // Content Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display(); 
    $title = "";
    $id = "";

    if(isset(get_queried_object()->term_id)) {
      $title = get_the_category_by_ID(get_queried_object()->term_id);
      $id = get_queried_object()->term_id;
    }
    ?>

    <style>
      .woo-title_category.category-<?php echo $id ?> h1 {
        color: <?php echo get_field('cor_do_titulo', "product_cat_$id"); ?>
      }
    </style>
    
    <div class="elementor-widget-container woo-title_category category-<?php echo $id ?>">
      <h1 class="elementor-heading-title elementor-size-default"><?php echo $title ?></h1>
    </div>

  <?php
  }

  protected function content_template()
  {
  ?>
    <div class="elementor-widget-container">
      <h1 class="elementor-heading-title elementor-size-default">Suplementos</h1>
    </div>
<?php
  }
}
