<?php
add_action( 'after_setup_theme', 'pi_default_options' );
function pi_default_options() {
	// Check whether or not the 'pi_options' exists
	// If not, create new one.
    if ( ! get_option( 'pi_options' ) ) {
        $options = [
            'logo' => '',
            'favicon' => '',
            'facebook'=>'',
            'twitter'=>''
        ];
        update_option( 'pi_options', $options );
    }     
}

add_action( 'admin_menu', 'pi_add_page' );
function pi_add_page() {
    $pi_options_page = add_menu_page( 'pi', 'Options', 'manage_options', 'pi', 'pi_options_page' );
    add_action( 'admin_print_scripts-' . $pi_options_page, 'pi_print_scripts' );
} 
function pi_options_page() {
?>
    <div class='wrap'>
        <div id='icon-tools' class='icon32'></br></div>
        <h2>Options Page</h2>
        <?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) : ?>
        <div class='updated'><p><strong>Settings saved.</strong></p></div>
        <?php endif; ?>
        <form action='options.php' method='post'>
            <?php settings_fields( 'pi_options' ); ?>
            <?php do_settings_sections( 'pi' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
<?php 
}

add_action( 'admin_init', 'pi_add_options' );
function pi_add_options() {
    register_setting( 'pi_options', 'pi_options', 'pi_options_validate' );
    add_settings_section( 'pi_section', 'pi Options Section', 'pi_section_callback', 'pi' );
    add_settings_field( 'pi_logo', 'Logo Image', 'pi_logo_callback', 'pi', 'pi_section' );
    add_settings_field( 'pi_facebook', 'Facebook Link', 'pi_facebook_callback', 'pi', 'pi_section' );
    add_settings_field( 'pi_twitter', 'Twitter Link', 'pi_twitter_callback', 'pi', 'pi_section' );
    add_settings_field( 'pi_favicon', 'Favicon', 'pi_favicon_callback', 'pi', 'pi_section' );
}

function pi_options_validate($values) { 
    foreach ( $values as $n => $v ) 
        $values[$n] = esc_url($v);
    return $values; 
}

function pi_section_callback() { /* Print nothing */ };

function pi_logo_callback() {
    $options = get_option( 'pi_options' ); 
?>
    <span class='upload'>
        <input type='text' id='pi_logo' class='regular-text text-upload' name='pi_options[logo]' value='<?php echo esc_url($options["logo"]); ?>'/>
        <input type='button' class='button button-upload' value='Upload an image'/></br>
        <img style='max-width: 300px; display: block;' src='<?php echo esc_url($options["logo"]); ?>' class='preview-upload'/>
    </span>
<?php
}

function pi_favicon_callback() {
    $options = get_option( 'pi_options' ); 
?>
    <span class='upload'>
        <input type='text' id='pi_favicon' class='regular-text text-upload' name='pi_options[favicon]' value='<?php echo esc_url($options["favicon"]); ?>'/>
        <input type='button' class='button button-upload' value='Upload an image'/></br>
        <img style='max-width: 300px; display:block' src='<?php echo esc_url($options["favicon"]); ?>' class='preview-upload'/>
    </span>
<?php
}
function pi_facebook_callback() {
    $options = get_option( 'pi_options' ); 
?>
    <span class=''>
        <input type='text' id='pi_facebook' class='regular-text' name='pi_options[facebook]' value='<?php echo esc_url($options["facebook"]); ?>'/>
    </span>
<?php
}
function pi_twitter_callback() {
    $options = get_option( 'pi_options' );
    $options = preg_replace('#^https?://#', '', $options);
?>
    <span class=''>
        @<input type='text' id='pi_twitter' class='regular-text' name='pi_options[twitter]' value='<?php echo ($options["twitter"]); ?>'/>
    </span>
<?php
}

function pi_print_scripts() {
    wp_enqueue_style( 'thickbox' ); // Stylesheet used by Thickbox
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_script( 'pi-upload', get_template_directory_uri() . '/assets/js/pi-upload.js', array( 'thickbox', 'media-upload' ) );
}

function pi_add_favicon() {
	$pi_options = get_option( 'pi_options' );
	$pi_favicon = $pi_options['favicon'];
?>
	<link rel="icon" type="image/png" href="<?php echo esc_url($pi_favicon); ?>">
<?php
}
add_action( 'wp_head', 'pi_add_favicon' );
?>