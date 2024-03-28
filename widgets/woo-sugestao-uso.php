<?php
class Elementor_Woo_Sugestao_Uso_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'Woo_Sugestao_Uso_widget';
  }

  public function get_title()
  {
    return esc_html__('Bloco de sugestão de uso', 'elementor-addon');
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

    $this->add_control(
      'title',
      [
        'label' => esc_html__('Tìtulo', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => '',
      ]
    );

    $this->add_control(
      'type_field',
      [
        'label' => esc_html__('Tipo de campo', 'textdomain'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'solid',
				'options' => [
					'sugestao_de_uso' => esc_html__( 'Sugestão de Uso', 'textdomain' ),
					'precaucoes'  => esc_html__( 'Precauções', 'textdomain' ),
				],
      ]
    );

    $this->end_controls_section();

    // Content Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $content = get_field($settings['type_field']);

?>

    <div class="woo-sugestao-uso close">
      <div class="title-wrapper">
        <div class="title">
          <h2><?php echo $settings['title'] ?></h2>
        </div>
        <div class="btn-wrapper">
          <button type="button" class="btn-open">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 3L15 27M27 15L3 15" stroke="white" stroke-width="5" stroke-linecap="round" />
            </svg>
          </button>
          <button type="button" class="btn-close">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.0001 2.99958L2.99993 16.9997M17.0001 16.9997L2.99993 2.99958" stroke="#CA4F16" stroke-width="5" stroke-linecap="round" />
            </svg>
          </button>
        </div>
      </div>
      <div class="content" style="display: none;"><?php echo $content ?></div>
    </div>

  <?php
  }

  protected function content_template()
  {
  ?>
    <div class="woo-sugestao-uso">
      <div class="title-wrapper">
        <div class="title"><h2>Sugestão de Uso</h2></div>
        <div class="btn"></div>
      </div>
      <div class="content">
        <p>Tomar 1 cápsula de 2 a 3 vezes ao dia, conforme necessário, preferencialmente com suco ou água em jejum. Armazenar em local fresco e seco após abrir.
          A coloração natural pode variar neste produto.</p>
      </div>
    </div>

<?php
  }
}
