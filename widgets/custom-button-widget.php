<?php
class Elementor_Custom_Button_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'custom_button_widget';
  }

  public function get_title()
  {
    return esc_html__('Botão Customizado (NS)', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-button';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['button'];
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
        'default' => ' EU QUERO RESTAURAR MINHA FERTILIDADE'
      ]
    );

    $this->add_control(
			'website_link',
			[
				'label' => esc_html__( 'Link de destino', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
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
      'button_color',
      [
        'label' => esc_html__('Cor', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .custom-button' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_background_color',
      [
        'label' => esc_html__('Fundo', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '1.32vw',
        'default' => '#64a73f',
        'selectors' => [
          '{{WRAPPER}} .custom-button' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Style Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    if ( ! empty( $settings['website_link']['url'] ) ) {
			$this->add_link_attributes( 'website_link', $settings['website_link'] );
		}
?>

    <style>
      .elementor-widget-custom_button_widget a.custom-button {
        background-color: #64a73f;
        border-radius: 4px;
        border: none;
        color: #ffffff;
        padding: 16px 32px 16px 32px;
        font-weight: 600;
        display: block;
        width: fit-content;
        text-align: center;
        margin: 5vh auto 2vh auto;
        font-size: 18px;
        box-sizing: border-box;
        max-width: 100%;
        transition: all 0.5s ease-in-out;

        animation-name: pulsing_MQhRFX4394448;
        animation-duration: 1s;
        animation-timing-function: ease-out;
        animation-iteration-count: infinite;
      }

      @keyframes pulsing_MQhRFX4394448 {
        0% {
          box-shadow: 0 0 0 0 <?php echo $settings['button_background_color'] ?>e1
        }

        80% {
          box-shadow: 0 0 0 12px <?php echo $settings['button_background_color'] ?>00
        }
      }
    </style>

    <div class="elementor-button-wrapper">
      <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-grow custom-button" 
      <?php echo $this->get_render_attribute_string( 'website_link' ); ?>>
        <span class="elementor-button-content-wrapper">
          <span class="elementor-button-text"><?php echo $settings['text']; ?></span>
        </span>
      </a>
    </div>

<?php
  }
}
