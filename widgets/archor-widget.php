<?php
class Elementor_Anchor_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'archor_widget';
  }

  public function get_title()
  {
    return esc_html__('Âncora (NS)', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-anchor';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['anchor'];
  }

  protected function register_controls()
  {

    // Content Tab Start

    $this->start_controls_section(
      'section_anchor',
      [
        'label' => esc_html__('Identificação', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'anchor',
      [
        'label' => esc_html__('ID', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => '',
      ]
    );

    $this->end_controls_section();

    // Content Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
?>

    <style>
      html {
        scroll-behavior: smooth;
      }
    </style>
    <span id="<?php echo $settings['anchor'] ?>"> </span>

<?php
  }
}
