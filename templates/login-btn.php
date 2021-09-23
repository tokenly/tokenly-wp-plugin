<?php 


if(!is_user_logged_in()){
  
  $calc_html = '
  <a href="'.get_site_url().'/wp-content/plugins/tokenpass/account/authorize/auth.php" id="tk-login-btn"> Login with Tokenly </a>';

}

echo $calc_html;

?>