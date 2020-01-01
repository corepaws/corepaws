<?php
define('URL', site_url());
define('THEME', get_bloginfo('template_directory'));
define('IMG', THEME . '/img/');
define('GFONTS', 'Source+Sans+Pro:600,700');

// Define path and URL to the ACF plugin.
define('MY_ACF_PATH', dirname(__FILE__) . '/../libs/acf/');
define('MY_ACF_URL', THEME . '/libs/acf/');

// Include the ACF plugin.
include_once(MY_ACF_PATH . 'acf.php');

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url($url)
{
    return MY_ACF_URL;
}

// (Optional) Hide the ACF admin menu item.
add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin($show_admin)
{
    return false; // false to hide, true to show
}

if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}
