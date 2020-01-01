<?php /* Template Name: HomePage */

get_header();

	$shl 		= get_field('support_headline');
	$scon 		= get_field('support_content');
	$scta 		= get_field('support_cta');
	$slink		= get_field('support_cta_link');
	$vid_img 	= get_field('video_thumbnail');
	$vid_url 	= get_field('video_url');
	$vid_id		= get_yt($vid_url);

	pagehero($post->ID);

	vidbloc($vid_img, $vid_id, $scon, $scta, $slink, $shl); ?>

<?php get_footer();

