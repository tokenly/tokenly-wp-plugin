<?php
/**
 * Plugin Name:     Tokenpass OAuth 2.0
 * Plugin URI:      https://www.tokenly.com/
 * Description:     Tokenpass OAuth 2.0 integration plugin.
 * Author:          Nick Arora
 * Author URI:      https://tokenly.com/
 * Text Domain:     tokenly-wp-plugin
 * Domain Path:     /languages
 * Version:         0.3
 *
 * @package         Tokenly_Wp_Plugin
 */

namespace Tokenly\Wp;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'TOKENLY_PLUGIN_DIR', plugin_dir_path( dirname( __FILE__ ) ) . '/tokenly-wp-plugin/' );

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

use Tokenly\Wp\Bootstrap;

$bootstrap = new Bootstrap();
$bootstrap->boot();
