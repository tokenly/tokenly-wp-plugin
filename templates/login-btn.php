<?php 

$calc_html = null;

if(!is_user_logged_in()){
  // $calc_html = '<a href="'.get_site_url().'/wp-content/plugins/tokenly-wp-plugin-main/account/authorize/auth.php" id="tk-login-btn" class="btn btn-lg btn-primary">Login with Tokenpass</a>';
  $calc_html = '<a href="'.get_site_url().'/wp-content/plugins/tokenpass/account/authorize/auth.php" id="tk-login-btn" class="btn btn-lg btn-primary">Login with Tokenpass</a>';
}

echo $calc_html;

?>
