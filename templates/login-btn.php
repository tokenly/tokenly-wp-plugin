<?php 

$calc_html = null;

if(!is_user_logged_in()){
  
  $calc_html = '
  <a href="'.get_site_url().'/wp-content/plugins/tokenly-wp-plugin-main/account/authorize/auth.php" id="tk-login-btn"> Login with Tokenly </a>';

}

echo $calc_html;

?>
