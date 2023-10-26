<?php
class Elementor_Custom_Title_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'custom_title_widget';
  }

  public function get_title()
  {
    return esc_html__('Titulo Customizado (NS)', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-t-letter';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['title', 'world'];
  }

  protected function register_controls()
  {

    // Content Tab Start

    $this->start_controls_section(
      'section_title',
      [
        'label' => esc_html__('Titulo', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => esc_html__('Texto', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => '<span class="destaque">Recupere</span> Sua fertilidade em <span class="destaque">60</span> dias',
      ]
    );

    $this->end_controls_section();

    // Content Tab End


    // Style Tab Start

    $this->start_controls_section(
      'section_title_style',
      [
        'label' => esc_html__('Titulo', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'titulo_color',
      [
        'label' => esc_html__('Cor', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .titulo' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Style Tab End

    // Style Tab Start

    $this->start_controls_section(
      'section_destaque_style',
      [
        'label' => esc_html__('Destaque', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'destaque_color',
      [
        'label' => esc_html__('Cor', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#C072A2',
        'selectors' => [
          '{{WRAPPER}} .titulo .destaque' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Style Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
?>

    <style>
      .elementor-widget-custom_title_widget h1.titulo {
        font-size: 2.64vw;
        text-align: center;
        padding-top: 2vh;
        padding-bottom: 2vh;
        line-height: 1.1;
        font-weight: 800;
        font-family: Montserrat, sans-serif;
      }

      @media (max-width:767px) {
        .elementor-widget-custom_title_widget h1.titulo {
          font-size: 7.50vw;
          padding-top: 1.5vh;
          padding-bottom: 1.5vh;
          text-align: center;
        }
      }
    </style>

    <h1 class="titulo">
      <?php echo $settings['title']; ?>
    </h1>

<?php
  }
}
