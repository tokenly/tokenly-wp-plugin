<?php
/**
 * Template Name: Tokenpass Dashboard
 */
// get_header();

if ( is_user_logged_in() ) {
	$user_id           = get_current_user_id();
	$user              = wp_get_current_user();
	$user_access_token = get_user_meta( $user_id, 'access-token', true );
	$user_data         = $user->data;

	/** Public Balance API */
	$curl = curl_init();

	curl_setopt_array(
		$curl,
		array(
			CURLOPT_URL            => 'https://tokenpass.tokenly.com/api/v1/tca/public/balances?oauth_token=' . $user_access_token . '&Scopes=tca',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'GET',
		)
	);

	$response = curl_exec( $curl );

	$result = json_decode( $response );

	$tokens_asset      = null;
	$tokens_name       = null;
	$tokens_balance    = null;
	$tokens_balanceSat = null;

	if ( $result ) {
		$tokens_asset      = $result->asset;
		$tokens_name       = $result->name;
		$tokens_balance    = $result->balance;
		$tokens_balanceSat = $result->balanceSat;
	}

	curl_close( $curl );

	/** Private Balance API */

	$curl_1 = curl_init();

	curl_setopt_array(
		$curl_1,
		array(
			CURLOPT_URL            => 'https://tokenpass.tokenly.com/api/v1/tca/protected/balances?oauth_token=' . $user_access_token . '&Scopes=private-balances',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'GET',
		)
	);

	$response_1 = curl_exec( $curl_1 );
	$result_1   = json_decode( $response_1 );

	curl_close( $curl_1 );
} else {
	echo 'you are not signed in';
}
?>

<div>
<h1>Token Inventory</h1>
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

foreach ( $result as $key => $val ) {
	echo ' <tr>
      <th scope="row">' . $val->asset . '</th>
      <td>' . $val->name . '</td>
      <td>' . $val->balance . '</td>
      <td>' . $val->balanceSat . '</td>
    </tr>';
}
?>
  </tbody>
</table>
</div>


<?php

// get_footer();

?>
