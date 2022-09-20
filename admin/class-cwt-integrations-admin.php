<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Cwt_Integrations
 * @subpackage Cwt_Integrations/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the admin-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Cwt_Integrations
 * @subpackage Cwt_Integrations/admin
 * @author     Your Name <email@example.com>
 */
class Cwt_Integrations_Admin {

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
	 * @param      string $cwt_integrations       The name of this plugin.
	 * @param      string $plugin_prefix    The unique prefix of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $cwt_integrations, $plugin_prefix, $version ) {

		$this->cwt_integrations   = $cwt_integrations;
		$this->plugin_prefix = $plugin_prefix;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_styles( $hook_suffix ) {

		wp_enqueue_style( $this->cwt_integrations, plugin_dir_url( __FILE__ ) . 'css/cwt-integrations-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		wp_enqueue_script( $this->cwt_integrations, plugin_dir_url( __FILE__ ) . 'js/cwt-integrations-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function admin_acf_fieldsby_cwt(){
    }

    public function cwt_manage_carwash_posts_columns($columns){

        $new_column['cb'] = $columns['cb'];
        $new_column['ar_id'] =  __( 'AR ID', $this->cwt_integrations );
        unset($columns['cb']);
        $columns = array_merge($new_column,$columns);  
        return $columns;
    }

    public function cwt_manage_carwash_posts_custom_column( $column, $post_id ) {
        switch ( $column ) {

            case 'ar_id' :
                echo get_post_meta( $post_id , 'ar_id' , true );
                break;

        }
    }

}
