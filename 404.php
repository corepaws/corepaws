<?php

// Get custom 404 template
$post = get_post(1734);

// Set content variable
if ($post) {
    $content = apply_filters('the_content', $post->post_content);
    $content = str_replace(']]>', ']]&gt;', $content);
}

get_header(); ?>

<div id="top-content" class="row">
    <div class="center-col">
        <?php if($post) : ?>
            <h1 class="page-title">
                <?php echo $post->post_title; ?>
            </h1>
            <?php echo $content; ?>
        <?php else : ?>
            <div id="top-content" class="row">
                <div class="center-col">
                    <h1 class="page-title">Oh No 404!</h1>
                    <p>Content Not Found</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
