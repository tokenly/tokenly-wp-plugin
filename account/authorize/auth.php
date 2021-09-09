<?php 
session_start();
$random_num = rand(10,100);
$state = hash('sha256', $random_num);
$_SESSION['user_state'] = $state; 

$current_web_url =  "https://";;
$current_web_url .=  $_SERVER['HTTP_HOST'].'/';
// $current_web_url .=  $_SERVER['HTTP_HOST'].'/';

$callback_url = ''.$current_web_url.'/wp-content/plugins/tokenpass/account/authorize/callback.php';
header("HTTP/1.1 301 Moved Permanently");header('Location:https://tokenpass.tokenly.com/oauth/authorize?client_id=447856164&redirect_uri='.$callback_url .'&scope=user,tca&response_type=code&state='.$state.'');

die;?>

