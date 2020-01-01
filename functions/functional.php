<?php

/*
 * Global variables
 * See: https://codex.wordpress.org/Global_Variables
 */
//global $wp; // The global instance of the Class_Reference/WP class
//global $wpdb; // The global instance of the Class_Reference/wpdb class.

/**
 * Catch-all for any sub-pages in /adoption-information/
 * 301 them to a CMS page saying the animal has been adopted and link to the adoption page
 */
add_action('wp', 'check_if_is_adoption_page');

function check_if_is_adoption_page()
{
    // Get the path
    $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    // If path ends with slash, remove it
    if (substr($url, -1) === '/') $url = rtrim($url, '/');

    // Get the last segment of the url (this will be the WP slug for the entry
    $segments = explode('/', $url);
    $last_segment = array_pop($segments);
    $second_to_last = array_pop($segments);

    // Only car about adoption pages
    if ($second_to_last !== 'adoption-information') return;

    // Attempt to get the pet based on the path
    $pet = get_page_by_path($last_segment, OBJECT, 'pet');

    // If page not found, or is set to publish, defer to default WP action
    if ($pet !== null || $pet->post_status === 'publish') return;

    // If we didn't find the pet, redirect to adoption page, else show 404
    if ($pet === null) {
        wp_redirect(get_permalink(27), 301); // Redirect to the adoption page
        exit();
    } else {
        get_404_template();
    }
}

// Add responsive div around oEmbed urls
add_action('after_setup_theme', 'setup_theme');

function setup_theme()
{
    // Filters the oEmbed process to run the responsive_embed() function
    add_filter('embed_oembed_html', 'responsive_embed', 10, 3);
}

/**
 * Adds a responsive embed wrapper around oEmbed content
 * @param  string $html The oEmbed markup
 * @param  string $url The URL being embedded
 * @param  array $attr An array of attributes
 * @return string       Updated embed markup
 */
function responsive_embed($html, $url, $attr)
{
    return $html !== '' ? '<div class="video-container">' . $html . '</div>' : '';
}

/**
 * Customize Gravity Form ajax spinner
 *
 * @param $image_srca
 * @param $form
 * @return string
 */
function gf_spinner_replace($image_src, $form)
{
    return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; // relative to you theme images folder
}

add_filter('gform_ajax_spinner_url', 'gf_spinner_replace', 10, 2);

/**
 * Remove inline styles from post content
 */
add_filter('the_content', function ($content) {
    // Clear out inline styles for p, h1, h2, and h3 tags

    /*    $content = preg_replace('#<p.*?>(.*?)</p>#i', '<p>\1</p>', $content);*/
    /*    $content = preg_replace('#<ul.*?>(.*?)</ul>#i', '<ul>\1</ul>', $content);*/
    /*    $content = preg_replace('#<li.*?>(.*?)</li>#i', '<li>\1</li>', $content);*/

    $content = preg_replace('#<h3.*?>(.*?)</h3>#i', '<h3>\1</h3>', $content);
    $content = preg_replace('#<h2.*?><strong>(.*?)</strong></h2>#i', '<h2 class="section-heading non-mobile">\1</h2>', $content);
    $content = preg_replace('#<h2.*?>(.*?)</h2>#i', '<h2 class="section-heading non-mobile">\1</h2>', $content);
    $content = preg_replace('#<h1.*?>(.*?)</h1>#i', '<h1>\1</h1>', $content);
    return $content;
}, 20);