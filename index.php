<?php

/*
 * Plugin Name: E-Learning by UNITE
 * Plugin URI: https://unite.sk
 * Description: Plugin providing e-learning system
 * Version: 1.0.0
 * Author: UNITE
 * Author URI: https://unite.sk
 * Text Domain: wp-unite-elearning
 */

$plugin_dir = str_replace( basename( __FILE__ ), "", plugin_basename( __FILE__ ) );
$plugin_dir = substr( $plugin_dir, 0, strlen( $plugin_dir ) - 1 );
define( 'UN_ELING_PATH', plugin_dir_path( __FILE__ ) );
define( 'UN_ELING_DIR', $plugin_dir );
define( 'UN_ELING_INDEX', __FILE__ );

// Core
require_once 'lib' . DIRECTORY_SEPARATOR . 'UN_EL_Core.php';

// Other libraries
require_once 'lib' . DIRECTORY_SEPARATOR . 'UN_EL_ACFD.php';
require_once 'lib' . DIRECTORY_SEPARATOR . 'UN_EL_Class.php';
require_once 'lib' . DIRECTORY_SEPARATOR . 'UN_EL_QR.php';
require_once 'lib' . DIRECTORY_SEPARATOR . 'UN_EL_PDF.php';
require_once 'lib' . DIRECTORY_SEPARATOR . 'UN_EL_REST.php';
require_once 'lib' . DIRECTORY_SEPARATOR . 'UN_EL_Shortcode.php';
require_once 'lib' . DIRECTORY_SEPARATOR . 'UN_EL_Test.php';

// Plugin initialization
UN_EL_Core::init();
