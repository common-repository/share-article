<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Evo_Share_Article
 * @subpackage Evo_Share_Article/includes
 * @author     Erwin Matijsen <plugins@evosites.nl>
 */
class Evo_Share_Article_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        // Set options
        $readmore_text = 'Source: '; 
        
        add_option( 'evo_share_article_options_readmore', $readmore_text );
        add_option( 'evo_share_article_options_sourceurl', 'Domain' );
        add_option( 'evo_share_article_options_target', 'Same tab');

	}

}
