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
    // Things that you want to do. 
    load_template_part_tk('templates','login-btn');
    // Output needs to be return
    // return $calc_html;
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

/**
 * Register a custom menu page.
 */
// function register_tokenpass_menu_page(){
    // add_menu_page(
    //     __('Tokenpass','menu-test'), 
    //     __('Tokenpass','menu-test'), 
    //     'manage_options', 
    //     'manage_tokenpass', 
    //     'tokenpass_menu_page',
    //     plugins_url( 'tokenpass/assets/images/tokenly-icon.png' ),
    //     6
    // );
    // add_submenu_page( 
    //     'manage_tokenpass', 
    //     'settings', 
    //     'settings', 
    //     1, //$capability, 
    //     'tokenpass-settings',
    //     'manage_tokenpass' );
    // add_menu_page('Tokenpass', 'Tokenpass', 'manage_options', 'manage_tokenpass','tokenpass_menu_page',plugins_url( 'tokenpass/assets/images/tokenly-icon.png' ),6);
    // add_submenu_page( 'manage_tokenpass', 'Tokenpass settings', 'Settings', 'manage_options', 'manage_tokenpass');
    // add_submenu_page( 'manage_tokenpass', 'Tokenpass Documentation', 'Documentation', 'manage_options', 'tk_documentation','tk_documentation_html');

// }
// add_action( 'admin_menu', 'register_tokenpass_menu_page' );
 
/**
 * Display a custom menu page
 */
function tokenpass_menu_page(){
    // esc_html_e( 'Admin Page Test', 'textdomain' );  
    // echo '<div class="container">
    // <h2>Tokenpass Settings </h2>
    // <form>
    // <div class="form-group">
    //   <label for="tk-client-id">Client ID : </label>
    //   <input type="text" class="form-control" id="tk-client-id" placeholder="Enter your Client ID">
    // </div>
    // <div class="form-group">
    //   <label for="tk-client-secret">Client Secret : </label>
    //   <input type="text" class="form-control" id="tk-client-secret" placeholder="Enter your Client Secret">
    // </div>
    // <button type="button" class="btn btn-primary tk-settings-btn">Submit</button>
    //   </form> </div>';
}

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
            echo "<script>alert('".$message."');</script>";
            echo "<script>window.location.href = '/tokenly';</script>";            
        }else{
            if($_GET['logged_in'] == 'yes' ){
                $user_email = $_GET['useremail'];
                $message = $user_email.' you are successfully logged in.';
                echo "<script>alert('".$message."');</script>";            
                echo "<script>window.location.href = '/tokenly/tokenpass-dashboard';</script>";            
            }
            if($_GET['user_register'] == 'yes' ){
                $user_email = $_GET['useremail'];
                $message = $user_email.' you are registered successfully. please check your email for credentials';
                echo "<script>alert('".$message."');</script>"; 
                echo "<script>window.location.href = '/';</script>";            
            }
        }
    }
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
		// add_submenu_page( 'tk-settings', 'Tokenpass performance', 'Performance', 'manage_options', 'manage_options','oppu_performance_dash_html');
	}

	public function tk_settings_create_admin_page() {
		$this->tk_settings_options = get_option( 'tk_settings_option_name' ); ?>

		<div class="wrap">
			<h2>Tokenpass Settings</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'tk_settings_option_group' );
					do_settings_sections( 'tk-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

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
			isset( $this->tk_settings_options['client_id_0'] ) ? esc_attr( $this->tk_settings_options['client_id_0']) : '1865085475'
		);
	}

	public function client_secret_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="tk_settings_option_name[client_secret_1]" id="client_secret_1" value="%s">',
			isset( $this->tk_settings_options['client_secret_1'] ) ? esc_attr( $this->tk_settings_options['client_secret_1']) : 'Ke3LJaXn24mdRScl5AsHP9CxmZoxykf3nm5GgZsI'
		);
	}



}
if ( is_admin() )
	$oppu_settings = new tokenpassSettings();

/*set default values start*/
if(get_option( 'client_id_0' ) === false){
	update_option( 'client_id_0', '1865085475' );
}if(get_option( 'client_secret_1' ) === false){
	update_option( 'client_secret_1', 'Ke3LJaXn24mdRScl5AsHP9CxmZoxykf3nm5GgZsI' );
}
/*set default values end*/


/** ADMIN SETTINGS FORM ENDS */