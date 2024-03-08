<?php

/*
Plugin Name: Atmos
Plugin URI: https://luxibay.com/plugins/atmos
Author: Luxibay
Author URI: https://luxibay.com/
Description: The Atmos plugin adds a Gravity Forms element to Oxygen. Brought to you by Luxibay. 
Version: 1.0
Requires Plugins: gravityforms, oxygen
Text Domain: atmos
*/

define("ATMOS_PATH", plugin_dir_path(__FILE__) . "frame");
define("ATMOS_MAIN", __FILE__);
define('ATMOS_STORE_URL', 'https://luxibay.com');
define('ATMOS_VERSION', '1.0');
define('ATMOS_NAME', 'Atmos');


add_action('init', 'atmos_launch');

function atmos_launch()
{
    require_once(__DIR__ . '/vendor/autoload.php');
    require_once(ATMOS_PATH . '/atmos-connect.php');

    $atmos = new Atmos_Connect();
}
