<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://evosites.nl
 * @since      1.0.0
 *
 * @package    Evo_Share_Article
 * @subpackage Evo_Share_Article/admin/partials
 */
?>

<!-- Settings for Read more text and how to show the source link -->

<div class="wrap">
    <h2><?php _e('Share Article', 'evo-share-article'); echo ' - '; _e('Settings', 'evo-share-article'); ?></h2>
    <hr>
    <form action="options.php" method="post">
        
        <?php 
            settings_fields('evo_share_article_options');
            do_settings_sections('share-article-options');
        ?>

        <table class="form-table">
        <tr>
            <th></th>
            <td>
                <input type="submit" value="<?php _e('Save', 'evo-share-article') ?>" class="button-primary">
            </td>
        </tr>
        </table>
        
    </form>
    
    <?php
        $readmore_text = get_option( 'evo_share_article_options_readmore' );
        $source_url = get_option( 'evo_share_article_options_sourceurl' );
        $target = get_option( 'evo_share_article_options_target' );
        $source_link = 'http://example.com/article/to/share/';
        $site_name = 'Example.com';

        switch ( $source_url ) {

            case 'Domain':
                $site_name = $site_name;
                break;
            case 'Full':
                $site_name = $source_link;
                break;

            default:
                $site_name = $site_name;
        }

        switch ( $target ) {

            case 'New tab':
                $set_target='target="_blank"';
                break;
            case 'Same tab':
                $set_target="";
                break;
            default:
                $set_target="";
        }

        $readmore_link = '<p>'. $readmore_text . ' <a href="'.$source_link.'" '. $set_target.'>'.$site_name.'</a>';

    ?>
    <hr>
    <table class="form-table">
        <tr>
            <th><?php _e('Current style', 'evo-share-article'); ?></th>
            <td>
                <?php echo $readmore_link. ' ('.__($target, 'evo-share-article').')';?>
            </td>
        </tr>

        <tr>
            <th><?php _e('New style', 'evo-share-article'); ?></th>
            <td id="new_source_style">
                <?php echo $readmore_link. ' ('.__($target, 'evo-share-article').')</p>';?>
            </td>
        </tr>
    </table>
    <hr>
    
    <div class=></div>
</div>