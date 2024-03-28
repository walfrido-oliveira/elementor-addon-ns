<?php
class Elementor_Topo_Bar_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'topo_bar_widget';
  }

  public function get_title()
  {
    return esc_html__('Top Bar', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-site-title';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['title', 'bar'];
  }

  public function get_style_depends()
  {
    return ['elementor-addon-ns-style'];
  }

  public function get_script_depends()
  {
    return ['elementor-addon-ns-script'];
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
        'default' => 'Use o cupom <strong>“LARANJA”</strong> para ter <strong>5%</strong> OFF no seu primeiro pedido no site!',
      ]
    );

    $this->add_control(
      'icon',
      [
        'label' => esc_html__('Ícone', 'textdomain'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
          'value' => 'fas fa-circle',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'circle',
            'dot-circle',
            'square-full',
          ],
          'fa-regular' => [
            'circle',
            'dot-circle',
            'square-full',
          ],
        ],
      ]
    );

    $this->end_controls_section();
    // Content Tab End
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
?>

    <div class="top-bar">
      <div class="my-icon-wrapper">
        <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
      </div>
      <div class="content"><?php echo $settings['title']; ?></div>
      <div class="close">
        <button>
          <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.847961 10.426L1.19476 10.7675L0.847961 10.426C0.0893442 11.1966 0.635202 12.5 1.71651 12.5C2.04772 12.5 2.36468 12.3652 2.59443 12.1266L6.14151 8.44341C6.33786 8.23952 6.66418 8.23914 6.861 8.44258L10.4292 12.1308C10.6575 12.3668 10.9718 12.5 11.3002 12.5C12.3753 12.5 12.918 11.2041 12.1638 10.4379L8.51574 6.73263C8.32436 6.53824 8.32411 6.22633 8.51517 6.03163L11.9203 2.56175C12.6731 1.79468 12.1296 0.5 11.0549 0.5C10.7243 0.5 10.4081 0.63499 10.1794 0.873715L6.87819 4.3196C6.682 4.52439 6.35495 4.52518 6.15777 4.32135L2.81714 0.867959C2.58964 0.632785 2.27644 0.5 1.94924 0.5C0.880071 0.5 0.338374 1.78702 1.08575 2.55159L4.48686 6.03096C4.67728 6.22576 4.67672 6.53714 4.4856 6.73126L0.847961 10.426Z" fill="white" stroke="white" />
          </svg>
        </button>
      </div>
    </div>

  <?php
  }

  protected function content_template()
  {
  ?>
    <# const iconHTML=elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden' : true }, 'i' , 'object' ); #>
      <div class="my-icon-wrapper">
        {{{ iconHTML.value }}}
      </div>
      {{ settings.title }}
  <?php
  }
}
