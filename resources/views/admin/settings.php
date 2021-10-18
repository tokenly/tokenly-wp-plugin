<?php
$html = "
	<script>
		const appHomepageUrl = `{$data['app_homepage_url']}`;
		const clientAuthUrl = `{$data['client_auth_url']}`;
	</script>
	<div id='tokenpass-settings-page-content'></div>
";
echo $html;
