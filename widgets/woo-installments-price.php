<?php
class Elementor_Woo_installments_price_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'woo-installments_price_widget';
  }

  public function get_title()
  {
    return esc_html__('Preço parcelado do Woocomerce', 'elementor-addon');
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
    return ['products', 'installments', 'price'];
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
      'installments',
      [
        'label' => esc_html__('Parcelas', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 12,
        'step' => 1,
        'default' => 3,
      ]
    );

    $this->end_controls_section();

    // Content Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $id = get_the_ID();

    global $product;

    $product = wc_get_product($id);

    if (!$product) return; 
    
    $price = $product->get_price();
    $installment = $price / $settings['installments']; ?>

    <div class="installments-price">
      <div class="content">
        Em até <strong><?php echo $settings['installments'] ?></strong> de <strong><?php echo wc_price($installment) ?></strong>
      </div>
    </div>
<?php
  }
}
