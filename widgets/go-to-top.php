<?php
class Elementor_go_to_top_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'go-to-top_widget';
  }

  public function get_title()
  {
    return esc_html__('Botão de ir para topo', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-favorite';
  }

  public function get_categories()
  {
    return ['basic', 'button'];
  }

  public function get_keywords()
  {
    return ['button'];
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
    $settings = $this->get_settings_for_display(); ?>

    <div class="go-to-top">
      <div class="go-to-top-wrapper" role="button">
        <svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5.7987 1.02981L1.04558 5.59508M5.7987 1.02981L1.04558 5.59508M5.7987 1.02981C6.18712 0.656731 6.81287 0.656731 7.2013 1.02981L11.9544 5.59508C12.3485 5.97361 12.3485 6.59166 11.9544 6.97019C11.566 7.34327 10.9402 7.34327 10.5518 6.97019L6.5 3.07851L2.44818 6.97019C2.05976 7.34327 1.43401 7.34327 1.04558 6.97019C0.651474 6.59166 0.651474 5.97361 1.04558 5.59508M5.7987 1.02981L1.04558 5.59508" fill="#340D8E" stroke="#340D8E" stroke-width="0.5" />
        </svg>
        <span>Topo</span>
      </div>
    </div>

  <?php
  }

}
