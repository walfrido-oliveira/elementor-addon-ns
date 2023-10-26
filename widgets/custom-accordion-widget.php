<?php
class Elementor_Custom_Accordion_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'custom_accordion_widget';
  }

  public function get_title()
  {
    return esc_html__('Accordion Customizado (NS)', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-toggle';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['accordion'];
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
      'list_title',
      [
        'label' => esc_html__('Titulo', 'textdomain'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Título Maneiro', 'textdomain'),
        'label_block' => true,
      ]
    );

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
        'title_field' => '{{{ list_title }}}',
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
      'title_color',
      [
        'label' => esc_html__('Cor Titulo', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#C072A2',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-accordion-item .title button' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'text_color',
      [
        'label' => esc_html__('Cor do texto', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#35184D',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-accordion-item .content' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'background_title_color',
      [
        'label' => esc_html__('Cor de fundo do título', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#C072A2',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-accordion-item .title' => 'background-color: {{VALUE}};',
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-accordion-item .title button' => 'background-color: {{VALUE}};',
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-accordion-item .title button:hover' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'background_content_color',
      [
        'label' => esc_html__('Cor de fundo do conteúdo', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#C072A2',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-accordion-item .content' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Style Tab End


  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    Elementor_Custom_Accordion_Widget::getStyle();

    if ($settings['list']) : ?>
      <div class="accordion-wrapper">
        <?php foreach ($settings['list'] as $item) : ?>
          <div class="custom-accordion-item">
            <div class="title">
              <button> <?php echo $item['list_title'] ?></button>
              <img src="https://img.imageboss.me/atm/height/16/blend-mode:in,blend-color:ffffff/assets/right.svg" alt="">
            </div>
            <div class="content"><?php echo $item['list_content'] ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif;

    Elementor_Custom_Accordion_Widget::getScript();
  }

  protected function content_template()
  {
    Elementor_Custom_Accordion_Widget::getStyle();
    ?>
    <# if ( settings.list.length ) { #>
      <div class="accordion-wrapper">
        <# _.each( settings.list, function( item ) { #>
          <div class="custom-accordion-item custom-accordion-item-{{ item._id }}">
            <div class="title">
              <button class="title">{{{ item.list_title }}}</button>
              <img src="https://img.imageboss.me/atm/height/16/blend-mode:in,blend-color:ffffff/assets/right.svg" alt="">
            </div>
            <div class="content">{{{ item.list_content }}}</div>
          </div>
          <# }); #>
      </div>
      <# } #>
      <?php
      Elementor_Custom_Accordion_Widget::getScript();
    }

    public static function getStyle()
    {
      ?>
        <style>
          .accordion-wrapper .custom-accordion-item {
            padding: 1rem;
          }

          .accordion-wrapper .custom-accordion-item .title {
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0px;
            padding: 10px 15px;
            width: 100%;
          }

          .accordion-wrapper .custom-accordion-item .title:hover {
            filter: brightness(1.25);
          }

          .accordion-wrapper .custom-accordion-item .title button:hover {
            filter: none;
          }

          .accordion-wrapper .custom-accordion-item .title button {
            border: 0px;
            font-weight: 600;
            width: 100%;
            white-space: break-spaces;
            text-align: left;
          }

          .accordion-wrapper .custom-accordion-item .title button:focus {
            outline: 0px;
          }

          .accordion-wrapper .custom-accordion-item .title.active img {
            transform: rotate(90deg);
          } 

          .accordion-wrapper .custom-accordion-item .title:hover,
          .accordion-wrapper .custom-accordion-item .title.active {
            filter: brightness(1.25);
          }

          .accordion-wrapper .custom-accordion-item .content {
            overflow: hidden;
            margin-bottom: 8px;
            margin-top: 0px;
            padding: 6px 20px 6px 20px;
            transition: all 0.2s ease-in-out;
            font-size: 16px;
            display: none;
            width: 100%;
          }
        </style>
      <?php
    }

    public static function getScript()
    {
      ?>
        <script>
          jQuery(".custom-accordion-item .title").each(function(i) {

          });

          jQuery(".custom-accordion-item .title").on("click", function() {
            jQuery(this).toggleClass("active");
            jQuery(this).next().slideToggle("fast");
          });
        </script>
    <?php
    }
  }
