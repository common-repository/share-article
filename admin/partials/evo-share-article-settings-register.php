<?php
// Register the settings
// TODO: merge into one array

// Some static variables
$settings_group_name = 'evo_share_article_options';
$page = 'share-article-options';
$section = 'evo_share_article_options_main';

// The different options with the description to display, to loop over
$options = array(
	'readmore' 	=> 'Read more text', 
	'sourceurl'	=> 'Source display', 
	'target'	=> 'Target'
);

foreach( $options as $key => $value ) {
	// Register the settings
	register_setting(
		$settings_group_name,							// Setting group name
		'evo_share_article_options_'.$key,				// Option name ( as used in get_option() )
		'evo_share_article_validate_options_'.$key		// Call to validation function (optional)
	);

	// Add the settings fields
	add_settings_field(
		'evo_share_article_'.$key,						// HTML ID tag for the section
		__($value, 'evo-share-article'),				// Text printed next to the field
		'evo_share_article_options_'.$key,				// Callback function that will echo the form field
		$page,											// On which page to show the section
		$section 										// The section of the settings page in which to show the field
	);
}

// Define sections and settings
add_settings_section(
	$section,											// HTML ID tag for the section
	'',													// Section title (shown in h3 tags)
	'evo_share_article_options_main_text',				// Callback function with explanation about the section
	$page												// On which page to show the section
);

// Function to display main section text
function evo_share_article_options_main_text() {
	echo '<p>'. _e('Choose how to display the source, which is displayed below the post. Changes only apply to new posts.', 'evo-share-article') . '</p>';
}

// Display and fill the form fields
// Read more text
function evo_share_article_options_readmore() {
	// Get option 'readmore_text' value from database
	$readmore_text = get_option( 'evo_share_article_options_readmore' );

	// At plugin activation, 'Source: ' is set as option in the database and will not be translated.
	// So if $readmore_text == 'Source: ', make it translatable
	if ( $readmore_text == 'Source: ') {
		$readmore_text = __('Source: ', 'evo-share-article') ;
	}
	
	// Echo the field
	echo "<input id='readmore_text' name='evo_share_article_options_readmore' type='text' value='$readmore_text' />";
}

// Source URL
function evo_share_article_options_sourceurl() {
	$source_url = get_option( 'evo_share_article_options_sourceurl' );
	
	// Echo the fields
	$items = array(
		
			'Domain' 	=> __('Domain', 'evo-share-article'),
			'Full'		=> __('Full URL', 'evo-share-article')
			
		 );
	
	echo "<select id='source_url_dropdown' name='evo_share_article_options_sourceurl'>";
	
	foreach($items as $key => $value  ) {
		$selected = ($source_url==$key) ? 'selected="selected"' : '';
		echo "<option value='$key' $selected>$value</option>";
	}
	
	echo "</select>";  
}

// Target
function evo_share_article_options_target() {
	$target = get_option( 'evo_share_article_options_target' );

	$items = array(

		'New tab'	=> __('New tab', 'evo-share-article'),
		'Same tab'	=> __('Same tab', 'evo-share-article')
		);

	// Echo the field
	echo "<select id='target_dropdown' name='evo_share_article_options_target'>";

	foreach( $items as $key => $value ) {
		$selected = ($target==$key) ? 'selected="selected"' : '';
		echo "<option value='$key' $selected>$value</option>";
	}

	echo "</select>";
}

// Validate user input
function evo_share_article_validate_options_readmore( $input ) {

	$valid = sanitize_text_field( $input );
    return $valid;
}

function evo_share_article_validate_options_sourceurl( $input ) {

	// Whitelisting
	$white_list = array( 'Domain', 'Full' );
	
	if( in_array( $_POST['evo_share_article_options_sourceurl'], $white_list ) ) {
		$valid = $_POST['evo_share_article_options_sourceurl'];
		return $valid;
	} else {
		$valid = 'Domain';
		return $valid;
	}
    
}

function evo_share_article_validate_options_target( $input ) {

	// Whitelisting
	$white_list = array( "New tab", "Same tab" );
	
	if( in_array( $_POST['evo_share_article_options_target'], $white_list ) ) {
		$valid = $_POST['evo_share_article_options_target'];
		return $valid;
	} else {
		$valid = 'Same tab';
		return $valid;
	}
    
}
?>