<?php 
$client_id = '447856164';
$client_secret = 'KQ8NNFGIm3t8HteuHktkSRcXX8RP9Ot6IUb8Fu8U';
$redirect_uri= "https://swag21.com/tokenly/wp-content/account/authorize/callback.php";
$authorization_code = $_GET['code'];
$user_auth = $_SESSION['state'];
// if(!$authorization_code){
//     die('something went wrong!');
// }
// $url = 'https://connect.squareup.com/oauth2/token';
$data = array(
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'code' => $authorization_code,
    'state'=> $user_auth
 );
// $options = array(
//     'http' => array(
//         'header'  => "Content-type: application/json\r\n",
//         'method'  => 'POST',
//         'content' => json_encode($data)
//     )
// );
// $context  = stream_context_create($options);
// // $result = file_get_contents($url, false, $context);
// var_dump($data);
// header('https://tokenpass.tokenly.com/oauth/authorize?client_id=447856164&redirect_uri=https://swag21.com/tokenly/wp-content/account/authorize/callback.php&scope=manage-address&response_type=code');

// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://tokenpass.tokenly.com/oauth/access-token?grant_type=authorization_code&code=def5020087cea1c60bed181cdb9b1cbf4c4c1bd7490d18f3168be673a4d1878620dcf0311c5d58c149c7c8f94911be01246da7c9c3f9ffb4ef6da5493684ff8b8d7651f5feb15529d9d47c022a9df2304d4d26a8d3fd12ef7c5808708c9946635ac4fcbbbbe34ec1c249dc7b8f97b674b030cfe33f61e9b7105cb9061d7af1fada7187fcc0da458fa13d3142237ee66a523912c93d5b9315b2acae72f4df8c00b288e9b9b5b440c99601811dbfa1838fa5f58815324f73be8b1bf0631d2126c5c7d2dbea069b9ef94a782cd9d77f7ae2e9d972f5bf1b0c7543166a14bfa2abaf34726d86fd876f96bd52c3df2218603947ba47ea7188c8ef431205ef451e528f7d7ef1637cd33f424c9b21e1c1c5ff6929269c245e42224c3966675ff1b17a3be434144b0426da7f9b06d5f46bb24dbd044e73b7320cfc913cd6a7f0057ad4ae5ac16b096e2f152f9dc5164b849834362749c23efcc0b6f10b4039073c822b20b5ab4e9e2367f5dbc5feb82431d148ec8e05b8213a5cfbf2310380397f2aa9c3db5e53a64b24d4d883b2bae29722&client_id=447856164&client_secret=KQ8NNFGIm3t8HteuHktkSRcXX8RP9Ot6IUb8Fu8U&redirect_uri=https://swag21.com/tokenly/wp-content/account/authorize/callback.php',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_HTTPHEADER => array(
//     'Cookie: XSRF-TOKEN=eyJpdiI6IlhZbGdKRXB4d21zTHVER3M3VXNobFE9PSIsInZhbHVlIjoiQ1plY3IzVXlsYmZ2WGl0by9uWWkrakNXVTdqa3NvaVp4QlpJTTJZMXk5eWxtTnlJQTBwbkpweW9VVkxiZVc0S3F4QnB6RktISUEvdDUxcnd0UmI0amk3NG9VYktEaVZwQnpNY2hOLzF2cDhZTUNZZ0NjZW1ENlhOWkdIZUIxUUwiLCJtYWMiOiJkYTE5MzViZTdkYmRkODgzNGU3MmYzMmVkNzE1MmE3NjQyZjY0NTRjY2JlZGIzODhkY2QxMDkwZjdiY2IwODkyIn0%3D; laravel_session=eyJpdiI6IjhzQmFVcXhNREJaTXFDRUpsYU9qQXc9PSIsInZhbHVlIjoiMDF3N0J1R1FyWkYwMXdKMURvU0FpbHl0NTczU2YwbWw2QXY0VnJrTHlYRFZ5Tkx1V3djbDg2NnBBZWlZQXczWlREeVFsOFdYZGt1ZUtKL25rLzd6eE9zTWZsckk3Zm4zU2MzOHdZUmlPMVpjMERuRW9vL1Qvc2hZWTlURXlFRWsiLCJtYWMiOiI3Yzc4MWRlNzgyYjY0YTI3ZGE4MDkyMWQwMGQwYjBjNjIzMDIzNDY3MmUwMGY2MWM2NGM3NWZjYzdmOGI5ZDEyIn0%3D'
//   ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response;

if(isset($authorization_code)){
    // API BODY
    $body = '{
        "grant_type": "rules-LoanCalcRepayments-US",
        "code": "'.$authorization_code.'",
        client_id:"'.$client_id.'",
        client_secret:"'.$client_secret.'",
        redirect_uri:"'.$redirect_uri.'"
  }';
  $ch = curl_init('https://tokenpass.tokenly.com/oauth/access-token');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLINFO_HEADER_OUT, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Expect: ',
      'Content-Length: ' . strlen($body))
  );
  $result = curl_exec($ch);
  $response_decode = json_decode($result, true);
}


echo json_encode($data);
?>