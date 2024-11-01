<?php
// Check nonce
check_admin_referer( 'evo_share_article-evo_share_article_set_source_link');

// Get sourcelink from form. If set and not empty, continue. Otherwise return to inputpage with error message.
if ( isset($_POST['get_source_link'] ) && !empty($_POST['get_source_link'] ) ) {

	// Get and sanitize link
	$allowed = array( 'http', 'https' );
	$source_link = esc_url($_POST['get_source_link'], $allowed);

	// Get content from link with wp_remote_get and DOM
	$remote_get_args = array(
		'timeout' 	=> 20,		// Give it some time..
		);
	
	$response = wp_remote_get( $source_link, $remote_get_args );

	// If any errors, return to inputpage with error and stop this function
	if ( is_wp_error ( $response ) ) {
		$error = $response->get_error_code();
		wp_safe_redirect( admin_url( 'edit.php?page=share-article&status='.$error ));
		exit;				
	}

	// If no errors, get the body. Sanitize.
	$body = wp_remote_retrieve_body( $response );

	// Clean up tags
	$body = force_balance_tags( $body );

	// NB, no need to wp_kses (or wp_kses_post), because Wordpress will do this itself when creating the post

	// Load the dom
	$dom = new DOMDocument;
	libxml_use_internal_errors(true);
	$dom->loadHTML($body);
	libxml_clear_errors();

		
	// Create functions to get site-name, title, description and image from Open Graph metatags, regular Metatags and if all else fails, regular tags (h1, p, etc.)

	// Open Graph Metatags
	function evo_share_article_get_og_meta( $tag, $dom ) {

		$xpath = new DOMXPath($dom);
		$h1 = $xpath->evaluate("string(//article/h1)");
		$h1_header = $xpath->evaluate("string(//header/h1)");

		foreach( $dom->getElementsByTagName('meta') as $meta ) {

			if( $meta->getAttribute('property') == 'og:'.$tag ) {
				$tag = esc_html($meta->getAttribute('content'));
				return $tag;
			}				
		}
	}

	// Regular Metatags
	function evo_share_article_get_meta( $tag, $dom ) {

		foreach( $dom->getElementsByTagName('meta') as $meta ) {

			if ( $meta->getAttribute('name') == $tag ) {
				$tag = esc_html($meta->getAttribute('content'));
				return $tag;
			}

		}
	}

	// Tags (h1, p and img)
	// TODO: find if <article> is used, if so use first h1, p, img *in* article.
	// TODO: if no <article> is used, or the tags not found in <article>, get
	// TODO: first encounters.
	function evo_share_article_get_tags( $tag, $tagname, $dom ) {


		
		$tag = array();
		foreach( $dom->getElementsByTagName($tagname) as $node ) {
			if ( $tagname == 'img' ) {
				$xpath = new DOMXPath($dom);
				$tag = $xpath->evaluate("string(//img/@src)");
				return $tag;
			}
			else {
				$tag[] = $node->nodeValue;
				$tag = $tag[0];
				return $tag;						
			}
		}
	}
	
	// Now we will try to get the information. First try Open Graph Metatags, 
	// If those are not available, try regular Metatags. If those aren't
	// available either, try html tags.

	// Try getting a site name
	$site_name = evo_share_article_get_og_meta('site_name', $dom);
	$site_name = ( $site_name == '' ? evo_share_article_get_og_meta( 'app-name', $dom ) : $site_name );
	$site_name = ( $site_name == '' ? evo_share_article_get_meta( 'author', $dom ) : $site_name );
	$site_name = ( $site_name == '' ? evo_share_article_get_meta( 'author-name', $dom ): $site_name );
	$site_name = ( $site_name == '' ? $site_name = parse_url($source_link)['host'] : $site_name );
	
	// Try getting a title
	$title = evo_share_article_get_og_meta('title', $dom);
	$title = ( $title == '' ? evo_share_article_get_meta( 'title', $dom ) : $title );
	$title = ( $title == '' ? evo_share_article_get_tags( 'title', 'h1', $dom) : $title );
	$title = ( $title == '' ? evo_share_article_get_tags( 'title', 'title', $dom) : $title );
	$title = ( $title == '' ? $title = __('No title found', 'evo-share-article') : $title );
	$title = $title . ' (via ' . $site_name . ')';

	// Try getting a Description
	$description = evo_share_article_get_og_meta('description', $dom);
	$description = ( $description == '' ? evo_share_article_get_meta( 'description', $dom ) : $description );
	// TODO: find first <p> in <article>
	$description = ( $description == '' ? evo_share_article_get_tags( 'description', 'p', $dom) : $description );
	$description = ( $description == '' ? __('No description found', 'evo-share-article') : $description );

	// Try getting a Image
	$image = evo_share_article_get_og_meta('image', $dom);
	$image = (  $image == '' ? evo_share_article_get_meta( 'image', $dom ) : $image );
	// TODO: find first img in <article>
	$image = (  $image == '' ? evo_share_article_get_tags( 'image', 'img', $dom) : $image );
	// No image found
	$image = None;
	
	// Add Read more text
	$readmore_text = get_option( 'evo_share_article_options_readmore' );
    $source_url = get_option( 'evo_share_article_options_sourceurl' );
    $target = get_option( 'evo_share_article_options_target' );

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

    $readmore_link = '<p>'. $readmore_text . ' <a href="'.$source_link.'" '. $set_target.'>'.$site_name.'</a></p>';

	// Content is description and Read More concatenated
	$content = $description . $readmore_link;

	//// Create new post
	$args = array(
		'post_title' 			=> $title,
		'post_status'			=> 'draft',
		'meta_input'			=> array(
									'_source_link' => $source_link,
									),
		'post_content' 			=> $content,
		);

	$post_id = wp_insert_post( $args );

	// Try adding image
	// See: https://stackoverflow.com/questions/31368072/error-in-fetching-image-using-wp-remote-get-function
	if ($image != None) {
		$temp = download_url( $image );
		
		// fix filename for query strings
		preg_match( '/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $image, $matches );

		$file_array = array(
			'name'	=> $site_name . '-' . basename($matches[0]),
			'tmp_name'	=> $temp,
			);

		// Check for download errors
		if( is_wp_error( $temp ) ) {
			@unlink( $file_array['tmp_name'] );
			return false;
		}

		$id = media_handle_sideload( $file_array, $post_id );

		// Check for handle sideload errors
		if( is_wp_error( $id ) ) {
			@unlink( $file_array['tmp_name'] );
			return false;
		}

		set_post_thumbnail( $post_id, $id );		
	}


	// If done, redirect to the newly created post
	wp_safe_redirect( admin_url( 'post.php?post='.$post_id.'&action=edit'));
	exit;	
}

// If no source link provided, return with error message
else {
	wp_safe_redirect( admin_url( 'edit.php?page=share-article&status=no-url' ));
	exit;
}
?>