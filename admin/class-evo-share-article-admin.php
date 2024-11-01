<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Evo_Share_Article
 * @subpackage Evo_Share_Article/admin
 * @author     Erwin Matijsen <plugins@evosites.nl>
 */
class Evo_Share_Article_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/evo-share-article-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/evo-share-article-admin.js', array( 'jquery' ), $this->version, false );

		// Translations for js
		$translations = array(
			'newtab' 	=> __('New tab', 'evo-share-article'),
			'sametab' 	=> __('Same tab', 'evo-share-article')
			);
		wp_localize_script($this->plugin_name, 'target', $translations);

	}

	/**
	 * Add Menus
	 *
	 * @since 	1.0
	 *
	*/

	public function evo_share_article_add_menus() {

	    // Share Article, added to Posts menu
	    $parent_slug = 'edit.php';
	    $page_title = __('Share Article', 'evo-share-article');
	    $menu_title = __('Share Article', 'evo-share-article');
	    $capability = 'manage_options';
	    $menu_slug = 'share-article';
	    $function = array( $this, 'display_share_article_new' );

	    add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );

	    // Settings page, added to Settings page
	    $page_title = __('Share Article', 'evo-share-article') . ' - ' . __('Settings', 'evo-share-article');
	    $menu_title = __('Share Article', 'evo-share-article');
	    $capability = 'manage_options';
	    $menu_slug = 'share-article-options';
	    $function = array( $this, 'display_share_article_settings' );

	    add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	}

	 /**
	 * Add settings link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function evo_share_article_add_action_links ( $links ) {
		
	    $settings_link = array(
	    	'<a href="' . admin_url( 'options-general.php?page=share-article-options' ) . '">' . __('Settings', 'evo-share-article') . '</a>',
	    	);
	    
	    return array_merge(  $settings_link, $links );
	}

	/**
	 * Render the pages
	 * 
	 * @since 	1.0
	 *
	*/

	public function display_share_article_new() {
		include_once( 'partials/evo-share-article-new-page.php' );
	}

	public function display_share_article_settings() {
		include_once( 'partials/evo-share-article-settings-page.php' );
	}

	
	/**
	 * Register the Settings
	 * 
	 * @since 	1.0
	 *
	*/

	public function evo_share_article_settings() {
		include_once( 'partials/evo-share-article-settings-register.php' );
	}


	/**
	 * The function to parse the source and get the Title, Image and Summary
	 * 
	 * @since 	1.0
	 *
	*/

	public function evo_share_article_parse_source_link() 
	{
		include_once( 'partials/evo-share-article-new-routine.php' );
	}
}