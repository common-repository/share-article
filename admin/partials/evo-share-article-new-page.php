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

<div class="wrap">
    <h2><?php _e("Share Article", "evo-share-article"); ?></h2>
     
    <?php    
    // If URL contains 'status' parameter, return error message
    if ( isset( $_GET['status'] ) ) {
        $status = $_GET['status'];

        switch ( $status ) {

            case 'no-url':
                $status_message = __('You didn\'t enter an URL', 'evo-share-article');
                break;

            case 'http_request_failed':
                $status_message = __('URL could not be reached. Try again.', 'evo-share-article');
                break;

            default:
                $status_message = __('Oops, something went wrong. Try again', 'evo-share-article');
        }

        echo '<div id="message" class="error">';
            echo $status_message;  
        echo '</div>';
        
    } ?>
         
    <!-- Short message telling what's expected from the user -->   
    <p><?php _e('Enter the URL from the article you want to share on your blog. Then click "Next"', 'evo-share-article') ?></p>

    <?php 
        $settings_text = __('If you want to change how to display the source, go to', 'evo-share-article');
        $settings_url = admin_url( 'options-general.php?page=share-article-options' );
    ?>
    <p><?php echo $settings_text ?>
        <a href="<?php echo $settings_url ?>" > <?php _e('Settings', 'evo-share-article') ?> </a>
    </p>



    <!-- The form to get the content -->
    <!-- It's using the admin_post_{action} hook -->
    <form method="post" action="admin-post.php">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="get_source_link"><?php _e('Enter URL', 'evo-share-article') ?></label></th>
                <td><input type="text" name="get_source_link" size="100%"></td>
            </tr>

            <tr>
                <th></th>
                <td>
                <input type="hidden" name="action" value="evo_share_article_set_source_link">

                <!-- Nonce stuff -->
                <input type="hidden" name="evo_action" value="evo_share_article_set_source_link">
                <?php wp_nonce_field( 'evo_share_article-evo_share_article_set_source_link' ); ?>
                
                <input type="submit" value="<?php _e('Next', 'evo-share-article') ?>" class="button-primary">
                </td>
            </tr>
        </table>
    </form>
</div>