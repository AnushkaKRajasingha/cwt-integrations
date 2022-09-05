<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Cwt_Integrations
 * @subpackage Cwt_Integrations/slick
 */

/**
 * The slickintegration functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the public-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Cwt_Integrations
 * @subpackage Cwt_Integrations/slick
 * @author     Anushka <wordpress@anushka.pro>
 */
class Cwt_Integrations_Slick {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $cwt_integrations    The ID of this plugin.
	 */
	private $cwt_integrations;

	/**
	 * The unique prefix of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_prefix    The string used to uniquely prefix technical functions of this plugin.
	 */
	private $plugin_prefix;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $cwt_integrations      The name of the plugin.
	 * @param      string $plugin_prefix          The unique prefix of this plugin.
	 * @param      string $version          The version of this plugin.
	 */
	public function __construct( $cwt_integrations, $plugin_prefix, $version ) {

		$this->cwt_integrations   = $cwt_integrations;
		$this->plugin_prefix = $plugin_prefix;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

       wp_enqueue_style( $this->cwt_integrations.'_slick', plugin_dir_url( __FILE__ ) . 'css/slick.css', array(), $this->version, 'all' );
       wp_enqueue_style( $this->cwt_integrations.'_slick_theme', plugin_dir_url( __FILE__ ) . 'css/slick-theme.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->cwt_integrations.'_slick_custom', plugin_dir_url( __FILE__ ) . 'css/slick-custom.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
	    wp_enqueue_script( $this->cwt_integrations.'_slick', plugin_dir_url( __FILE__ ) . 'js/slick.min.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Example of Shortcode processing function.
	 *
	 * Shortcode can take attributes like [cwt-integrations-shortcode attribute='123']
	 * Shortcodes can be enclosing content [cwt-integrations-shortcode attribute='123']custom content[/cwt-integrations-shortcode].
	 *
	 * @see https://developer.wordpress.org/plugins/shortcodes/enclosing-shortcodes/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function cwti_shortcode_func( $atts, $content = null, $tag ) {

		/**
		 * Combine user attributes with known attributes.
		 *
		 * @see https://developer.wordpress.org/reference/functions/shortcode_atts/
		 *
		 * Pass third paramter $shortcode to enable ShortCode Attribute Filtering.
		 * @see https://developer.wordpress.org/reference/hooks/shortcode_atts_shortcode/
		 */
		$atts = shortcode_atts(
			array(
				'attribute' => 123,
			),
			$atts,
			$this->plugin_prefix . 'shortcode'
		);

		/**
		 * Build our ShortCode output.
		 * Remember to sanitize all user input.
		 * In this case, we expect a integer value to be passed to the ShortCode attribute.
		 *
		 * @see https://developer.wordpress.org/themes/theme-security/data-sanitization-escaping/
		 */
		$out = intval( $atts['attribute'] );

		/**
		 * If the shortcode is enclosing, we may want to do something with $content
		 */
		if ( ! is_null( $content ) && ! empty( $content ) ) {
			$out = do_shortcode( $content );// We can parse shortcodes inside $content.
			$out = intval( $atts['attribute'] ) . ' ' . sanitize_text_field( $out );// Remember to sanitize your user input.
		}

		// ShortCodes are filters and should always return, never echo.
		return $out;

	}

    /**
     * Action hook function for wp_header by slick plugin integration
     *
     */
    public function wp_header(){
        $enable_feat_carousel = get_field( "enable_feat_carousel" );
        if ( is_front_page()  && $enable_feat_carousel) {
            ?>
            <style>
                .featured-box .row{display: none;}
            </style>
                <?php
            }
    }

	/**
     * Action hook function for wp_footer by slick plugin integration
     *
     */
	public function wp_footer(){
        $enable_feat_carousel = get_field( "enable_feat_carousel" );
        $slidesinlg = get_field( "no_of_slides_1024" );  $slidesinlg = !empty($slidesinlg) ? $slidesinlg : 3;
        $slidesin1024 = get_field( "no_of_slides_1023" ); $slidesin1024 = !empty($slidesin1024) ? $slidesin1024 : 3;
        $slidesin768 = get_field( "no_of_slides_768" ); $slidesin768 = !empty($slidesin768) ? $slidesin768 : 2;
        $slidesin480 = get_field( "no_of_slides_480" ); $slidesin480 = !empty($slidesin480) ? $slidesin480 : 1;
       // var_dump(array($enable_feat_carousel,is_front_page(),is_home()));
        if ( is_front_page()  && $enable_feat_carousel) {
        ?>
        <script type="text/javascript">
            (function($) {
                $(document).on('ready', function () {
                    $(".featured-box .row").slick({
                        dots: true,
                        infinite: true,
                        speed: 300,
                        slidesToShow: <?php echo $slidesinlg; ?>,
                        slidesToScroll: 1,
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: <?php echo $slidesin1024; ?>,
                                    slidesToScroll: 1,
                                    infinite: true,
                                    dots: true
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: <?php echo $slidesin768; ?>,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: <?php echo $slidesin480; ?>,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                });
            })(jQuery);
        </script>
        <?php
        }
    }

}
