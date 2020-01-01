<?php
/*
	soclinks()
	pagehero($id)
	vidbloc()
	infoblocks($id)
	petsblocks$id)
	testimonials_block()
	two_buckets()
	pet_line()
    blog_roll()

*/

// give us those social icons then
function soclinks()
{
    $sl = get_field('social_links', 'Options');
    if (empty($sl)) {
        return;
    } ?>
    <div class="social-bar">
        <p class="follow-us-text">FOLLOW US</p>
        <img class="follow-us" src="<?php echo THEME; ?>/img/social/title.png">
        <div class="follow-icons">
            <?php foreach ($sl as $coun => $s) : ?>
                <a href="<?php echo $s['link'] ?>" class="<?php echo $s['icon']; ?>" target="_blank"><i
                            class="fa fa-<?php echo $s['icon'] ?>"></i></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}


// gimme a random banner image from the pile
// function pagehero($headline,$cta_content,$cta_headline,$cta_link) {
function pagehero($q)
{
    $headline = get_field('hero_headline', $q) ? get_field('hero_headline', $q) : get_the_title($q);
    $cta_content = get_field('cta_content', $q) ? get_field('cta_content', $q) : null;
    $cta_label = get_field('cta_headline', $q) ? get_field('cta_headline', $q) : null;
    $cta_type = get_field('cta_type', $q);
    $bgs = get_field('background_images', $q);

    if ($cta_label) :
        if ($cta_type == 'site') :        // on-site link
            $clink = get_field('cta_link', $q);
            $clink = get_permalink($clink[0]->ID);
            $cta_link = '<a class="button orange" href="' . $clink . '">' . $cta_label . '</a>';
        elseif ($cta_type == 'out') :    // off-site link
            $clink = get_field('cta_url', $q);
            $cta_link = '<a class="button orange" target="_blank" href="' . $clink . '">' . $cta_label . '</a>';
        elseif ($cta_type == 'vid') :    // youtube lightbox
            $clink = get_field('youtube_url', $q);
            $clink = get_yt($clink);
            $cta_link = '<a class="button orange yt-lb" target="_blank" yt-id="' . $clink . '">' . $cta_label . '</a>';
        endif;
    endif;

    if (!$bgs) :
        $page_hero = get_field('pet_gallery', 'Options');
        $ph_r = count($page_hero);
        $bgs_r = $page_hero[array_rand($page_hero, 1)]; // get random BG
        $ph_r = rand(0, $ph_r - 1);
        $page_hero = $page_hero[$ph_r]['sizes']['page-hero'];
    endif; ?>

    <div id="hero"
         class="row"<?php /* if(!$bgs) : ?> style="background-image:url('<?php echo $page_hero; ?>');"<?php endif; */ ?>>

        <?php $immg = $bgs ? $bgs[0]['image']['url'] : $bgs_r['url']; ?>
        <div class="bg-frame">
            <?php /*<div class="caro"> // groundwork for carousel bg in header
					foreach($bgs as $coun => $bg) : */ ?>
            <div class="cell" style="background-image:url('<?php echo $immg; ?>');background-attachment:fixed;">
                <img src="<?php echo $immg; ?>"/>
            </div>
        </div>

        <div id="hero-overlay">
            <div class="container">
                <?php
                echo '<div class="content">';
                if ($headline) : echo '<h1>' . strip_tags($headline) . '</h1>'; endif;
                if ($cta_content) : echo '<p>' . strip_tags($cta_content) . '</p>'; endif;
                echo '</div>';
                if ($cta_label && $cta_link) :
                    echo '<div class="hero-cta">';
                    echo $cta_link;
                    echo '</div>';
                endif;
                ?>
            </div>
        </div>
    </div>
    <?php
}


// give us the content block for video then
function vidbloc($vid_img, $vid_id, $scon, $scta, $slink, $shl)
{
    ?>
    <div class="row">
        <div class="center-col">
            <div class="mobile-padded row centered mobile-only">
                <?php if ($shl) : ?>
                    <h2 class="section-heading"><?php echo $shl; ?></h2>
                <?php endif; ?>
                <?php echo apply_filters('the_content', $scon); ?>
            </div>
            <div class="half-col">
                <div class="light-back arrow">
                    <a class="video yt-lb" yt-id="<?php echo $vid_id; ?>">
                        <img class="video-thumb" src="<?php echo $vid_img['url']; ?>"/>
                    </a>
                </div>
            </div>
            <?php if ($scta && $slink) : ?>
                <div class="mobile-padded row centered mobile-only">
                    <a href="<?php echo get_permalink($slink[0]->ID); ?>" class="more"><?php echo $scta; ?> <span
                                class="carrot">&rsaquo;</span></a>
                </div>
            <?php endif; ?>
            <?php ?>
            <div class="half-col non-mobile">
                <?php if ($shl) : ?>
                    <h2 class="section-heading non-mobile"><?php echo $shl; ?></h2>
                <?php endif; ?>
                <?php echo apply_filters('the_content', $scon); ?>
                <?php if ($scta && $slink) : ?>
                    <a href="<?php echo get_permalink($slink[0]->ID); ?>" class="more"><?php echo $scta; ?><span
                                class="carrot">›</span></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}


// give us them infoblocks den
function infoblocks($q)
{
    foreach ($q as $coun => $p) :
        $la = array_key_exists('cta_label', $p) ? $p['cta_label'] : null;
        $li = array_key_exists('cta_link', $p) ? $p['cta_link'] : null;
        $qu = array_key_exists('quote', $p) ? $p['quote'] : null;
        $rm = array_key_exists('link', $p) ? $p['link'] : null;

        if ($qu) :
            add_shortcode('quote', function () use ($qu) {
                $str = '<p class="quote-intro">' . $qu['intro'] . '</p>';
                $str .= '<p class="quote">' . $qu['content'] . '</p>';
                return $str;
            });
        endif;
        ?>

        <div class="row info-block">
            <div class="center-col">
                <div class="left-col">
                    <img class="full-img" src="<?php echo $p['image']['sizes']['info-block'] ?>">
                </div>
                <div class="right-col mobile-padded">
                    <h2 class="section-heading"><?php echo $p['name']; ?></h2>
                    <?php echo apply_filters('the_content', $p['content']); ?>
                    <?php if ($la && $li) : ?>
                        <p><a href="<?php echo $li; ?>" class="button blue anchor"><?php echo $la; ?></a></p>
                    <?php endif; ?>
                    <?php if ($rm) : ?>
                        <p><a href="<?php echo $rm; ?>" class="button blue anchor">Read More</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endforeach;
}


// let's have those pet posts nigel
function petsblocks($q)
{ ?>
    <div class="pets row info-block">
        <div class="container">
            <?php foreach ($q as $coun => $p) : ?>

                <div class="cols">
                    <h2 class="section-heading"><?php echo $p->post_title; ?></h2>
                    <?php echo get_the_post_thumbnail($p->ID, 'info-block'); ?>
                    <?php echo apply_filters('the_content', $p->post_excerpt); ?>
                    <a class="button blue" href="<?php echo get_permalink($p->ID); ?>">Read More</a>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
<?php }


// let's have that testimonials block
function testimonials_block()
{
    $title = get_field('tml_title', 'Options');
    $content = get_field('tml_content', 'Options');
    $quos = get_field('quotes', 'Options');
    $fcta = get_field('footer_ctas', 'Options');
    $sblk = get_field('show_blocks');

    ?>
    <div class="row padded-section light-back<?php
    if (in_array('buc', $sblk) || in_array('b2c', $sblk)) {
        echo ' arrow-down';
    } else {
        echo ' no-bottom-margin';
    }
    ?>" id="testimonials">
        <div class="center-col centered mobile-padded">
            <h2 class="section-heading"><?php echo $title; ?></h2>
            <?php /* <p class="mobile-only">What our Resource &amp; Shelter Partners Say</p> -->*/
            echo apply_filters('the_content', $content); ?>
            <hr class="strong">
            <div id="testimonial-slides">
                <?php foreach ($quos as $coun => $q) : ?>
                    <div>
                        <p class="testimonial">“<?php echo $q['quote']; ?>”</p>
                        <p class="name">- <?php echo $q['attribution']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr class="strong">
            <span id="tesimonial-dots"></span>
        </div>
    </div>
    <?php
}


// let's have those two buckets then
function two_buckets()
{
    $h = get_post(get_option('page_on_front'));
    $lbe = get_field('latest_blog_entry', $h->ID);
    $whats_new_subtitle = $lbe['title']; // get_field('subtitle', $wd);
    $whats_new_blurb = $lbe['blurb'];
    $whats_new_cta = $lbe['link']; // get_field('cta_label', $wd);
    $wn_img = $lbe['thumbnail']; // get_the_post_thumbnail($wd);

    $argos = array(
        'post_type' => 'pet',
        'orderby' => 'rand',
        'posts_per_page' => '1'
    );
    $feat_pet = get_posts($argos);
    if ($feat_pet) {
        $feto = $feat_pet[0];
        $fd = $feto->ID;
        $fd_name = $feto->post_name;// get_field('name', $fd);
        $fd_location = get_field('location', $fd);
        $fd_nickname = get_field('nickname', $fd);
        $fd_age = get_field('age', $fd);
        $fd_content = $feto->post_excerpt;// get_field('content', $fd);
        $fd_img = get_the_post_thumbnail($fd, 'thumbnail');

        ?>
        <div class="row two-buckets">
            <div class="center-col mobile-padded">
                <div class="half-col">
                    <h2 class="section-heading"><span>Featured pet</span>
                        <span class="heading-icon ">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="720px" height="720px" viewBox="0 0 720 720" enable-background="new 0 0 720 720" xml:space="preserve">
                                <path fill="currentColor" d="M360,46.8l85.968,241.992H676.8L488.448,430.92l67.355,249.408L360,530.784L164.232,680.328l67.32-249.408 L43.164,288.792h230.832L360,46.8z"></path>
                            </svg>
                        </span>
                    </h2>
                    <div class="preview-box light-back">
                        <?php echo $fd_img; ?>
                        <div class="preview-text">
                            <h2><?php echo $fd_name; ?></h2>
                            <hr>
                            <?php if ($fd_nickname) : ?>
                                <p class="no-margin">
                                    <span class="inline-title">nickname: </span><?php echo $fd_nickname; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($fd_age) : ?>
                                <p class="no-margin">
                                    <span class="inline-title">age: </span><?php echo $fd_age; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($fd_content) :
                                echo apply_filters('the_content', words_to($fd_content, 22));
                            endif; ?>
                        </div>
                        <a href="<?php echo get_permalink($fd); ?>" class="button blue">Learn More</a>
                    </div>
                </div>
                <div class="half-col">
                    <h2 class="section-heading non-mobile">
                        <span>What's new</span>
                        <span class="heading-icon">
                            <svg width="65px" height="68px" viewBox="0 0 65 68" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Group</title>
                                <desc>Created with Sketch.</desc>
                                <defs></defs>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g fill-rule="nonzero" fill="currentColor">
                                        <path d="M8.043,66.439 C15.958,70.153 19.42,58.769 31.816,58.769 C43.768,58.769 47.004,70.149 55.596,66.439 C63.197,63.158 43.138,21.413 32.038,21.44 C22.742,21.464 0.025,62.679 8.043,66.439" id="Shape"></path>
                                        <path d="M55.162,31.719 C59.681,32.115 63.662,28.773 64.058,24.257 C64.453,19.741 61.111,15.76 56.594,15.365 C52.076,14.97 48.094,18.31 47.698,22.826 C47.304,27.342 50.646,31.323 55.162,31.719" id="Shape"></path>
                                        <path d="M41.388,17.097 C45.905,17.492 49.887,14.151 50.282,9.635 C50.678,5.119 47.336,1.138 42.818,0.743 C38.301,0.348 34.319,3.688 33.924,8.204 C33.527,12.72 36.869,16.702 41.388,17.097" id="Shape"></path>
                                        <path d="M9.284,31.719 C4.767,32.115 0.784,28.773 0.389,24.257 C-0.007,19.741 3.335,15.76 7.853,15.365 C12.371,14.97 16.353,18.31 16.748,22.826 C17.144,27.342 13.803,31.323 9.284,31.719" id="Shape"></path>
                                        <path d="M23.06,17.097 C18.541,17.492 14.56,14.151 14.164,9.635 C13.769,5.119 17.11,1.138 21.629,0.743 C26.146,0.348 30.127,3.688 30.524,8.204 C30.918,12.72 27.576,16.702 23.06,17.097" id="Shape"></path>
                                    </g>
                                </g>
                            </svg>
                        </span>
                    </h2>
                    <h2 class="mobile-only mobile-padded section-heading"><?php echo $whats_new_subtitle; ?></h2>
                    <div class="preview-box light-back">
                        <img src="<?php echo $wn_img['sizes']['thumbnail']; ?>" alt="">
                        <div class="preview-text">
                            <h2 class="non-mobile"><?php echo $whats_new_subtitle; ?></h2>
                            <hr class="non-mobile">
                            <?php echo apply_filters('the_content', $lbe['blurb']); ?>
                        </div>
                        <a href="<?php echo $whats_new_cta; ?>" class="button blue">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="row">
            <div class="col">
                <div class="alert info">
                    <p>
                        You haven't added any adoptable pets yet. Add one to get started!
                    </p>
                </div>
            </div>
        </div>
        <?php
    }
}


// let's have that random critter strip
function pet_line()
{
    $pets = get_field('pet_gallery', 'options');
    shuffle($pets);
    $pets = array_slice($pets, 0, 7);
    if (count($pets) > 0) {
        ?>
        <div class="row" id="photo-strip">
            <?php foreach ($pets as $coun => $p) : ?>
                <img src="<?php echo $p['sizes']['pet-line']; ?>" alt="">
            <?php endforeach; ?>
        </div>
        <?php
    }
}
