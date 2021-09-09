<?php 

// GET ROOT DIRECTORY OF WEBSITE
$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
include($path.'wp-load.php');

$current_web_url =  "https://";;
$current_web_url .=  $_SERVER['HTTP_HOST'].'/tokenly';

$client_id = '447856164';
$client_secret = 'KQ8NNFGIm3t8HteuHktkSRcXX8RP9Ot6IUb8Fu8U';
$redirect_uri= "".$current_web_url."/wp-content/plugins/tokenpass/account/authorize/callback.php";
$authorization_code = $_GET['code'];
$user_auth = $_SESSION['state'];

$data = array(
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'code' => $authorization_code,
    'state'=> $user_auth
 );

if(isset($authorization_code)){

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'https://tokenpass.tokenly.com/oauth/access-token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "grant_type": "authorization_code",
    "code": "'.$authorization_code.'",
    "client_id": "447856164",
    "client_secret": "KQ8NNFGIm3t8HteuHktkSRcXX8RP9Ot6IUb8Fu8U",
    "redirect_uri": "'.$current_web_url.'/wp-content/plugins/tokenpass/account/authorize/callback.php"
}',
  CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);


$result = json_decode($response);

curl_close($curl);
$curl_1 = curl_init();

  curl_setopt_array($curl_1, array(
    CURLOPT_URL => 'https://tokenpass.tokenly.com/oauth/user?access_token='.$result->access_token.'',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
  ));
  
  $response_userData_decode = curl_exec($curl_1);
  $response_userData = json_decode($response_userData_decode);
  

  $username = $response_userData->username;
  $id = $response_userData->id;
  $email = $response_userData->email;
  $email_confirmed = $response_userData->email_is_confirmed;
  $kyc_verification_status = $response_userData->kyc_verification_status;

  if ( isset($username)) {
    $user_id = username_exists($username);
    $user_email = $email;
  }else{
    $user_id = 'false';
  }

  if ( $user_id != 'false') {

    if ( ! $user_id && false == email_exists( $user_email ) ) {
      $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
      $user_name = $username;
      $user_id = wp_create_user( $user_name, $random_password, $user_email );
  
      add_user_meta( $user_id, 'email_confirmed', $email_confirmed );
      add_user_meta( $user_id, 'usr_pass', $random_password );
      add_user_meta( $user_id, 'kyc_verification_status', $kyc_verification_status);
  
      $creds = array(
        'user_login'    => $user_name,
        'user_password' => $random_password,
        'remember'      => true
      );
  
      $user = wp_signon( $creds, false );
  
      if ( is_wp_error( $user ) ) {
          echo $user->get_error_message();
      }
      wp_new_user_notification($user->data->ID, $random_password);

      // echo"<pre>"; prTint_r($user); echo "</pre>";

      $redirect_url = $current_web_url.'/?error=no&user_register=yes&useremail='.$username.'';
      echo "<script>window.location.href='".$redirect_url."';</script>";

    } else {
      global $wp;
      $user_pass = get_user_meta( $user_id, 'usr_pass', true );
  
      $creds = array(
        'user_login'    => $user_email,
        'user_password' => $user_pass,
        'remember'      => true
      );
      $user =   wp_signon( $creds, true );

      $redirect_url = $current_web_url.'/?error=no&logged_in=yes&useremail='.$username.'';
      echo "<script>window.location.href='".$redirect_url."';</script>";
    }
  }else{
    $url = "https://";
    $url .= $_SERVER['HTTP_HOST'];
    $redirect_url = $current_web_url.'/?error=yes&message=No, user found with this username '.$username.'';
    echo "<script>window.location.href='".$redirect_url."';</script>";
  }  
}

?>