<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

/*Theme info*/
function stm_get_theme_info()
{
	$theme = wp_get_theme();
	$theme_name = $theme->get('Name');
	$theme_v = $theme->get('Version');
	$author = $theme->get('Author');
	$author = explode(' ', $author);
	$author =  $author[2];

	$theme_info = array(
		'name' => $theme_name,
		'slug' => sanitize_file_name(strtolower($theme_name)),
		'v' => $theme_v,
		'auth' => $author
	);

	return $theme_info;
}

function stm_beautify_theme_response($theme)
{
	return array(
		'id' => $theme['id'],
		'name' => (!empty($theme['wordpress_theme_metadata']['theme_name']) ? $theme['wordpress_theme_metadata']['theme_name'] : ''),
		'author' => (!empty($theme['wordpress_theme_metadata']['author_name']) ? $theme['wordpress_theme_metadata']['author_name'] : ''),
		'version' => (!empty($theme['wordpress_theme_metadata']['version']) ? $theme['wordpress_theme_metadata']['version'] : ''),
		'url' => (!empty($theme['url']) ? $theme['url'] : ''),
		'author_url' => (!empty($theme['author_url']) ? $theme['author_url'] : ''),
		'thumbnail_url' => (!empty($theme['thumbnail_url']) ? $theme['thumbnail_url'] : ''),
		'rating' => (!empty($theme['rating']) ? $theme['rating'] : ''),
	);
}

function stm_get_token()
{
	$token = get_option('envato_market', array());
	$return_token = '';
	if (!empty($token['token'])) {
		$return_token = $token['token'];
	}

	return $return_token;
}

function stm_check_token( $args = array() ) {

	$has_token = get_site_transient('stm_theme_token_added');
	$purchased = false;
	$theme = stm_get_theme_info();
	$item_name = $theme['name'];
	$get_token = stm_get_token();

	if ( $get_token == $theme['auth'] ) $purchased = true;

	if ( false === $has_token ) {
		$defaults = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . stm_get_token(),
				'User-Agent' => 'WordPress - Shopme' . $theme['v'],
			),
			'filter_by' => 'wordpress-themes',
			'timeout' => 20,
		);
		$args = wp_parse_args($args, $defaults);

		$url = 'https://api.envato.com/v3/market/buyer/list-purchases?filter_by=wordpress-themes';

		$response = wp_remote_get(esc_url_raw($url), $args);

		// Check the response code.
		$response_code = wp_remote_retrieve_response_code($response);

		if ($response_code == '200') {
			$return = json_decode(wp_remote_retrieve_body($response), true);
			foreach ($return['results'] as $theme) {
				$theme_info = stm_beautify_theme_response($theme['item']);

				if ($theme_info['name'] == $item_name) {
					$purchased = true;
					set_site_transient('stm_theme_token_added', 'token_set');
				}
			}

			if (!$purchased) {
				$purchased = false;
				delete_site_transient('stm_theme_token_added');
			}
		}
	} else {
		$purchased = true;
	}

	return $purchased;
}

function stm_set_token() {
	if ( isset($_POST['stm_registration']) ) {
		if (isset($_POST['stm_registration']['token'])) {
			delete_site_transient('stm_theme_token_added');

			$token = array();
			$token['token'] = sanitize_text_field($_POST['stm_registration']['token']);

			update_option('envato_market', $token);

			$envato_market = Envato_Market::instance();
			$envato_market->items()->set_themes(true);
		}
	}
}

add_action('init', 'stm_set_token');

//Admin tabs
function stm_get_admin_tabs( $screen = 'shopme' ) {
	$theme = stm_get_theme_info();
	$theme_name = $theme['name'];
	$theme_name_sanitized = 'shopme';
	if ( empty($screen) ) {
		$screen = $theme_name_sanitized;
	}
	?>
	<div class="clearfix">
		<div class="stm_theme_info">
			<div class="stm_theme_version"><?php echo $theme['v']; ?></div>
		</div>
		<div class="stm-about-text-wrap">
			<h1><?php printf( esc_html__('Welcome to %s', 'shopme'), $theme_name ); ?></h1>
			<div class="stm-about-text about-text">
				<p class="about-description">
				<?php printf( __('We would like to thank you for purchasing Shopme WordPress + eCommerce Theme! We are very pleased you have chosen Shopme WordPress for your website, you will be never disappointed! Before you get started, please be sure to always check out this documentation. We outline all kinds of good information, and provide you with all the details you need to use Shopme WordPress Theme. Shopme WordPress can only be used with WordPress and we assume that you already have WordPress installed and ready to go.', 'shopme') ); ?>
			</p>
			<p class="about-description">
				<?php printf( __('If you are unable to find your answer here in our documentation, we encourage you to contact us through <a href="%s" target="_blank">support page</a> or themeforest item support page with your site CPanel (or FTP) and WordPress admin details. We\'re very happy to help you and you will get reply from us more faster than you expected.', 'shopme'), 'https://velikorodnov.ticksy.com') ?>
			</p>
			</div>
		</div>
	</div>
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo ( 'shopme' === $screen ) ? '#' : esc_url_raw(admin_url('admin.php?page=' . $theme_name_sanitized)); ?>"
		   class="<?php echo ( 'shopme' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e('Product Registration', 'shopme'); ?></a>
		<a href="<?php echo esc_url_raw(admin_url('admin.php?page=shopme')); ?>" class="nav-tab" ><?php esc_attr_e('Theme Options', 'shopme'); ?></a>
	</h2>
	<?php
}