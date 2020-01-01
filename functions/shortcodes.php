<?php

// copyright symbol [cr]
function copy_r()
{
    return '&copy;';
}

add_shortcode('cr', 'copy_r');

// current year [yr]
function year_r()
{
    return date('Y');
}

add_shortcode('yr', 'year_r');

// site url [url]
function url_r()
{
    return URL;
}

add_shortcode('url', 'url_r');

// clients field shortcode
function client_field()
{
    $str = '<div class="clients-list">';
    $str .= '<img src="' . IMG . 'clients-1.png" alt="clients">';
    $str .= '<img src="' . IMG . 'clients-2.png" alt="clients">';
    $str .= '</div>';
    return $str;
}

add_shortcode('clients', 'client_field');


function drop_social_links()
{
    $slinks = get_field('social_links', 'Options');
    $c = count($slinks);
    $str = '<div class="social-links" style="width: ' . ($c * 52) . 'px;">';
    foreach ($slinks as $cn => $lnk) :
        $l = $lnk['link'];
        $str .= '<a href="' . $l . '" ';
        if (strpos($l, "http://") !== false || strpos($l, "https://")) :
            $str .= 'target="_blank"';
        endif;
        $str .= '><i class="fa ' . $lnk['icon'] . '"></i></a>';
    endforeach;
    $str .= '</div>';
    return $str;
}

add_shortcode('social-links', 'drop_social_links');

?>