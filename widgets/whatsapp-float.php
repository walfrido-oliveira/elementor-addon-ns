<?php
class Elementor_Whatsapp_Float_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'whatsapp_float_widget';
  }

  public function get_title()
  {
    return esc_html__('Botão Whatsapp Flutuante', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-share';
  }

  public function get_categories()
  {
    return ['basic', 'whatsapp'];
  }

  public function get_keywords()
  {
    return ['whatsapp'];
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

    $this->add_control(
      'phone',
      [
        'label' => esc_html__('Telefone', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => '',
      ]
    );

    $this->end_controls_section();

    // Content Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display(); ?>

    <div class="whatsapp-float">
      <div class="whatsapp-wrapper">
        <a href="https://wa.me/<?php echo $settings["phone"] ?>" target="_blank" aria-label="Abrir WhatsApp"></a>
      </div>
    </div>

  <?php
  }

  protected function content_template()
  {
  ?>
    <div class="whatsapp-float">
      <div class="whatsapp-wrapper">
        <a href="https://wa.me/{{{ settings.phone }}}" target="_blank" aria-label="Abrir WhatsApp"></a>
      </div>
    </div>
    <?php
  }
}
