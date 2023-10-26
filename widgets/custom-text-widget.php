<?php
class Elementor_Custom_Text_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'custom_text_widget';
  }

  public function get_title()
  {
    return esc_html__('Texto Customizado (NS)', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-text';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['text', 'world'];
  }

  protected function register_controls()
  {

    // Content Tab Start

    $this->start_controls_section(
      'section_text',
      [
        'label' => esc_html__('Texto', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'text',
      [
        'label' => esc_html__('Texto', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => 'O protocolo que <span class="destaque">possibilita a maternidade</span> sem precisar de hormônios, remédios ou cirugia',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_tag',
      [
        'label' => esc_html__('Tag', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'tag',
      [
        'label' => esc_html__('Selecionar Tag', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'h2',
        'options' => [
          'h1' => esc_html__('h1', 'elementor-addon'),
          'h2' => esc_html__('h2', 'elementor-addon'),
          'h3' => esc_html__('h3', 'elementor-addon'),
          'h4'  => esc_html__('h4', 'elementor-addon'),
          'h5' => esc_html__('h5', 'elementor-addon'),
          'p' => esc_html__('p', 'elementor-addon'),
        ],
      ]
    );

    $this->end_controls_section();

    // Content Tab End


    // Style Tab Start

    $this->start_controls_section(
      'section_text_style',
      [
        'label' => esc_html__('Texto', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'texto_color',
      [
        'label' => esc_html__('Cor', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .texto' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'texto_size',
      [
        'label' => esc_html__('Tamanho', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '1.32vw',
        'options' => [
          '1.32vw' => esc_html__('Padrão', 'elementor-addon'),
          '2.64vw' => esc_html__('Grande', 'elementor-addon'),
          '0.99vw'  => esc_html__('Pequeno', 'elementor-addon'),
        ],
        'selectors' => [
          '{{WRAPPER}} .texto' => 'font-size: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'texto_weight',
      [
        'label' => esc_html__('Peso', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '500',
        'options' => [
          '500' => esc_html__('Padrão', 'elementor-addon'),
          '700' => esc_html__('Negrito', 'elementor-addon'),
          '900'  => esc_html__('Extra Negrito', 'elementor-addon'),
        ],
        'selectors' => [
          '{{WRAPPER}} .texto' => 'font-weight: {{VALUE}};',
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
          '{{WRAPPER}} .texto .destaque' => 'color: {{VALUE}};',
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
      .elementor-widget-custom_text_widget <?php echo $settings['tag']; ?>.texto {
        font-size: 1.32vw;
        text-align: center;
        padding-top: 2vh;
        padding-bottom: 2vh;
        line-height: 1.1;
        font-weight: 500;
        font-family: Montserrat, sans-serif;
      }

      @media (max-width:767px) {
        .elementor-widget-custom_text_widget h1.texto {
          font-size: 5.60vw !important;
          padding-top: 3.75vh;
          padding-bottom: 1.5vh;
          text-align: center;
        }

        .elementor-widget-custom_text_widget h2.texto {
          font-size: 4.50vw !important;
          padding-top: 1.5vh;
          padding-bottom: 1.5vh;
          text-align: center;
        }

        .elementor-widget-custom_text_widget h3.texto {
          font-size: 4.00vw !important;
          padding-top: 1.5vh;
          padding-bottom: 1.5vh;
          text-align: center;
        }
      }
    </style>

    <<?php echo $settings['tag']; ?> class="texto">
      <?php echo $settings['text']; ?>
    </<?php echo $settings['tag']; ?>>

<?php
  }
}
