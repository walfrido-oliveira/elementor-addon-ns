<?php
class Elementor_Custom_List_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'custom_list_widget';
  }

  public function get_title()
  {
    return esc_html__('Lista Customizada (NS)', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-bullet-list';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['list'];
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

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'list_content',
      [
        'label' => esc_html__('Conteúdo', 'textdomain'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => esc_html__('List Content', 'textdomain'),
        'show_label' => false,
      ]
    );

    $this->add_control(
      'list',
      [
        'label' => esc_html__('Lista', 'textdomain'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'prevent_empty' => false,
        'title_field' => '{{{ list_content }}}',
      ]
    );

    $this->end_controls_section();

    // Content Tab End


    // Style Tab Start
    $this->start_controls_section(
      'section_list_style',
      [
        'label' => esc_html__('Conteúdo', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'text_color',
      [
        'label' => esc_html__('Cor do texto', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#35184D',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-list-item' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'destaque_color',
      [
        'label' => esc_html__('Cor do destaque', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#C072A2',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-list-item .destaque' => 'color: {{VALUE}};',
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
      .custom-list-wrapper {
        list-style-type: disc;
      }

      .custom-list-wrapper .custom-list-item, .custom-list-wrapper .custom-list-item  *  {
        font-size: 18.6021px;
        text-align: left;
        padding-top: 2vh;
        padding-bottom: 2vh;
        line-height: 1.1;
        font-weight: 500;
        font-family: Montserrat,sans-serif;
      }
    </style>

    <?php if ($settings['list']) : ?>
      <ul class="custom-list-wrapper">
        <?php foreach ($settings['list'] as $item) : ?>
          <li class="custom-list-item">
            <?php echo $item['list_content'] ?>
          </li>
        <?php endforeach; ?>
        </ul>
      <?php endif; ?>

  <?php
  }
}
