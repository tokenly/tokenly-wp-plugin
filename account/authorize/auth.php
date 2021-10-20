<?php 
session_start();
define( 'WP_USE_THEMES', false );
require_once( $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-load.php' ); 

$tk_settings_options = get_option( 'tk_settings_option_name' ); // Array of All Options

$client_id_0 = (isset($tk_settings_options['client_id_0'])) ? $tk_settings_options['client_id_0'] : ''; // Client ID
$client_secret_1 = (isset($tk_settings_options['client_secret_1'])) ? $tk_settings_options['client_secret_1'] : ''; // Client Secret


$random_num = rand(10,100);
$state = hash('sha256', $random_num);
$_SESSION['user_state'] = $state; 

$current_web_url =  "https://";;
$current_web_url .=  $_SERVER['HTTP_HOST'].'';
$callback_url = $current_web_url.'/wp-content/plugins/tokenpass/account/authorize/callback.php';
// $callback_url = $current_web_url.'/wp-content/plugins/tokenly-wp-plugin-main/account/authorize/callback.php';



wp_redirect('https://tokenpass.tokenly.com/oauth/authorize?client_id='.$client_id_0.'&redirect_uri='.$callback_url.'&scope=user,tca&response_type=code&state='.$state.'');

die;
