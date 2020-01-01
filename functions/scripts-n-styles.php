<?php

require_once dirname(__FILE__) . '/../libs/scssphp-1.0.6/scss.inc.php';

/*
 * Scss PHP for compiling scss with dynamic variables
 * https://scssphp.github.io/scssphp
 */

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Formatter\Crunched;

function generate_scss($primary_color = null, $secondary_color = null, $page_heading_color = null)
{
    // Instantiate the class
    // More info: https://scssphp.github.io/scssphp/docs
    $scss = new Compiler();
    // Set import paths
    $scss->setImportPaths(dirname(__FILE__) . '/../src/sass');
    // Set formatting
    $scss->setFormatter('ScssPhp\ScssPhp\Formatter\Crunched');
    // Fetch theme variables
    $primary_color = $primary_color ?: get_field('primary_color', 'option');
    $secondary_color = $secondary_color ?: get_field('secondary_color', 'option');
    $page_heading_color = $page_heading_color ?: get_field('page_heading_color', 'option');
    // Compile css
    $css = $scss->compile('
        // Sass variables
        $black: #3f3f3f;
        $white: #ffffff;
        $grey1: #4d4d4d;
        $grey2: #666565;
        $grey3: #cccccc;
        $grey4:#f4f0f0;
        
        // Theme variables
        $blue: ' . $primary_color . ';
        $darkblue: ' . adjust_brightness($primary_color, -20) . ';
        $lightblue: ' . adjust_brightness($primary_color, 50) . ';
        $linkhover: ' . adjust_brightness($primary_color, 20) . ';
        $orange: ' . $secondary_color . ';
        $header_background: ' . $page_heading_color . ';
                
        // Imports
        @import "fonts";
        @import "mixins_variables";
        @import "original_site_styles";
        @import "reset";
        @import "global_elements";
        @import "blogroll";
        @import "post";
        @import "pagination";
        @import "videos";
        
        // imports after variables/mixins/functions
        @import "gravity-forms/form";
        @import "main_content";
        @import "header";
        @import "footer";
    ');
    file_put_contents(dirname(__FILE__) . '/../css/style.css', $css);
}

function check_for_theme_custom_val_change($value, $post_id, $field)
{
    $generate = false;
    $primary = null;
    $secondary = null;
    $header = null;
    switch ($field['name']) {
        case 'primary_color':
            // get the old (saved) value
            $old_value = get_field('primary_color', 'option');
            // get the new (posted) value
            $new_value = $_POST['acf']['field_5e0264800f8cf'];
            // check if values changed
            if ($old_value != $new_value) {
                $primary = $new_value;
                $generate = true;
            }
            break;
        case 'secondary_color':
            // get the old (saved) value
            $old_value = get_field('secondary_color', 'option');

            // get the new (posted) value
            $new_value = $_POST['acf']['field_5e02648c0f8d0'];

            // check if values changed
            if ($old_value != $new_value) {
                $secondary = $new_value;
                $generate = true;
            }
            break;
        case 'page_heading_color':
            // get the old (saved) value
            $old_value = get_field('page_heading_color', 'option');

            // get the new (posted) value
            $new_value = $_POST['acf']['field_5e0264970f8d1'];

            // check if values changed
            if ($old_value != $new_value) {
                $header = $new_value;
                $generate = true;
            }
            break;
    }
    if ($generate) {
        generate_scss($primary, $secondary, $header);
    }
    return $value;
}

function load_style()
{
    wp_enqueue_style('slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', false);
    wp_enqueue_style('gfonts', '//fonts.googleapis.com/css?family=' . GFONTS, false);
    wp_enqueue_style('fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false);
    wp_enqueue_style('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', false);
    wp_enqueue_style('core', THEME . '/css/style.css', false);
}

function load_scripts()
{
    wp_scripts()->add_data('jquery', 'group', 1);
    wp_scripts()->add_data('jquery-core', 'group', 1);
    wp_scripts()->add_data('jquery-migrate', 'group', 1);
    wp_enqueue_script('jquery');
    wp_enqueue_script('slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array(), null, true);
    wp_enqueue_script('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array(), null, true);
    wp_enqueue_script('scripts', THEME . '/js/scripts.js', array(), null, true);
}

function adjust_brightness($hex, $steps)
{
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));
    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';
    foreach ($color_parts as $color) {
        $color = hexdec($color); // Convert to decimal
        $color = max(0, min(255, $color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }
    return $return;
}

function get_hex_rgb($hex)
{
    if ($hex[0] == '#') {
        $hex = substr($hex, 1);
    }
    if (strlen($hex) == 6) {
        list($r, $g, $b) = array($hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5]);
    } elseif (strlen($hex) == 3) {
        list($r, $g, $b) = array($hex[0] . $hex[0], $hex[1] . $hex[1], $hex[2] . $hex[2]);
    } else {
        return false;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return array('red' => $r, 'green' => $g, 'blue' => $b);
}

// Watch for theme customization changes
add_filter('acf/update_value', 'check_for_theme_custom_val_change', 10, 3);

// Enqueue main styles and scripts
add_action('wp_enqueue_scripts', 'load_style');
add_action('wp_enqueue_scripts', 'load_scripts');