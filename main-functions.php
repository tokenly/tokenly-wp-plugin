<?php

define( 'PLUGIN_DIR', dirname(__FILE__).'/' ); 

/* The below function will help to load template file from plugin directory of wordpress*/ 
function tk_get_template_part($slug, $name = null) {

    do_action("tk_get_template_part_{$slug}", $slug, $name);
    $templates = array();
    if (isset($name))
        $templates[] = "{$slug}-{$name}.php";
    $templates[] = "{$slug}.php";
    tk_get_template_path($templates, true, false);
}

/* Extend locate_template from WP Core Define a location of your plugin file dir to a constant in this case = PLUGIN_DIR_PATH */ 
function tk_get_template_path($template_names, $load = false, $require_once = true ) {
    $located = ''; 
    foreach ( (array) $template_names as $template_name ) { 
        if ( !$template_name ) 
        continue; 
        /* search file within the PLUGIN_DIR_PATH only */ 
        if ( file_exists( plugin_dir_path( __FILE__ ) . $template_name)) { 
            $located =  plugin_dir_path( __FILE__ ) . $template_name; 
            break; 
        } 
    }
    if ( $load && '' != $located )
        load_template( $located, $require_once );
    return $located;
}

/* Embedded Required Scripts */
function tokenpass_scripts(){
    $handle_1 = 'jquery.js';
    $handle = 'main.js';
    $handle_2 = 'jquery.validate.min.js';
    $list = 'enqueued';
    wp_dequeue_script('main.js');
    if (wp_script_is($handle_1, $list)) {
        return;
    } else {
        wp_enqueue_script('jquery.js', plugins_url('/assets/js/jquery.min.js', __FILE__), array(), null, true);
    }
    if (wp_script_is($handle, $list)) {
        return;
    } else {
        wp_enqueue_script('main.js', plugins_url('/assets/js/tokenpass-main.js', __FILE__));
    }
    if (wp_script_is($handle_2, $list)) {
        return;
    } else {
        wp_enqueue_script('validate.js', plugins_url('/assets/js/jquery.validate.min.js', __FILE__));
    }    
    wp_enqueue_script('popper.js', plugins_url('/assets/js/popper.min.js', __FILE__));
    wp_enqueue_script('bootstrap.min.js', plugins_url('/assets/js/bootstrap.min.js', __FILE__));

    wp_enqueue_style('main.css', plugins_url('/assets/css/tokenpass-main.css', __FILE__));
}
add_action('wp_head', 'tokenpass_scripts');


/* Delete tables on plugin delete */
register_uninstall_hook( __FILE__, 'my_plugin_remove_database_tk' );
function my_plugin_remove_database_tk() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tk_data';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}   

/* Create shortcode for calculator */
function tokenpass_shortcode(){
    load_template_part_tk('templates','login-btn');
}
add_shortcode('tokenpass_login', 'tokenpass_shortcode');

/* load template call function */
function load_template_part_tk($template_name, $part_name=null) {
    // ob_start();    
    $var = tk_get_template_part(''.$template_name.'/'.$part_name.'', null);
    // ob_end_clean();
    return $var;
}

/* Fetching template */
function fetch_template_tk(){
    load_template_part_tk($_REQUEST['templateName'],$_REQUEST['fileName']);
    wp_die();
}
add_action('wp_ajax_nopriv_fetch_template', 'fetch_template_tk');
add_action('wp_ajax_fetch_template', 'fetch_template_tk');

 
function tk_documentation_html(){
    echo '<h2> Coming Soon !! </h2>';
}

function my_admin_style_tk() {
    wp_enqueue_style( 'admin-style', plugins_url('/assets/css/admin-style.css', __FILE__) );
  }
add_action( 'admin_enqueue_scripts', 'my_admin_style_tk');

add_action('init','tokenly_login_check');
function tokenly_login_check() {

    if(isset($_GET['error'])){
        if($_GET['error'] == 'yes' ){
            $message = $_GET['message'];
            echo "<script>window.location.href = '/';</script>";            
        }else{
            if($_GET['logged_in'] == 'yes' ){
                $user_email = $_GET['useremail'];
                $message = $user_email.' you are successfully logged in.';
                echo "<script>window.location.href = '/wp-admin';</script>";            
            }
            if($_GET['user_register'] == 'yes' ){
                $user_email = $_GET['useremail'];
                $message = $user_email.' you are registered successfully. please check your email for credentials';
                echo "<script>window.location.href = '/';</script>";            
            }
        }
    }
    // remove_role( 'tk_member' );
}

add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email_tk', 10, 3 );
function custom_wp_new_user_notification_email_tk( $wp_new_user_notification_email, $user, $blogname ) {
 
    $user_login = stripslashes( $user->user_login );
    $user_email = stripslashes( $user->user_email );
    $user_pass = get_user_meta( $user->data->ID, 'usr_pass', true );

    $login_url  = wp_login_url();
    $message  = __( 'Hi there,' ) . "<br>";
    $message .= sprintf( __( "Welcome to %s! Here's how to log in:" ), get_option('blogname') ) . "<br>";
    $message .= wp_login_url() . "<br>";
    $message .= sprintf( __('Username: %s'), $user_login ) . "<br>";
    $message .= sprintf( __('Email: %s'), $user_email ) . "<br>";
    $message .= sprintf(__('Password: %s'), $user_pass) . "<br>";
    $message .= sprintf( __('If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "<br>";
    $message .= __( 'bye!' );

    $wp_new_user_notification_email['subject'] = sprintf( '[%s] Your credentials.', $blogname );
    $wp_new_user_notification_email['headers'] = array('Content-Type: text/html; charset=UTF-8');
    $wp_new_user_notification_email['message'] = $message;
 
    return $wp_new_user_notification_email;
}


/** ADMIN SETTINGS FORM STARTS */

class tokenpassSettings {
	private $tk_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'tk_settings_add_plugin_page' ) );
		add_action( 'admin_menu', array( $this, 'tk_settings_add_plugin_page_user' ) );
		add_action( 'admin_init', array( $this, 'tk_settings_page_init' ) );
	}

	public function tk_settings_add_plugin_page() {
		add_menu_page(
			'Tokenpass Settings', // page_title
			'Tokenpass ', // menu_title
			'manage_options', // capability
			'tk-settings', // menu_slug
			array( $this, 'tk_settings_create_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			2 // position
		);
		// add_submenu_page( 'tk-settings', 'Tokenpass Inventory', 'Inventory', 'tk_manage_options', 'tk_manage_options', array( $this, 'tk_inventory_dash_html' ));
	}

    public function tk_settings_add_plugin_page_user(){
        add_menu_page(
			'Tokenpass Inventory', // page_title
			'Tokenpass ', // menu_title
			'tk_manage_options_user', // capability
			'tk-settings-user', // menu_slug
			array( $this, 'tk_inventory_dash_html' ), // function
			'dashicons-admin-generic', // icon_url
			2 // position
		);
		// add_submenu_page( 'tk-settings', 'Tokenpass Inventory', 'Inventory', 'tk_manage_options', 'tk_manage_options', array( $this, 'tk_inventory_dash_html' ));
    }

	public function tk_settings_create_admin_page() {
		$this->tk_settings_options = get_option( 'tk_settings_option_name' ); ?>
		<div class="wrap">
			<h2>Tokenpass</h2>
			<p></p>
			<?php settings_errors(); ?>
            <hr>
            <div class="tk_documentation">
                <h3>How to Setup</h3>
                <ul class="tk_steps">
                    <li>1. Create App on <a href="https://tokenpass.tokenly.com/auth/apps">Tokenpass Developers</a></li>
                    <li>2. Use below details to create App </a></li>
                </ul>
                <?php 
                    $app_homepage_url =  "https://";;
                    $app_homepage_url .=  $_SERVER['HTTP_HOST'].'/';
                    $client_auth_url = $app_homepage_url.'/wp-content/plugins/tokenpass/account/authorize/callback.php';
                ?>
                <div class="tk_app_details">
                    <h3>Register Client Application</h3>

                    <span> <b>CLIENT NAME: </b> Random Input </span><br>
                    <span> <b>APP HOMEPAGE URL: </b> <?php echo $app_homepage_url ?> </span><br>
                    <span> <b>CLIENT AUTHORIZATION REDIRECT URL: </b> <?php echo $client_auth_url ?> </span>
                </div>
            </div>
            <br>
            <hr>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'tk_settings_option_group' );
					do_settings_sections( 'tk-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

    public function tk_inventory_dash_html() { 
        // echo "heko";
        load_template_part_tk('templates','tokenpass-dashboard');
    }

	public function tk_settings_page_init() {
		register_setting(
			'tk_settings_option_group', // option_group
			'tk_settings_option_name', // option_name
			array( $this, 'tk_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'tk_settings_setting_section', // id
			'Settings', // title
			array( $this, 'tk_settings_section_info' ), // callback
			'tk-settings-admin' // page
		);

		add_settings_field(
			'client_id_0', // id
			'Client Id', // title
			array( $this, 'client_id_0_callback' ), // callback
			'tk-settings-admin', // page
			'tk_settings_setting_section' // section
		);

		add_settings_field(
			'client_secret_1', // id
			'Client Secret', // title
			array( $this, 'client_secret_1_callback' ), // callback
			'tk-settings-admin', // page
			'tk_settings_setting_section' // section
		);

	}

	public function tk_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['client_id_0'] ) ) {
			$sanitary_values['client_id_0'] = sanitize_text_field( $input['client_id_0'] );
		}

		if ( isset( $input['client_secret_1'] ) ) {
			$sanitary_values['client_secret_1'] = sanitize_text_field( $input['client_secret_1'] );
		}

		return $sanitary_values;
	}

	public function tk_settings_section_info() {
		
	}

	public function client_id_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="tk_settings_option_name[client_id_0]" id="client_id_0" value="%s">',
			isset( $this->tk_settings_options['client_id_0'] ) ? esc_attr( $this->tk_settings_options['client_id_0']) : ''
		);
	}

	public function client_secret_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="tk_settings_option_name[client_secret_1]" id="client_secret_1" value="%s">',
			isset( $this->tk_settings_options['client_secret_1'] ) ? esc_attr( $this->tk_settings_options['client_secret_1']) : ''
		);
	}
}
if ( is_admin() )
	$tk_settings_options = new tokenpassSettings();

/*set default values start*/
if(get_option( 'client_id_0' ) === false){
	update_option( 'client_id_0', '' );
}if(get_option( 'client_secret_1' ) === false){
	update_option( 'client_secret_1', '' );
}
/*set default values end*/


/** ADMIN SETTINGS FORM ENDS */
