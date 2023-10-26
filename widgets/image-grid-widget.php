<?php
class Elementor_Image_Grid_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'image_grid_widget';
  }

  public function get_title()
  {
    return esc_html__('Grid de Imagens (NS)', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-gallery-grid';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['grid', 'image'];
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
      'list_image',
      [
        'label' => esc_html__('Escolher imagem', 'textdomain'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );

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
          '{{WRAPPER}} {{CURRENT_ITEM}} .list-item .title' => 'color: {{VALUE}};',
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
          '{{WRAPPER}} {{CURRENT_ITEM}} .list-item .content' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Style Tab End


  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    Elementor_Image_Grid_Widget::get_style();
    
    if ($settings['list']) : ?>
      <div class="list-wrapper">
        <?php foreach ($settings['list'] as $item) : ?>
          <div class="list-item list-item-<?php echo $item['_id'] ?>">
            <img src="<?php echo $item['list_image']['url'] ?>" alt="<?php echo $item['list_image']['alt'] ?>">
            <h2 class="title"><?php echo $item['list_title'] ?></h2>
            <div class="content">
              <?php echo $item['list_content'] ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php
  }

  protected function content_template()
  {
    Elementor_Image_Grid_Widget::get_style();
  ?>
    <# if ( settings.list.length ) { #>
      <div class="list-wrapper">
        <# _.each( settings.list, function( item ) { #>
          <div class="list-item list-item-{{ item._id }}">
            <img src="{{ item.list_image.url }}" alt="{{ item.list_image.alt }}">
            <h2 class="title">{{{ item.list_title }}}</h2>
            <div class="content">{{{ item.list_content }}}</div>
          </div>
          <# }); #>
      </div>
      <# } #>
      <?php
    }

    public static function get_style()
    {
      ?>
        <style>
          .list-wrapper {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
          }

          @media (max-width: 787px) {
            .list-wrapper {
              display: grid;
              grid-template-columns: repeat(1, minmax(0, 1fr));
            }
          }

          .list-wrapper .list-item {
            padding: 1rem;
          }

          .list-wrapper .list-item img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 0.25vh;
            margin-top: 0.25vh;
            max-width: 20%;
            border-radius: 0;
            border: none;
          }

          .list-wrapper .list-item h2 {
            font-size: 24.8028px;
            text-align: center;
            padding-top: 2vh;
            padding-bottom: 0px;
            line-height: 1.1;
            font-weight: 700;
          }

          .list-wrapper .list-item .content {
            font-size: 18.6021px;
            text-align: center;
            padding-top: 0px;
            padding-bottom: 2vh;
            line-height: 1.1;
            font-weight: 400;
          }
        </style>
    <?php
    }
  }
