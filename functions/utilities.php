<?php // functions/utilities //

// >from v1 :

// Wordpress: Strips information out of head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// Wordpress: Disable all Theme Update Notifications
remove_action('load-update-core.php', 'wp_update_themes');
add_filter('pre_site_transient_update_themes', create_function('$a', "return null;"));

// Wordpress: Adds Featured Image functionality to pages/posts
add_theme_support('post-thumbnails');

// Wordpress: This theme uses wp_nav_menu() in one location.
add_theme_support('menus');

// Wordpress: Disable WordPress Admin Bar for all users
show_admin_bar(false);

// WordPress: Add slug name to body class
add_filter('body_class', 'add_body_class');
function add_body_class($classes)
{
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

// WordPress: Prevents Generation of uploaded images in the following sizes
add_filter('intermediate_image_sizes_advanced', 'add_image_insert_override');
function add_image_insert_override($sizes)
{
    update_option('thumbnail_size_w', 200);
    update_option('thumbnail_size_h', 200);
    update_option('thumbnail_crop', 1);
    unset($sizes['medium']);
    unset($sizes['large']);
    return $sizes;
}


// Returns the image URL from post ID
function get_image_url($id)
{
    $image_id = get_post_thumbnail_id($id);
    $feat_image = "";
    if ($image_id) {
        $image_attributes = wp_get_attachment_image_src($image_id, 'full', true);
        $feat_image = $image_attributes[0];
    }
    return $feat_image;
}

// >added v2 :

add_theme_support('post-thumbnails');
add_image_size('pet-line', 180, 120, true);
add_image_size('info-block', 449, 449, true);
add_image_size('page-hero', 1280, 586, true);

function regis_nav()
{
    register_nav_menu('nav-prime', __('Prime Navigation'));
}

add_action('init', 'regis_nav');


// let's have that slug then Daniel
function cook_slug($str)
{
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', "-", $str);
    rtrim($str, '-');
    return $str;
}


// limit sentence (text) to word count (limit)
function words_to($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

// strip everything out of number (for phone)
function nu($i)
{
    return preg_replace("/[^0-9]/", "", $i);
}

// strip http / https
function cleanurl($url)
{
    $disallowed = array('http://', 'https://');
    foreach ($disallowed as $d) {
        if (strpos($url, $d) === 0) {
            return str_replace($d, '', $url);
        }
    }
    return $url;
}

// extract youtube ID
function get_yt($url)
{
    $rl = urldecode(rawurldecode($url));
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $rl, $matches);
    return $matches[1];
}


