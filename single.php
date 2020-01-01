<?php get_header();

$da_headline = get_field('headline');
$da_content = get_field('content');
$uh = get_field('use_hero');

if ($uh == true) {
    pagehero($post->ID);
    $headclass = 'section-heading';
} else {
    $headclass = 'page-title';
}
?>

    <div id="top-content" class="row <?php if (!$da_content) : echo 'no-bottom'; endif; ?>">
        <div class="center-col single-post">
            <h1 class="<?php echo $headclass; ?>"><?php
                if ($da_headline) {
                    echo $da_headline;
                } else {
                    echo get_the_title();
                }
                ?></h1>
            <?php if ($da_content) {
                echo apply_filters('the_content', $da_content);
            } ?>
        </div>
    </div>
    <div class="row main-content">
        <div class="container">
            <div class="meta">
                <small>
                    Posted <?php the_time('l, F jS, Y') ?> under <?php the_category(', ') ?>.
                </small>
            </div>
            <?php if (has_post_thumbnail(get_the_ID())): ?>
                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail'); ?>
                <span class="featured-img" style="background-image: url('<?php echo $image[0]; ?>')"></span>
            <?php endif; ?>
            <div class="content">
                <?php the_content(); ?>
            </div>
            <div class="navigation"><p><?php posts_nav_link('&mdash;','< Previous Post','Next Post >'); ?></p></div>
        </div>
    </div>

<?php get_footer(); ?>