<?php
/**
 * SCREETS © 2018
 *
 * SCREETS, d.o.o. Sarajevo. All rights reserved.
 * This  is  commercial  software,  only  users  who have purchased a valid
 * license  and  accept  to the terms of the  License Agreement can install
 * and use this program.
 *
 * @package LiveChatX
 * @author Screets
 *
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once LCX_PATH . '/core/library/index.php';

use Leafo\ScssPhp\Compiler;
$scss = new Compiler();
$scss->setImportPaths( LCX_PATH . '/assets/css/basic' );

if( !empty( $_GLOBALS['lcx_compile_data'] ) ) {
    $compile_var = $_GLOBALS['lcx_compile_data'];
} else {

    $opts = array(
        'primary' => lcx_get_option( 'design', 'colors_primary' ),
        'secondary' => lcx_get_option( 'design', 'colors_secondary' ),
        'highlightColor' => lcx_get_option( 'design', 'colors_highlight' ),
        'radius' => lcx_get_option( 'design', 'ui_radius' ) . 'px',
        'radiusBig' => lcx_get_option( 'design', 'ui_radius_big' ) . 'px',
        'popupW' => lcx_get_option( 'design', 'ui_popup_width' ) . 'px',
        'starterSize' => lcx_get_option( 'design', 'ui_starter_size' ) . 'px',
        'offsetX' => lcx_get_option( 'design', 'ui_offset_x' ) . 'px',
        'offsetY' => lcx_get_option( 'design', 'ui_offset_y' ) . 'px',
        'starterIconW' => lcx_get_option( 'design', 'ui_starter_icon_size' ) . 'px',
        'position' => lcx_get_option( 'design', 'ui_position' )
    );

    $compile_var = array(
        'primary' => ( !empty( $opts['primary'] ) ) ? $opts['primary'] : '#e54045',
        'secondary' => ( !empty( $opts['secondary'] ) ) ? $opts['secondary'] : '#2294e3',
        'highlightColor' => ( !empty( $opts['highlightColor'] ) ) ? $opts['highlightColor'] : '#fffc79',
        'radius' => ( !empty( $opts['radius'] ) ) ? $opts['radius'] : '4px',
        'radiusBig' => ( !empty( $opts['radiusBig'] ) ) ? $opts['radiusBig'] : '8px',
        'popupW' => ( !empty( $opts['popupW'] ) ) ? $opts['popupW'] : '300px',
        'starterSize' => ( !empty( $opts['starter_size'] ) ) ? $opts['starterSize'] : '50px',
        'offsetX' => ( !empty( $opts['offset_x'] ) ) ? $opts['offset_x'] : '20px',
        'offsetY' => ( !empty( $opts['offset_y'] ) ) ? $opts['offset_y'] : '20px',
        'starterIconW' => ( !empty( $opts['starter_icon_size'] ) ) ? $opts['starter_icon_size'] : '30px',
        'position' => ( !empty( $opts['position'] ) ) ? $opts['position'] : 'bottom-right'
    );
}

// Include assets url if not exists
if( empty( $compile_var['assets-url'] ) ) {
    $plugin_url = str_replace( array( 'http://', 'https://' ), '//', LCX_URL );
    $compile_var['assets-url'] = $plugin_url . '/assets';
}

$scss->setVariables( $compile_var );
$scss->setFormatter( 'Leafo\ScssPhp\Formatter\Crunched' );

$lcx_dir = fn_lcx_get_upload_dir_var( 'basedir', '/lcx' );

if( !file_exists( $lcx_dir ) ) {
    if( ! mkdir( $lcx_dir, 0777, true ) ) {
        die( 'The directory is not writable: ' . $upload_dir['basedir'] );
    }
}

// Get full scss file url
$app_scc = file_get_contents( apply_filters( 'lcx_app_scss', LCX_PATH . '/assets/css/basic/app.scss' ) );
$iApp_scss = file_get_contents( apply_filters( 'lcx_app_iframe_scss', LCX_PATH . '/assets/css/basic/app-iframe.scss' ) );
$app_css = $lcx_dir . '/app.css';
$iApp_css = $lcx_dir . '/app-iframe.css';

// Create app.css and app-iframe files if not exists
if( !file_exists( $app_css ) || !file_exists( $app_css ) ) {
    $fh = fopen( $app_css, 'w' );
    $fhi = fopen( $iApp_css, 'w' );
}

// Compile now
$app = $scss->compile( $app_scc );
$iApp = $scss->compile( $iApp_scss );

// Include custom css code
$app .= ' ' . lcx_get_option( 'design', 'advanced_customCSS' );

file_put_contents( $app_css, $app );
file_put_contents( $iApp_css, $iApp );
