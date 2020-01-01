<?php get_header();

$queried_object = get_queried_object();

$da_headline = get_field('headline', $queried_object->ID);
$da_content = get_field('content', $queried_object->ID);
$title = get_the_title($queried_object->ID);
$uh = get_field('use_hero', $queried_object->ID);

if ($uh == true) {
    pagehero($queried_object->ID);
    $headclass = 'section-heading';
} else {
    $headclass = 'page-title';
}

// Pagination setup
$args = array(
    'prev_next' => true,
    'prev_text' => __('< Back'),
    'next_text' => __('Next >'),
    'type' => 'list',
);

if ($uh !== true) : ?>
    <div id="top-content" class="row <?php if (!$da_content) : echo 'no-bottom'; endif; ?>">
        <div class="center-col">
            <h1 class="<?php echo $headclass; ?>"><?php
                if ($da_headline) {
                    echo $da_headline;
                } else {
                    echo $title;
                }
                ?></h1>
            <?php if ($da_content) {
                echo apply_filters('the_content', $da_content);
            } ?>
        </div>
    </div>
<?php endif; ?>
    <div class="row main-content">
        <div class="container overflow">
            <?php while (have_posts()) : the_post(); ?>
                <a href="<?php echo get_permalink(); ?>" class="post-link">
                    <span class="post">
                        <?php if (has_post_thumbnail(get_the_ID())): ?>
                            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail'); ?>
                            <span class="featured-img" style="background-image: url('<?php echo $image[0]; ?>')"></span>
                        <?php endif; ?>
                        <span class="content">
                            <span class="section-heading">
                                <?php echo the_title(); ?>
                            </span>
                            <span class="meta">
                                <small>Posted <?php the_time('l, F jS, Y') ?></small>
                            </span>
                            <span class="excerpt">
                                <?php the_excerpt(); ?>
                            </span>
                            <span class="read-more">
                                <span class="more">Read more ></span>
                            </span>
                        </span>
                    </span>
                </a>
            <?php endwhile; ?>
        </div>
        <div class="paginate-wrapper">
            <?php echo paginate_links($args); ?>
        </div>
    </div>
<?php get_footer(); ?>