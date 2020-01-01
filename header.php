<?php
$he = isset($post) ? get_field('use_hero', $post->ID) : null;
$logo = get_field('logo', 'option');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title( '-', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="<?php echo THEME; ?>/img/favicon.ico" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header>
		<div class="center-col">
			<a href="<?php echo URL; ?>" id="site-brand">
                <?php if($logo) : ?>
                    <img id="header-logo" alt="<?php echo get_bloginfo('title'); ?>" src="<?php echo $logo['sizes']['thumbnail']; ?>" />
                <?php else : ?>
                <h1 id="header-title">
                    <?php echo get_bloginfo('title'); ?>
                </h1>
                <?php endif; ?>
            </a>
			<div id="menu">
				<?php 
					wp_nav_menu(array('menu' => 'Menu17', 'container' => '', 'menu_id' => 'navbar')); 
					soclinks();
				?>
			</div>
			<div id="burger">
				<div id="burger1"></div>
				<div id="burger2"></div>
				<div id="burger3"></div>
			</div>
		</div>

		<?php if($he) : ?>
		<div class="paws-trail"></div>
		<?php endif; ?>
	</header>
	<main class="main">