<?php /* Template Name: Go To Page */

$d = get_field('destination_page');
if($d) {
	wp_safe_redirect(get_permalink($d->ID)); exit;
}



?>