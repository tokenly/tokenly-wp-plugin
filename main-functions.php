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

/* Create Tables for API & Report Generation */
function create_tokenpass_tables(){
    global $wpdb;
    $db_table_name = $wpdb->prefix . 'tk_data';  // table name
    $charset_collate = $wpdb->get_charset_collate();

    //Check to see if the table exists already, if not, then create it
    if ($wpdb->get_var("show tables like '$db_table_name'") != $db_table_name) {
        $sql = "CREATE TABLE $db_table_name (
                id int(20) NOT NULL auto_increment,
                name varchar(30) NOT NULL,
                balance BIGINT(9) NOT NULL,
                interest_rate float(10) NOT NULL,
                monthly_charges BIGINT(9) NULL,
                monthly_payment BIGINT(9) NOT NULL,
                term INT(9) NOT NULL,
                report_date DATETIME,
                UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

register_activation_hook(__FILE__, 'create_tokenpass_tables');

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
        wp_enqueue_script('main.js', plugins_url('/assets/js/main.js', __FILE__));
    }
    if (wp_script_is($handle_2, $list)) {
        return;
    } else {
        wp_enqueue_script('validate.js', plugins_url('/assets/js/jquery.validate.min.js', __FILE__));
    }    
    wp_enqueue_script('popper.js', plugins_url('/assets/js/popper.min.js', __FILE__));
    wp_enqueue_script('bootstrap.min.js', plugins_url('/assets/js/bootstrap.min.js', __FILE__));

    wp_enqueue_style('main.css', plugins_url('/assets/css/main.css', __FILE__));
}
add_action('wp_head', 'tokenpass_scripts');

/* Delete tables on plugin delete */
register_uninstall_hook( __FILE__, 'my_plugin_remove_database' );
function my_plugin_remove_database() {
     global $wpdb;
     $table_name = $wpdb->prefix . 'tk_data';
     $sql = "DROP TABLE IF EXISTS $table_name";
     $wpdb->query($sql);
     delete_option("my_plugin_db_version");
}   

/* Create shortcode for calculator */
function tokenpass_shortcode(){

    // Things that you want to do. 
    load_template_part('templates','login-btn');

    // Output needs to be return
    // return $calc_html;
}
add_shortcode('tokenpass_login', 'tokenpass_shortcode');



/* load template call function */
function load_template_part($template_name, $part_name=null) {
    // ob_start();
    
    $var = tk_get_template_part(''.$template_name.'/'.$part_name.'', null);
    // ob_end_clean();
    return $var;
}

/* Fetching template */
function fetch_template(){
    load_template_part($_REQUEST['templateName'],$_REQUEST['fileName']);
    wp_die();
}
add_action('wp_ajax_nopriv_fetch_template', 'fetch_template');
add_action('wp_ajax_fetch_template', 'fetch_template');

    
/**
 * Register a custom menu page.
 */
function register_tokenpass_menu_page(){
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
        add_menu_page('Tokenpass', 'Tokenpass', 'manage_options', 'manage_tokenpass','tokenpass_menu_page',plugins_url( 'tokenpass/assets/images/tokenly-icon.png' ),6);
        add_submenu_page( 'manage_tokenpass', 'Tokenpass settings', 'Settings', 'manage_options', 'manage_tokenpass');
        add_submenu_page( 'manage_tokenpass', 'Tokenpass Documentation', 'Documentation', 'manage_options', 'tk_documentation','tk_documentation_html');

}
add_action( 'admin_menu', 'register_tokenpass_menu_page' );
 
/**
 * Display a custom menu page
 */
function tokenpass_menu_page(){
    // esc_html_e( 'Admin Page Test', 'textdomain' );  
//     echo '<div class="container">
//     <h2>Tokenpass Settings </h2>
//     <form>
//     <div class="form-group">
//       <label for="tk-client-id">Client ID : </label>
//       <input type="text" class="form-control" id="tk-client-id" aria-describedby="emailHelp" placeholder="Enter email">
//     </div>
//     <div class="form-group">
//       <label for="tk-client-secret">Client Secret : </label>
//       <input type="text" class="form-control" id="tk-client-secret" placeholder="Password">
//     </div>
//     <button type="button" class="btn btn-primary tk-settings-btn">Submit</button>
//   </form> </div>';
echo '<h2> Coming Soon with settings!! </h2>';

}

function tk_documentation_html(){
echo '<h2> Coming Soon !! </h2>';
}

function my_admin_style() {
    wp_enqueue_style( 'admin-style', plugins_url('/assets/css/admin-style.css', __FILE__) );
  }
add_action( 'admin_enqueue_scripts', 'my_admin_style');

add_action('init','tokenly_login_check');
function tokenly_login_check() { 

    if(isset($_GET['error'])){
        if($_GET['error'] == 'yes' ){
            $message = $_GET['message'];
            echo "<script>alert('".$message."');</script>";
            echo "<script>window.location.href = '/';</script>";            
        }else{
            if($_GET['logged_in'] == 'yes' ){
                $user_email = $_GET['useremail'];
                $message = $user_email.' you are successfully logged in.';
                echo "<script>alert('".$message."');</script>";            
                echo "<script>window.location.href = '/';</script>";            
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

add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3 );
function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
 
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