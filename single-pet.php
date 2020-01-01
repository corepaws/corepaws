<?php /* Single: Adoption Details Page */

// Determine the DOB and current year
$dob = DateTime::createFromFormat('m/d/Y', get_field('dob'));
$now = new DateTime(date('d-m-Y'));

// Get the relative age
if ($dob) {
    $age = $now->diff($dob);
}
?>
<?php get_header(); ?>
<?php the_post(); ?>

    <main id="result">
        <div class="container">

            <?php
            $images = get_field('gallery');
            if (is_array($images) && count($images) > 0) {
                $count = 1;
                $gallery = [];
                foreach ($images as $image) {
                    $gallery[$count]['url'] = $image['url'];
                    $gallery[$count]['thumbnail'] = $image['sizes']['thumbnail'];
                    $gallery[$count]['alt'] = $image['alt'];
                    $gallery[$count]['data'] = $count - 1;
                    $count++;
                }
                ?>
                <div id="gallery">
                    <div class="carousel">
                        <?php
                        for ($x = 1; $x <= count($gallery); $x++) {
                            echo "<div class='slide'><img src='" . $gallery[$x]['url'] . "' alt='" . $gallery[$x]['alt'] . "'/></div>";
                        }
                        ?>
                    </div>
                    <div class="thumbnails">
                        <?php
                        for ($x = 1; $x <= count($gallery); $x++) {
                            echo "<div class='thumb' data-thumb='" . $gallery[$x]['data'] . "'><img src='" . $gallery[$x]['thumbnail'] . "' alt='" . $gallery[$x]['alt'] . "'/></div>";
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div id="gallery">
                    <div class="alert info">
                        <p>
                            No gallery images added. Add some gallery images to see them here.
                        </p>
                    </div>
                </div>
                <?php
            } ?>

            <div id="details">
                <h1 class="section-heading"><?php the_title(); ?></h1>
                <div class="group nickname"><span>Nickname: </span><?php the_field('nickname'); ?></div>
                <?php if (isset($age)) : ?>
                    <div class="group age">
                        <span>Age: </span><?php echo $age->y > 0 ? ($age->y > 1 ? $age->y . ' years' : $age->y . ' year') : ''; ?><?php echo $age->m > 0 ? ', ' . ($age->m > 1 ? $age->m . ' months ' : $age->m . ' month ') : ''; ?>
                        old
                    </div>
                <?php endif; ?>
                <?php $gnd = get_field('gender');
                if ($gnd == 'male' || $gnd == 'female') : ?>
                    <div class="group gender"><span>Gender: </span><?php echo $gnd; ?></div>
                <?php endif; ?>
                <div class="group arrived"><span>Available Since: </span><?php the_date(); ?></div>
                <div class="group tags"><span>Tags: </span>
                    <?php // Pulls Taxonomy
                    $taxonomy = wp_get_post_terms($post->ID, 'reason_for_placement');
                    if (count($taxonomy) >= 1) {
                        $term_list = "";
                        foreach ($taxonomy as $term) {
                            $term_list .= $term->name . ", ";
                        }
                        echo rtrim($term_list, ", ");
                    }
                    ?>
                </div>
                <div class="group description">
                    <h3>Description:</h3>
                    <?php the_content(); ?>
                </div>
                <a class="btn-large" href="<?php echo bloginfo('url') . "/adoption/"; ?>">Back to Gallery</a>

            </div>

        </div>
    </main>

<?php get_footer(); ?>