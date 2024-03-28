<?php
class Elementor_Carousel_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'carousel_widget';
  }

  public function get_title()
  {
    return esc_html__('Carrosel de imagem e texto', 'elementor-addon');
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

  public function get_style_depends()
    {
        return ['elementor-addon-ns-style'];
    }

    public function get_script_depends() {
		return [ 'elementor-addon-ns-script' ];
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
      'list_button',
      [
        'label' => esc_html__('Botão', 'textdomain'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('List Content', 'textdomain'),
        'show_label' => true,
      ]
    );

    $repeater->add_control(
			'website_link',
			[
				'label' => esc_html__( 'Link', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
				'label_block' => true,
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
      'background_color_first',
      [
        'label' => esc_html__('Cor de fundo 1º Slide', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#0C4D72',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-carousel .list-item:nth-child(1) .left' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'background_color_second',
      [
        'label' => esc_html__('Cor de fundo 2º Slide', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#0C4D72',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-carousel .list-item:nth-child(2) .left' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'text_color',
      [
        'label' => esc_html__('Cor do texto', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#fff',
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}} .custom-carousel .list-item .left .content .title' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Style Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    
    if ($settings['list']) : ?>
      <div class="custom-carousel">
        <div class="list-wrapper">
          <?php foreach ($settings['list'] as $index => $item) : ?>
            <div class="list-item list-item-<?php echo $item['_id'] ?>" style="<?php if($index > 0) echo 'display: none;' ?>">
              <div class="left">
                <div class="content">
                  <h2 class="title"><?php echo $item['list_title'] ?></h2>
                  <?php if ( ! empty( $item['website_link']['url'] ) ) : 
                    $this->add_link_attributes( 'website_link', $item['website_link'], true );
                  endif; ?>
                  <a <?php echo $this->get_render_attribute_string( 'website_link' ); ?>><?php echo $item['list_button'] ?></a>
                </div>
              </div>
              <div class="right">
                <img src="<?php echo $item['list_image']['url'] ?>" alt="<?php echo $item['list_image']['alt'] ?>">
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="controls">
            <button class="play">
              <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="13.5" cy="13.5" r="11.5" stroke="white" stroke-width="3"/>
                <path d="M18.7797 11.7441C20.1698 12.502 20.1698 14.498 18.7797 15.2559L11.4575 19.2486C10.1247 19.9753 8.5 19.0107 8.5 17.4927L8.5 9.50734C8.5 7.98934 10.1247 7.0247 11.4575 7.75141L18.7797 11.7441Z" fill="white"/>
              </svg>
            </button>
            <ul>
              <?php foreach ($settings['list'] as $index => $item) : ?> 
                <li class="list-item-<?php echo $item['_id'] ?> <?php if($index == 0) echo 'active' ?>">
                  <button data-index="<?php echo $index ?>">
                    <svg width="70" height="10" viewBox="0 0 70 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0.5" y="0.5" width="69" height="9" rx="2.5" stroke="white"/>
                    </svg>
                  </button>
                </li>
              <?php endforeach; ?>
            </ul>
        </div>  
      </div>
    <?php endif; ?>

  <?php
  }

  protected function content_template()
  {
  ?>
    <# if ( settings.list.length ) { #>
      <div class="custom-carousel">
        <div class="list-wrapper">
          <# _.each( settings.list, function( item, index ) { #>
            <div class="list-item list-item-{{ item._id }}" <# if (index > 0) { #> style="display: none" <# } #>>
              <div class="left">
                <div class="content">
                  <h2 class="title">{{{ item.list_title }}}</h2>
                  <a href="{{ item.website_link.url }}">{{{ item.list_button }}}</a>
                </div>
              </div>
              <div class="right">
                <img src="{{ item.list_image.url }}" alt="{{ item.list_image.alt }}">
              </div>
            </div>
          <# }); #>
        </div>
        <div class="controls">
            <button class="play">
              <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="13.5" cy="13.5" r="11.5" stroke="white" stroke-width="3"/>
                <path d="M18.7797 11.7441C20.1698 12.502 20.1698 14.498 18.7797 15.2559L11.4575 19.2486C10.1247 19.9753 8.5 19.0107 8.5 17.4927L8.5 9.50734C8.5 7.98934 10.1247 7.0247 11.4575 7.75141L18.7797 11.7441Z" fill="white"/>
              </svg>
            </button>
            <ul>
              <# _.each( settings.list, function( item, index ) { #>
                <li class="list-item-{{ item._id }}">
                  <button data-index="{{ index }}">
                    <svg width="70" height="10" viewBox="0 0 70 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0.5" y="0.5" width="69" height="9" rx="2.5" stroke="white"/>
                    </svg>
                  </button>
                </li>
              <# }); #>
            </ul>
        </div> 
      </div>
      <# } #>
      <?php
    }
  }
