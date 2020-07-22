<?php
require __DIR__ . '/../vendor/autoload.php';

use phpseclib\Crypt\RSA;

$update_cache_url = $_GET['url'] ?? $_GET['link'] ?? '';
$request_url      = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$domain = parse_url( $request_url, PHP_URL_HOST );

if ( empty( $update_cache_url ) || strpos( $update_cache_url, $domain ) === false ) {
	die( 'Please provide a valid url with ' . $domain . ' domain, given: ' . $update_cache_url );
}

$private_key_path = __DIR__ . '/private-key.pem';

$rsa = new RSA();
$rsa->loadKey( file_get_contents( $private_key_path ) );

$update_cache_url = str_replace( 'https://', '', $update_cache_url );
$plaintext        = '/update-cache/c/s/' . $update_cache_url . '?amp_action=flush&amp_ts=' . time();

$rsa->setSignatureMode( RSA::SIGNATURE_PKCS1 );
$rsa->setHash( 'sha256' );

$signature        = $rsa->sign( $plaintext );
$base64_signature = base64url_encode( $signature );

// $rsa->loadKey(file_get_contents(__DIR__ . '/../../.well-known/amphtml/apikey.pub'));
// echo $rsa->verify($plaintext, $signature) ? 'verified' : 'unverified';

$amp_domain_format = str_replace( '.', '-', $domain );

$amp_request_update_url = 'https://' . $amp_domain_format . '.cdn.ampproject.org' . $plaintext . '&amp_url_signature=' . $base64_signature;

$response = curl_get( $amp_request_update_url );

echo $response;
exit( 0 );

function base64url_encode( $data ) {
	return rtrim( strtr( base64_encode( $data ), '+/', '-_' ), '=' );
}


/**
 * Send a GET requst using cURL
 *
 * @param string $url to request
 * @param array  $get values to send
 * @param array  $options for cURL
 * @return string
 */
function curl_get( $url, array $get = null, array $options = array() ) {
	$defaults = array(
		CURLOPT_URL            => $url . ( strpos( $url, '?' ) === false ? '?' : '' ) . http_build_query( $get ),
		CURLOPT_HEADER         => 0,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT        => 4,
	);

	$ch = curl_init();
	curl_setopt_array( $ch, ( $options + $defaults ) );
	if ( ! $result = curl_exec( $ch ) ) {
		trigger_error( curl_error( $ch ) );
	}
	curl_close( $ch );
	return $result;
}
