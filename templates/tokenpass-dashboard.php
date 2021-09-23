<?php
/**
* Template Name: Tokenpass Dashboard
*
*/
get_header();

if(is_user_logged_in()){

    $user_id = get_current_user_id();
    $user = wp_get_current_user();
    // $user_access_token = get_user_meta($user_id, 'access-token', true);
    $user_access_token ='eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxODY1MDg1NDc1IiwianRpIjoiNWUzNzNiZDY1ZWQ4Nzc3MDk5OGE3NGQxM2ZiZDA4ZGNkNjcyNTU4M2Y4NDIyZDNlODU4MGQ3M2NiZTE2NTdlYjBkY2U5NTQ5NDA4ZGQ3OTAiLCJpYXQiOjE2MzIyMzAxMzkuOTY1ODc5LCJuYmYiOjE2MzIyMzAxMzkuOTY1ODgzLCJleHAiOjE2NjM3NjYxMzkuOTU2MTUxLCJzdWIiOiIyMDcwMyIsInNjb3BlcyI6WyJ1c2VyIiwidGNhIl19.DFJQyi7ZXH9JV9aRLucTOC3f6axxyXfHlkqzwsb-ZH_VoCuYvGZ64M3vFK5GyP6QMPQ4R3Z3OUubJQ9yKVtv4TXDdUfhjzxu1jFg7-bmRB3h9OHXyKfAnaU4cwG7GM_5sd55cMkb1g974LNoyaqM4a8KFL32FsyKsaSR0ZJdOYxe3vM1jjS39LB9GjvHh8qGkZW8tUaN8eYXCOU208kLhsTsoo-1JJtdg2kOpnPtyaJLOo-TzWXWCu6R352b2v2lAODTZd9iQgimgmgmqOZAuSPR_daFHkoN3B7D5oMiuvKOHaSx1mzz_4qaWvZQ-C2D5U6ZicoMBCEpxxdiY4X0X903U2faNi9yKLflz4F_GjdfcIr3ZE3yJcHJHZBH4W2oOhX8UTa7P9fN_J4-t69nPjZnu5P83gCNauIs_D1wXDrnXgZ8p--Tm5BPD311yvZdarTLUILqqN7uuKEcRbENzyYU6VYIQ_MIcx7iUonAncu1QrJ3Z_hBEVANlG9xbeZHA08vqTgXZUr_YYwl7_LFasGwWwSxv3QAroxweR53_h5D6s5k6MqWFzylpfU-rxA886AxNeRhj4ifcz8VCfMNcLfF5FGdmANvE8a0WkY4valL0PST2MyBaftj7F2FT8VIQ6bePqatnHb7FOJXS9-EWKU-5Rwaa347U6DFA_16ohE';
    $user_data = $user->data;
  // echo"<pre> user_access_token -> "; print_r($user_access_token); echo "</pre>";
    /** Public Balance API */
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://tokenpass.tokenly.com/api/v1/tca/public/balances?oauth_token='.$user_access_token.'&Scopes=tca',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

    $response = curl_exec($curl);
    
    $result = json_decode($response);
    // echo"<pre>"; print_r($result); echo "</pre>";
    // echo"<pre> response => "; print_r($response); echo "</pre>";
    $tokens_asset = $result->asset;
    $tokens_name = $result->name;
    $tokens_balance = $result->balance;
    $tokens_balanceSat = $result->balanceSat;

    // echo"<pre> api response - "; print_r($response); echo "</pre>";
    // echo"<pre> api results - "; print_r($result); echo "</pre>";
    
    curl_close($curl); 
    
    /** Private Balance API */

    $curl_1 = curl_init();

    curl_setopt_array($curl_1, array(
        CURLOPT_URL => 'https://tokenpass.tokenly.com/api/v1/tca/protected/balances?oauth_token='.$user_access_token.'&Scopes=private-balances',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

    $response = curl_exec($curl_1);
    $result_1 = json_decode($response_1);
    
    // echo"private api response - <br>";
    // echo"<pre> api response - "; print_r($response_1); echo "</pre>";
    // echo"<pre> api results - "; print_r($result_1); echo "</pre>";
    
    curl_close($curl_1); 

    // if($response == '' || $response == 0 || $response == null){
    //     $tokens_balance = 0;
    // }else{
    //     $tokens_asset = $response['asset'];
    //     $tokens_name = $response['name'];
    //     $tokens_balance = $response['balance'];
    //     $tokens_balanceSat = $response['balanceSat'];
    // }
    // echo "if";
    // echo"<pre>"; print_r($user_id); echo "</pre>";
    // echo"<pre>"; print_r($user_access_token); echo "</pre>";
    // echo"<pre>"; print_r($user_data->data); echo "</pre>";

}else{
    echo "you are not signed in";
}
?>

<h2> Welcome to Dashboard </h2>
<div>
    Hi,<span> <?php echo $user_data->user_login; ?>

</div>

<div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Asset</th>
      <th scope="col">Name</th>
      <th scope="col">Balance</th>
      <th scope="col">BalanceSat</th>
    </tr>
  </thead>
  <tbody>
<?php

foreach ($result as $key => $val){ 

echo' <tr>
      <th scope="row">'.$val->asset.'</th>
      <td>'.$val->name.'</td>
      <td>'.$val->balance.'</td>
      <td>'.$val->balanceSat.'</td>
    </tr>';
}
?>
  </tbody>
</table>
</div>


<?php 

get_footer(); 

?>