<?php /* Template Name: Team Page */ ?>
<?php get_header();

	$pid = wp_get_post_parent_id(get_the_ID());
	$team = get_field('team', $pid);

	pagehero($post->ID);

	foreach($team as $coun => $t) : ?>
	<div class="row info-block">	
		<div class="center-col">
			<div class="left-col">
				<img class="full-img" src="<?php echo $t['image']['sizes']['info-block']; ?>">
			</div>
			<div class="right-col mobile-padded">
				<h2 class="section-heading"><span class="name"><?php echo $t['name'] ?></span>, <?php echo $t['title'] ?></h2>
				<div class="bio">
					<?php echo apply_filters('the_content', $t['bio']) ?>
				</div>
			</div>
			<?php if($t['email']) : ?>
			<div class="row mobile-padded">
				<a href="mailto:<?php echo $t['email'] ?>" class="email-link"><?php echo $t['email'] ?></a>
			</div>
			<?php endif; ?>
		</div>
	</div>	
	<?php endforeach; ?>	

<?php get_footer();