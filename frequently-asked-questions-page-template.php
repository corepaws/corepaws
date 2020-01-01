<?php /* Template Name: FAQs */ ?>

<?php get_header();

$da_headline = get_field('headline') ? get_field('headline') : null;
$da_content = get_field('content') ? get_field('content') : "";

$uh = true;//get_field('use_hero');
if ($uh == true) {
    pagehero($post->ID);
    $headclass = 'section-heading';
} else {
    $headclass = 'page-title';
}

?>
<?php the_post(); ?>

    <div id="top-content" class="row <?php if (!$da_content) : echo 'no-bottom'; endif; ?>">
        <div class="center-col">
            <?php if ($da_headline) : ?>
                <h1 class="<?php echo $headclass; ?>"><?php

                    if ($da_headline) {
                        echo $da_headline;
                    } else {
                        echo get_the_title();
                    }

                    ?>
                </h1>
            <?php endif; ?>
            <?php if ($da_content) {
                echo apply_filters('the_content', $da_content);
            } ?>
        </div>
    </div>
	<div class="faq row">
		<div class="container">
			<?php
			if(have_rows('faq')){
				while (have_rows('faq')){
					the_row();
					?>
					<div class="group">
						<h3 class="section-heading question"><?php echo get_sub_field('question'); ?></h3>
						<div class="answer"><?php echo get_sub_field('answer'); ?></div>
					</div>		
					<?php
				}
			}
			?>
				
		</div>
		
		<?php // get_sidebar('featured'); ?>
		
	</div>

<?php get_footer(); ?>