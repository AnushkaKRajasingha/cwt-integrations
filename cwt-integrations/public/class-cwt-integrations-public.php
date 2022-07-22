<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Cwt_Integrations
 * @subpackage Cwt_Integrations/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the public-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Cwt_Integrations
 * @subpackage Cwt_Integrations/public
 * @author     Your Name <email@example.com>
 */
class Cwt_Integrations_Public {

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

		wp_enqueue_style( $this->cwt_integrations, plugin_dir_url( __FILE__ ) . 'css/cwt-integrations-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->cwt_integrations, plugin_dir_url( __FILE__ ) . 'js/cwt-integrations-public.js', array( 'jquery' ), $this->version, true );

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
     * Create custom rewrite url for carwash post type
     * @see https://stackoverflow.com/questions/55890131/wordpress-url-rewrite-to-sync-custom-taxonomy-and-post-type
     * @since 1.0.0
     */
    public function custom_rewrite_basic(){
        add_rewrite_rule('carwash/([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?carwash=$matches[3]&state=$matches[1]&carwash_type=$matches[2]', 'top');
    }


    /**
     * Apply filter for modifying the post type slug with related taxonomy
     * @param $args
     * @return array
     */
    public function func_Progressive_services_args($args){
        return array_merge(
            $args,
            array(
                'rewrite' => array('slug' => 'carwash/%state%/%carwash_type%')
            )
        );
    }


    /**
     * Replace terms tags acoording to their actual values.
     * @param $post_link
     * @param int $id
     * @return string|string[]
     */
    public function replace_tax_value($post_link, $id = 0){
        $post = get_post($id);
        if ( is_object( $post ) ){
            $terms_state = wp_get_object_terms( $post->ID, 'state' ); $terms_carwash_type = wp_get_object_terms( $post->ID, 'carwash_type' );
            if( $terms_state && $terms_carwash_type ){
                $post_link = str_replace( '%state%' , $terms_state[0]->slug , $post_link );
                $post_link = str_replace( '%carwash_type%' , $terms_carwash_type[0]->slug , $post_link );
                return $post_link;
            }
        }
        return $post_link;
    }

}
